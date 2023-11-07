<?php

namespace App\Repositories;

use App\Models\Support;
use App\Models\User;
use App\Repositories\Traits\RepositoryTraits;

class SupportsRepository
{
    use RepositoryTraits;
    protected $entity;

    public function __construct(Support $model)
    {
        $this->entity = $model;
    }

    public function getMySupports($filters = [])
    {
        $filters['user'] = true;

        return $this->getSupports($filters);
    }

    public function getSupports($filters = [])
    {
        return $this->entity
            ->where(function ($query) use ($filters) {
                if (isset($filters['lesson'])) {
                    $query->where('lesson_id', '=', $filters['lesson']);
                }

                if (isset($filters['status'])) {
                    $query->where('status', '=', $filters['status']);
                }

                if (isset($filters['user'])) {
                    $user = $this->getUserAuth();
                    $query->where('user_id', '=', $user->id);
                }

                if (isset($filters['filter'])) {
                    $filter = $filters['filter'];
                    $query->where('description', 'ILIKE', "%{$filter}%");
                }

                if (isset($filters['supportId'])) {
                    $query->where('id', '=', $filters['supportId']);
                }
            })
            ->with('replies')
            ->orderBy('updated_at')
            ->get();
    }

    public function createNewSupport($data)
    {
        $support = $this->getUserAuth()
            ->supports()
            ->create([
                'lesson_id' => $data['lesson'],
                'description' => $data['description'],
                'status' => $data['status'],
            ]);

        return $support;
    }

    public function createReplyToSupportId($supportId, $data)
    {
        $user = $this->getUserAuth();

        return $this->getSupport($supportId)
            ->replies()
            ->create([
                'description' => $data['description'],
                'user_id' => $user->id
            ]);
    }

    private function getSupport($supportId)
    {
        return $this->entity
            ->with('replies')
            ->findOrFail($supportId);
    }

    public function updateSupport($dataSupport, $id)
    {
        $user = $this->getUserAuth();

        return $this->entity
            ->where('id', '=', $id)
            ->where('user_id', '=', $user->id)
            ->update([
                'lesson_id' => $dataSupport['lesson'],
                'status' => $dataSupport['status'],
                'description' => $dataSupport['description']
            ]);
    }
}

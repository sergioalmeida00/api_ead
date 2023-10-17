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

    public function getSupports($filters = [])
    {

        return $this->getUserAuth()
            ->supports()
            ->where(function ($query) use ($filters) {
                if (isset($filters['lesson'])) {
                    $query->where('lesson_id', '=', $filters['lesson']);
                }

                if (isset($filters['status'])) {
                    $query->where('status', '=', $filters['status']);
                }

                if (isset($filters['filter'])) {
                    $filter = $filters['filter'];
                    $query->where('description', 'ILIKE', "%{$filter}%");
                }
            })
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
        return $this->entity->findOrFail($supportId);
    }
}

<?php

namespace App\Repositories;

use App\Models\Support;
use App\Models\User;

class SupportsRepository
{

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

    private function getUserAuth()
    {
        return User::first();
    }
}

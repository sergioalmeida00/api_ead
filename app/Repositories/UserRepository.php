<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $entity;

    public function __construct(User $model)
    {
        $this->entity = $model;
    }

    public function register($data)
    {
        return $this->entity->create([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function findOne($id)
    {
        return $this->entity->where('id', '=', $id)->firstOrFail();
    }

    public function findAll($userId)
    {
        return $this->entity->where(function ($query) use ($userId) {
            if (!empty($userId)) {
                return $query->where('id', '=', $userId)->first();
            }
        })->get();
    }

    public function updateUser($data, $id)
    {
        $updateData = [
            'email' => $data['email'],
            'name' => $data['name']
        ];

        if (isset($data['password'])) {
            $updateData['password'] = $data['password'];
        }

        return $this->entity
            ->where('id', '=', $id)
            ->update($updateData);
    }
}

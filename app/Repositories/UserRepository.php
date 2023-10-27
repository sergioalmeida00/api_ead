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
}

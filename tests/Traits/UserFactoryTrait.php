<?php

namespace Tests\Traits;

use App\Models\User;

trait UserFactoryTrait
{
    public function createUser($attributes = [])
    {
        return User::factory()->create($attributes);
    }

    public function createTokenUser()
    {
        $user = $this->createUser();

        $token = $user->createToken('teste')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function defaultHeaders()
    {
        ['user' => $user, 'token' => $token] = $this->createTokenUser();

        return [
            'Authorization' => "Bearer {$token}",
        ];
    }
}

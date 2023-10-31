<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_create_user_invalidation()
    {
        $invalidPayloads = [
            ['email' => '', 'name' => '', 'password' => ''],
            ['email' => 'teste@gmail.com', 'name' => 'teste', 'password' => '1234'],
        ];

        foreach ($invalidPayloads as $payload) {
            $response = $this->postJson('/register', $payload);
            $response->assertStatus(422);
        }
    }
}

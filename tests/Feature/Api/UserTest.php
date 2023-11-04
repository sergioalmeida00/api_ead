<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserFactoryTrait;

class UserTest extends TestCase
{
    use UserFactoryTrait, DatabaseTransactions;

    public function test_create_user_invalidation()
    {
        $invalidPayloads = [
            ['email' => '', 'name' => '', 'password' => ''],
            ['email' => 'teste@gmail.com', 'name' => 'teste', 'password' => '1234'],
            ['email' => 'teste@gmail.com', 'name' => 'teste', 'password' => '1234567891011'],
        ];

        foreach ($invalidPayloads as $payload) {
            $response = $this->postJson('/register', $payload);
            $response->assertStatus(422);
        }
    }

    public function test_create_user_with_unique_email()
    {
        User::factory()->create([
            'email' => 'teste@gmail.com',
        ]);

        $newUserPayload = [
            'name' => 'Novo Usuário',
            'email' => 'teste@gmail.com',
            'password' => 'senha123',
        ];

        $response = $this->postJson('/register', $newUserPayload);

        $response->assertStatus(422);
    }

    public function test_create_user()
    {
        $payload = [
            'email' => 'teste@gmail.com', 'name' => 'test name', 'password' => '1234456',
        ];

        $response = $this->postJson('/register', $payload);
        $response->assertStatus(201);
    }

    public function test_list_user()
    {
        $totalUser = User::count();
        User::factory()->count(10)->create();
        ['user' => $user, 'token' => $token] = $this->createTokenUser();

        $response = $this->getJson('/user', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount($totalUser + 11, 'data');
    }
}

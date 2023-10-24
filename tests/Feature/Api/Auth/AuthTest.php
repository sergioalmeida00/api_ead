<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserFactoryTrait;

class AuthTest extends TestCase
{
    use DatabaseTransactions, UserFactoryTrait;

    public function test_fail_auth()
    {
        $response = $this->postJson('/auth', []);

        $response->assertStatus(422);
    }

    public function test_auth()
    {
        $user = $this->createUser();

        $response = $this->postJson('/auth', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'Test Auth'
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'token',
            ],
        ]);
    }

    public function test_error_logout()
    {
        $response = $this->postJson('/logout');

        $response->assertStatus(401);
    }

    public function test_logout()
    {
        // Crie um usuário de teste
        $user = $this->createUser();

        // Autentique o usuário
        $token = $this->createTokenUser();

        // Faça a solicitação de logout autenticada
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/logout');

        $response->assertStatus(204);
    }
}

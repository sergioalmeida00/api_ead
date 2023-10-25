<?php

namespace Tests\Feature\Api;

use App\Models\Support;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserFactoryTrait;

class ReplySupportTest extends TestCase
{
    use UserFactoryTrait, DatabaseTransactions;

    public function test_create_reply_to_support_unauthenticated()
    {
        $payload = ['supportId' => '679f78c8-77f7-40d7-8845-7556f78f0b50', 'description' => 'test description reply support'];

        $response = $this->postJson('/replies', $payload);

        $response->assertStatus(401);
    }


    public function test_create_reply_to_support_validation()
    {
        $invalidPayloads = [
            ['description' => 'test description reply support'],
            ['supportId' => '679f78c8-77f7-40d7-8845-7556f78f0b50'],
            [],
        ];

        foreach ($invalidPayloads as $payload) {
            $response = $this->postJson('/replies', $payload, $this->defaultHeaders());
            $response->assertStatus(422);
        }
    }

    public function test_create_reply_to_support()
    {
        $support = Support::factory()->create();

        $payload = [
            'supportId' => $support->id,
            'description' => 'test description reply support'
        ];

        $response = $this->postJson('/replies', $payload, $this->defaultHeaders());

        $response->assertStatus(201);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use App\Models\Module;
use App\Models\Support;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserFactoryTrait;

class SupportTest extends TestCase
{
    use UserFactoryTrait, DatabaseTransactions;

    public function test_get_my_supports_unauthenticated()
    {
        $response = $this->getJson('/my-supports');

        $response->assertStatus(401);
    }

    public function test_get_my_supports()
    {
        ['user' => $user, 'token' => $token] = $this->createTokenUser();

        $module = Module::factory()->create();
        $lesson = Lesson::factory()->create([
            'module_id' => $module->id
        ]);

        Support::factory()->count(50)->create([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id
        ]);

        Support::factory()->count(50)->create();

        $response = $this->getJson('/my-supports', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(50, 'data');
    }

    public function test_get_supports()
    {
        Support::factory()->count(50)->create();

        $response = $this->getJson('/supports', $this->defaultHeaders());

        $response->assertStatus(200);
        $response->assertJsonCount(50, 'data');
    }


    public function test_create_support_unauthenticated()
    {
        $response = $this->getJson('/my-supports');

        $response->assertStatus(401);
    }

    public function test_get_supports_filter_lesson()
    {
        $lesson = Lesson::factory()->create();

        Support::factory()->count(50)->create();
        Support::factory()->count(10)->create([
            'lesson_id' => $lesson->id,
        ]);

        $payload = ['lesson' => $lesson->id, 'status' => 'P'];

        $response = $this->json('GET', '/supports', $payload, $this->defaultHeaders());

        $response->assertStatus(200)
                    ->assertJsonCount(10, 'data');
    }

    public function test_create_support()
    {
        $lesson = Lesson::factory()->create();

        $payload = [
            'lesson' => $lesson->id,
            'status' => 'P',
            'description' => 'Description Test',
        ];

        $response = $this->postJson('/supports', $payload, $this->defaultHeaders());

        $response->assertStatus(201);
    }
}

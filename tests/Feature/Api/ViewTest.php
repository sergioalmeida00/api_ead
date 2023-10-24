<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserFactoryTrait;

class ViewTest extends TestCase
{
    use UserFactoryTrait, DatabaseTransactions;

    public function test_make_viewed_unauthorized()
    {
        $response = $this->postJson('/lessons/viewed');

        $response->assertStatus(401);
    }

    public function test_make_viewed_error_validator()
    {
        $payload = [];
        $response = $this->postJson('/lessons/viewed', $payload, $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_make_viewed_invalid_lesson()
    {
        $payload = ['lesson_id' => "679f78c8-77f7-40d7-8845-7556f78f0b50"];

        $response = $this->postJson('/lessons/viewed', $payload, $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_make_viewed()
    {
        $module = Module::factory()->create();
        $lesson = Lesson::factory()->create([
            'module_id' => $module->id
        ]);

        $payload = ['lesson_id' => $lesson->id];

        $response = $this->postJson('/lessons/viewed', $payload, $this->defaultHeaders());

        $response->assertStatus(201);
    }
}

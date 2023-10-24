<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserFactoryTrait;

class LessonTest extends TestCase
{
    use UserFactoryTrait, DatabaseTransactions;

    public function test_lesson_unauthenticated()
    {
        $response = $this->getJson('/modules/b46fa5d2-a733-4801-aa4e-33e1ef22c7c1/lessons');

        $response->assertStatus(401);
    }

    public function test_get_modules_lesson_not_found()
    {
        $response = $this->getJson('/modules/b46fa5d2-a733-4801-aa4e-33e1ef22c7c1/lessons', $this->defaultHeaders());

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function test_get_modules_lesson()
    {
        $course = Course::factory()->create();

        $module = Module::factory()->create([
            'course_id' => $course->id
        ]);

        $response = $this->getJson("/modules/{$module->id}/lessons", $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_get_lessons_of_module_total()
    {
        $totalLessons = Lesson::count();

        $module = Module::factory()->create();

        Lesson::factory()->count(10)->create([
            'module_id' => $module->id
        ]);

        $response = $this->getJson("/modules/{$module->id}/lessons", $this->defaultHeaders());

        $response->assertStatus(200);
        $response->assertJsonCount($totalLessons + 10, 'data');
    }

    public function test_get_single_lesson_unauthenticated()
    {
        $response = $this->getJson('/lessons/b46fa5d2-a733-4801-aa4e-33e1ef22c7c1');

        $response->assertStatus(401);
    }

    public function test_get_single_lesson_not_found()
    {
        $response = $this->getJson('/lessons/b46fa5d2-a733-4801-aa4e-33e1ef22c7c1', $this->defaultHeaders());

        $response->assertStatus(404);
    }

    public function test_get_single_lesson()
    {
        $module = Module::factory()->create();
        $lesson = Lesson::factory()->create([
            'module_id' => $module->id
        ]);

        $response = $this->getJson("/lessons/{$lesson->id}", $this->defaultHeaders());

        $response->assertStatus(200);
    }

}

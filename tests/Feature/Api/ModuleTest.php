<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserFactoryTrait;

class ModuleTest extends TestCase
{
    use UserFactoryTrait, DatabaseTransactions;

    public function test_module_unauthenticated()
    {
        $response = $this->getJson('/courses/b46fa5d2-a733-4801-aa4e-33e1ef22c7c1/modules');

        $response->assertStatus(401);
    }

    public function test_get_modules_course_not_found()
    {
        $response = $this->getJson('/courses/b46fa5d2-a733-4801-aa4e-33e1ef22c7c1/modules', $this->defaultHeaders());

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function test_get_modules_course()
    {
        $course = Course::factory()->create();

        $response = $this->getJson("/courses/{$course->id}/modules", $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_get_modules_course_total()
    {
        $course = Course::factory()->create();

        Module::factory()->count(10)->create([
            'course_id' => $course->id
        ]);

        $response = $this->getJson("/courses/{$course->id}/modules", $this->defaultHeaders());
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }
}

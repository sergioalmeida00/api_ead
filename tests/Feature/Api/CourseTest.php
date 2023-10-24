<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UserFactoryTrait;

class CourseTest extends TestCase
{

    use UserFactoryTrait, DatabaseTransactions;

    public function test_course_unauthenticated()
    {
        $response = $this->getJson('/courses');

        $response->assertStatus(401);
    }

    public function test_get_all_courses()
    {
        $response = $this->getJson('/courses', $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_get_all_courses_total()
    {
        $totalCourses = Course::count();

        Course::factory()->count(10)->create();

        $response = $this->getJson('/courses', $this->defaultHeaders());
        $response->assertStatus(200);
        $response->assertJsonCount($totalCourses + 10, 'data');
    }

    public function test_get_single_course_unauthenticated()
    {
        $response = $this->getJson('/courses/b46fa5d2-a733-4801-aa4e-33e1ef22c7c1');

        $response->assertStatus(401);
    }

    public function test_get_single_course_not_found()
    {
        $response = $this->getJson('/courses/b46fa5d2-a733-4801-aa4e-33e1ef22c7c1', $this->defaultHeaders());
        $response->assertStatus(404);
    }

    public function test_get_single_course()
    {
        $course = Course::factory()->create();

        $response = $this->getJson("/courses/{$course->id}", $this->defaultHeaders());
        $response->assertStatus(200);
    }
}

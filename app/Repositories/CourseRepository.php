<?php

namespace App\Repositories;

use App\Models\Course;
use App\Repositories\Traits\RepositoryTraits;

class CourseRepository
{
    use RepositoryTraits;
    protected $entity;

    public function __construct(Course $model)
    {
        $this->entity = $model;
    }

    public function getAllCourse()
    {
        return $this->entity->with('modules.lessons.views')->get();
    }

    public function getCourseById($identify)
    {
        return $this->entity->with('modules.lessons')->findOrFail($identify);
    }

    public function registerCourse($data)
    {
        return $this->entity->create($data);
    }

    public function updateCourse($data, $id)
    {
        return $this->entity
            ->where('id', '=', $id)
            ->update($data);
    }

    public function getCourseWatchedLessonCount($courseId)
    {
        $user = $this->getUserAuth();

        return $this->entity->select([
            'courses.id as course_id',
            'courses.name',
            'users.name as user_name',
            'users.email as email'
            ])
            ->leftJoin('modules', 'courses.id', '=', 'modules.course_id')
            ->leftJoin('lessons', 'modules.id', '=', 'lessons.module_id')
            ->leftJoin('views', function ($join) use ($user) {
                $join->on('lessons.id', '=', 'views.lesson_id')
                    // ->where('views.user_id', '=', $user->id);
                    ->where('views.user_id', '=', '37f8b13e-8453-4af1-a00c-1a777352c98c');
            })
            ->leftJoin('users', 'views.user_id', '=', 'users.id')
            ->where('courses.id', '=', $courseId)
            ->groupBy('courses.id', 'courses.name', 'users.name', 'users.email')
            ->selectRaw('COUNT(DISTINCT lessons.id) as total_lessons')
            ->selectRaw('COUNT(DISTINCT views.lesson_id) as lessons_watched')
            ->first()
            ->toArray();
    }
}

<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
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
}

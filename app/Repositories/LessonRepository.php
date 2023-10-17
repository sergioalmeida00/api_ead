<?php

namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository
{

    protected $entity;

    public function __construct(Lesson $model)
    {
        $this->entity = $model;
    }

    public function getLessonsByModuleId($moduleId)
    {
        return $this->entity->where('module_id', '=', $moduleId)->get();
    }

    public function getLesson($identify)
    {
        return  $this->entity->findOrFail($identify);
    }
}

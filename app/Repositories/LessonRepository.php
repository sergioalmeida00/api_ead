<?php

namespace App\Repositories;

use App\Models\Lesson;
use App\Repositories\Traits\RepositoryTraits;

class LessonRepository
{

    use RepositoryTraits;
    protected $entity;

    public function __construct(Lesson $model)
    {
        $this->entity = $model;
    }

    public function getLessonsByModuleId($moduleId)
    {
        return $this->entity
            ->with('supports.replies')
            ->where('module_id', '=', $moduleId)
            ->get();
    }

    public function getLesson($identify)
    {
        return  $this->entity
            ->with('supports.replies')
            ->where('id', '=', $identify)
            ->first();
    }

    public function markLessonViewed($lessonId)
    {
        $user = $this->getUserAuth();
        $view = $user->views()->where('lesson_id', '=', $lessonId)->first();

        if ($view) {
            return  $view->update([
                'qty' => $view->qty + 1
            ]);
        }

        return $user->views()->create([
            'lesson_id' => $lessonId
        ]);
    }

    public function registerLesson($dataLesson)
    {
        return $this->entity->create($dataLesson);
    }

    public function updateLesson($dataLesson, $lessonId)
    {
        return $this->entity
            ->where('id', '=', $lessonId)
            ->update($dataLesson);
    }
}

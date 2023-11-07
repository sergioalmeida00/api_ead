<?php

namespace App\Repositories;

use App\Models\Module;

class ModuleRepository
{

    protected $entity;
    public function __construct(Module $model)
    {
        $this->entity = $model;
    }

    public function getModuleByCourseId($courseId)
    {
        return $this->entity
            ->with('lessons.views')
            ->where('course_id', '=', $courseId)->get();
    }

    public function getModuleById($moduleId)
    {
        return $this->entity
            ->where('id', '=', $moduleId)
            ->first();
    }

    public function registerModule($dataModule)
    {
        return $this->entity->create([
            'name' => $dataModule['name'],
            'course_id' => $dataModule['courseId']
        ]);
    }

    public function updateModule($dataModule, $idModule)
    {
        return $this->entity->where('id', '=', $idModule)->update([
            'name' => $dataModule['name'],
            'course_id' => $dataModule['courseId']
        ]);
    }
}

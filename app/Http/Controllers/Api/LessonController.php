<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrUpdateLesson;
use App\Http\Requests\StoreViewed;
use App\Http\Resources\LessonResource;
use App\Http\Traits\ApiResponser;
use App\Repositories\LessonRepository;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    use ApiResponser;
    protected $repository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->repository = $lessonRepository;
    }

    public function index($moduleId)
    {
        $lessons = $this->repository->getLessonsByModuleId($moduleId);

        return LessonResource::collection($lessons);
    }

    public function show($lessonId)
    {
        return new LessonResource($this->repository->getLesson($lessonId));
    }

    public function viewed(StoreViewed $request)
    {
        $this->repository->markLessonViewed($request->lesson_id);
        return $this->success([], 'Aula Assistida', 201);
    }

    public function store(StoreOrUpdateLesson $request)
    {
        $dataLesson = $request->validated();
        return new LessonResource($this->repository->registerLesson($dataLesson));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrUpdateLesson;
use App\Http\Requests\StoreViewed;
use App\Http\Resources\LessonResource;
use App\Http\Traits\ApiResponser;
use App\Http\Traits\UploadFileTrait;
use App\Repositories\LessonRepository;

class LessonController extends Controller
{
    use ApiResponser, UploadFileTrait;
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
        $lesson = $this->repository->getLesson($lessonId);

        if (!$lesson) {
            return $this->error('Lesson is not Exist!', 404);
        }

        return new LessonResource($lesson);
    }

    public function viewed(StoreViewed $request)
    {
        $this->repository->markLessonViewed($request->lesson_id);
        return $this->success([], 'Aula Assistida', 201);
    }

    public function store(StoreOrUpdateLesson $request)
    {
        $dataLesson = $request->validated();

        if (isset($dataLesson['video'])) {
            $path = $this->uploadStore($request->video, 'lesson');
            $dataLesson['video'] = $path;
        }

        return new LessonResource($this->repository->registerLesson($dataLesson));
    }

    public function update(StoreOrUpdateLesson $request, $id)
    {
        $dataLesson = $request->only(['name', 'description', 'video', 'module_id']);

        $lesson = $this->repository->getLesson($id);

        if (!$lesson) {
            return $this->error('Lesson is not Exist!', 404);
        }

        if (isset($dataLesson['video'])) {
            $this->uploadRemove($lesson->video);
            $path = $this->uploadStore($dataLesson['video'], 'lesson');
            $dataLesson['video'] = $path;
        }

        $this->repository->updateLesson($dataLesson, $id);

        return $this->success(null, null, 204);
    }
}

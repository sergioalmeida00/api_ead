<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrUpdateCourse;
use App\Http\Resources\CourseResource;
use App\Repositories\CourseRepository;
use App\Http\Traits\ApiResponser as TraitsApiResponser;
use App\Http\Traits\UploadFileTrait;

class CourseController extends Controller
{
    use TraitsApiResponser, UploadFileTrait;

    protected $repositoryCourse;

    public function __construct(CourseRepository $repository)
    {
        $this->repositoryCourse = $repository;
    }

    public function index()
    {
        return CourseResource::collection($this->repositoryCourse->getAllCourse());
    }

    public function show($id)
    {
        return new CourseResource($this->repositoryCourse->getCourseById($id));
    }

    public function store(StoreOrUpdateCourse $request)
    {
        $dataCourse = $request->validated();

        if (isset($dataCourse['image'])) {
            $path = $this->uploadStore($request->image, 'course');
            $dataCourse['image'] = $path;
        }

        return new CourseResource($this->repositoryCourse->registerCourse($dataCourse));
    }

    public function update(StoreOrUpdateCourse $request, $id)
    {
        $dataCourse = $request->only(['name', 'description', 'image']);
        $courseExist = $this->repositoryCourse->getCourseById($id);

        if (!$courseExist) {
            $this->error('Course is not Exist!', 404);
        }

        if (isset($dataCourse['image'])) {
            $this->uploadRemove($courseExist->image);
            $path = $this->uploadStore($dataCourse['image'], 'course');
            $dataCourse['image'] = $path;
        }

        $this->repositoryCourse->updateCourse($dataCourse, $id);

        return $this->success(null, null, 204);
    }
}

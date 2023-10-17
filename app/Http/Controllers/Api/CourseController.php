<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;

class CourseController extends Controller
{

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
}

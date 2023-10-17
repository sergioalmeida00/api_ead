<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModuleResource;
use App\Repositories\ModuleRepository;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    protected $repositoryModule;

    public function __construct(ModuleRepository $repository)
    {
        $this->repositoryModule = $repository;
    }

    public function index($courseId)
    {
        $modules = $this->repositoryModule->getModuleByCourseId($courseId);

        return ModuleResource::collection($modules);
    }
}

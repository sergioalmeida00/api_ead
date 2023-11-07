<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrUpdateModules;
use App\Http\Resources\ModuleResource;
use App\Repositories\ModuleRepository;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponser as TraitsApiResponser;

class ModuleController extends Controller
{
    use TraitsApiResponser;

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

    public function store(StoreOrUpdateModules $request){
        $dataModule = $request->validated();

        return new ModuleResource($this->repositoryModule->registerModule($dataModule));
    }

    public function update(StoreOrUpdateModules $request, $id){
        $dataModule = $request->only(['name','courseId']);

        $module = $this->repositoryModule->getModuleById($id);

        if(!$module){
           return $this->error('Module is not Exist!', 404);
        }

        $this->repositoryModule->updateModule($dataModule, $id);

        return $this->success(null,null,204);
    }
}

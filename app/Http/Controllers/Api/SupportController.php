<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupport;
use App\Http\Resources\SupportResource;
use App\Http\Traits\ApiResponser;
use App\Repositories\SupportsRepository;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    use ApiResponser;
    protected $repository;

    public function __construct(SupportsRepository $supportsRepository)
    {
        $this->repository = $supportsRepository;
    }

    public function index(Request $request)
    {
        $supports = $this->repository->getSupports($request->all());

        return SupportResource::collection($supports);
    }

    public function store(StoreSupport $request)
    {
        $support = $this->repository
            ->createNewSupport($request->validated());

        return new SupportResource($support);
    }

    public function mySupports(Request $request)
    {
        $mySupports = $this->repository->getMySupports($request->all());

        return SupportResource::collection($mySupports);
    }

    public function update(StoreSupport $request, $id)
    {
        $filters['supportId'] = $id;
        $support = $this->repository->getSupports($filters);

        if (count($support) == 0) {
            return $this->error('Support is not Exist!', 404);
        }

        $dataSupport = $request->validated();
        $this->repository->updateSupport($dataSupport, $filters['supportId']);

        return $this->success(null, null, 204);
    }
}

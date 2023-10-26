<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplySupport;
use App\Http\Resources\ReplySupportResource;
use App\Repositories\ReplySupportsRepository;

class ReplySupportController extends Controller
{

    protected $repository;

    public function __construct(ReplySupportsRepository $replySupportRepository)
    {
        $this->repository = $replySupportRepository;
    }

    public function createReply(StoreReplySupport $request)
    {
        // dd($request->validated());
        $support = $this->repository->createReplyToSupportId($request->validated());

        return (new ReplySupportResource($support))->response()->setStatusCode(201);
    }
}

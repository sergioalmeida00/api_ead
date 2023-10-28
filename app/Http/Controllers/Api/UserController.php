<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\userResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponser as TraitsApiResponser;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use TraitsApiResponser;

    protected $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }
    public function register(RegisterUserRequest $request)
    {
        $user = $this->repository->register($request->all());
        $token = $user->createToken($user->name)->plainTextToken;

        return $this->success([
            'token' => $token,
            'user' => new userResource($user)
        ]);
    }

    public function update(RegisterUserRequest $request, $id)
    {
        $user = $this->repository->findOne($id);

        if (!$user) {
            return $this->error('User is not exists', 404);
        }

        $data = $request->only(['email', 'name']);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $this->repository->updateUser($data, $id);

        return $this->success([],'',204);
    }
}

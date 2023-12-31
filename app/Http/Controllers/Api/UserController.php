<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\userResource;
use App\Repositories\UserRepository;
use App\Http\Traits\ApiResponser as TraitsApiResponser;
use App\Http\Traits\ExportCsvTrait;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



class UserController extends Controller
{
    use TraitsApiResponser, ExportCsvTrait;

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
        ], '', 201);
    }

    public function listUsers($id = '')
    {
        $users = $this->repository->findAll($id);
        return userResource::collection($users);
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

        return $this->success([], '', 204);
    }

    public function exportCSV()
    {
        $users = $this->repository->findAll(null);
        $columns = ['ID', 'NOME', 'EMAIL'];

        $fileName = 'user.csv';

        $response = $this->exportData($users, $columns);

        Mail::to('sergioalmeidaa00@gmail.com')->send(new SendMail($response));

        return $response;
    }
}

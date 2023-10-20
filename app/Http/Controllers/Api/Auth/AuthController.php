<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\userResource;
use App\Http\Traits\ApiResponser as TraitsApiResponser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use TraitsApiResponser;

    public function auth(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // throw ValidationException::withMessages([
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);

            return $this->error('The provided credentials are incorrect.', 422);
        }

        $user->tokens()->delete();
        $token = $user->createToken($request->device_name)->plainTextToken;

        return $this->success([
            'token' => $token,
            'user' => new userResource($user)
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
    }
}

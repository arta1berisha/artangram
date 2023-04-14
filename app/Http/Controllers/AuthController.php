<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_private' => $request->is_private,
        ]);

        $token = auth()->attempt($request->only('email', 'password'));
        return $this->successResponse([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function login(AuthLoginRequest $request)
    {
        $token = auth()->attempt($request->validated());
        if (!$token) {
            return $this->errorResponse();
        }

        $user = auth()->user();
        return $this->successResponse([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
}

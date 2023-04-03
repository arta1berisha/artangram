<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Models\User;
use App\Traits\APIResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    use APIResponseTrait;
    public function register(AuthRegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $token = Auth::login($user);

        $token = auth()->attempt($request->only('email', 'password'));
        return $this->registerSuccessResponse(['user' => $user, 'token' => $token]);
    }

    public function login(AuthLoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        $token = auth()->attempt($credentials);
        if (!$token) {
            return $this->loginErrorResponse();
        }

        $user = Auth::user();
        return $this->loginSuccessResponse(['user' => $user, 'token' => $token]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\UpdateUserRequest;
use App\Traits\APIResponseTrait;

class UserController extends Controller
{

    use APIResponseTrait;
    
    public function index()
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    public function show($user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    public function delete(User $user)
    {
        if ($user->delete()) {
            return $this->deleteUserSuccessResponse();
        }

        return $this->deleteUserErrorResponse();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use App\Enums\FollowingStatusEnum;
use Illuminate\Contracts\Mail\Attachable;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;

class FollowController extends Controller
{

    public function follow(User $user)
    {
        if ($user->is_private === 1) {
            $user->followers()->attach(auth()->user()->id, (['status' => 'Pending']));

            return $this->successResponse('Your request to follow this user is Pending.');
        } else if ($user->is_private === 0) {
            $user->followers()->attach(auth()->user()->id);

            return $this->successResponse('You are now following this user');
        }
    }

    public function handleFollowerActions(Request $request, User $follower)
    {
        if (
            $request->status !== "Accepted" && $request->status !== "Rejected"
        ) {
            return $this->errorResponse('The status received is not supported', 400);
        }

        /** @var User */
        $user = auth()->user();

        $requestExists = $user
            ->followers()
            ->where('status', 'Pending')
            ->where('follower_id', $follower->id)
            ->exists();

        if (!$requestExists) {
            return $this->errorResponse('Request does not exists');
        }

        $result = $user
            ->followers()
            ->where('status', 'Pending')
            ->where('follower_id', $follower->id)
            ->update(['status' => $request->status]);

        return $this->successResponse('Follow Request Accepted', 200, $result); //message response 
    }

    public function unfollow(Request $request, User $user)
    {
        $request->user()->following()->detach($user);
        return $this->successResponse('Unfollowed successfully', 200);
    }

    public function listFollowers(User $user)
    {
        $followers = $user->followers;
        return $this->successResponse(['followers' => $followers], 200);
    }

    public function listFollowings(User $user)
    {
        $following = $user->following;
        return $this->successResponse(['following' => $following], 200);
    }
}

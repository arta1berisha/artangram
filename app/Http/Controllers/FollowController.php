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

            return response()->json(['message' => 'Your request to follow this user is pending']);
        } else if ($user->is_private === 0) {
            $user->followers()->attach(auth()->user()->id);

            return response()->json(['message' => 'You are now following this user']);
        }
    }

    public function handleFollowerActions(Request $request, User $follower)
    {
        if (
            $request->status !== "Accepted" && $request->status !== "Rejected"
        ) {
            return response()->json(['message' => 'The status received is not supported'], 400);
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

        return $this->successResponse($result);

        if ($request->status === "Accepted") {


            return response()->json(['message' => 'Your request to follow this user has been accepted']);
        } else if ($request->status === "Rejected")

            return response()->json(['message' => 'Your request to follow this user has been rejected']);
    }
    public function unfollow($request, User $user)
    {
        $request->user()->following()->detach($user);
        return response()->json(['message' => 'Unfollowed successfully'], 200);
    }

    public function followers(User $user)
    {
        $followers = $user->followers;
        return response()->json(['followers' => $followers], 200);
    }

    public function following(User $user)
    {
        $following = $user->following;
        return response()->json(['following' => $following], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow($request, $user)
    {
        if ($request->user()->canFollow($user)) {
            $request->user()->following()->attach($user);
            return response()->json(['message' => 'You are now following them'], 200);
        }

        return response()->json(['message' => 'Unable to follow user'], 403);
    }

    public function unfollow($request, $user)
    {
        $request->user()->following()->detach($user);
        return response()->json(['message' => 'Unfollowed successfully'], 200);
    }

    public function followers($user)
    {
        $followers = $user->followers;
        return response()->json(['followers' => $followers], 200);
    }

    public function following($user)
    {
        $following = $user->following;
        return response()->json(['following' => $following], 200);
    }

}

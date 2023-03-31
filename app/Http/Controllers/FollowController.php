<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;

class FollowController extends Controller
{
 

    public function follow($request, $user, $follow)
    {
        if($user->is_private) {
            $follow->follower_id = Auth::user()->id;
            $follow->status = 'pending';
            $follow->save();

            return response()->json(['message' => 'Your request to follow this user is now pending.'], 200);
        } else if ($request->user()->canFollow($user)) {
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

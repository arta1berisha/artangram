<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected function followersOfThisUser()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
        ->withPivot('status')
        ->wherePivot('status', 'confirmed');
    }

    protected function thisUserFollowerOf()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
        ->withPivot('status')
        ->wherePivot('status', 'confirmed');
    }

    public function getFollowersAttributes()
    {
        if ( ! array_key_exists('followers', $this->relations)) $this->loadFollowers();
        return $this->getRelation('followers');
    }

    protected function loadFollowers()
    {
        if ( ! array_key_exists('followers', $this->relations))
        {
            $followers = $this->mergeFollowers();
            $this->setRelation('followers', $followers);
        } else {
            return response()->json(['message' => 'You havent any followers']);
        }
    }

    protected function mergeFollowers()
    {
        if($temp = $this->followersOfThisUser)
        return $temp->merge($this->thisUserFollowerOf);
        else
        return $this->thisUserFriendOf();
    }

    public function followers()
    {
        return $this->belongsTo(User::class);
    }

}

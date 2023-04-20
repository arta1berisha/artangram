<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use ApiResponseTrait;

    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // return  $posts = Post::whereExists(function ($query) {
        //     $query->select(DB::raw(1))
        //           ->from('followers')
        //           ->whereRaw('posts.user_id', '=', 'followers.following_id')
        //           ->where('followers.status', '=', 'Accepted');
        // })
        // ->exists();;

        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        if (
            $user
            ->following()
            ->where('status', 'Accepted')
            ->where('following_id', $post->user_id)
            ->exists()
        ) {
            return true;
        } return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return true;
    }
}

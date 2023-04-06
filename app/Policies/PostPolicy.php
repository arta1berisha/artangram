<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use ApiResponseTrait;

    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $follower): bool
    {
        /** @var User */
        $user = auth()->user();

         $canViewPost = $user
            ->followers()
            ->where('status', 'Accepted')
            ->where('follower_id', $follower->id);

            return $canViewPost;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $follower): bool
    {
           /** @var User */
           $user = auth()->user();
        
           $canViewPost = $user
              ->followers()
              ->where('status', 'Accepted')
              ->where('follower_id', $follower->id);
  
              return $canViewPost;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
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
    // public function restore(User $user, Post $post): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Post $post): bool
    // {
    //     //
    // }
}

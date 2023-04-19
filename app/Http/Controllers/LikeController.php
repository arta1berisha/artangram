<?php

namespace App\Http\Controllers;

use App\Http\Requests\Like\LikeCommentRequest;
use App\Http\Requests\Like\LikePostRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Like\LikeCollection;
use App\Http\Resources\Like\LikeResource;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class LikeController extends Controller
{
    public function handlePostLikeActions(Post $post)
    {
        $user = auth()->user();

        if ($post->likes()
            ->where('user_id', $user->id)
            ->exists()
        ) {
            return $this->errorResponse('You already liked this post!');
        }

        $post->likes()->create(['user_id' => $user->id]);

        $post->usersLikes()->get();

        return $this->successResponse('You liked this post :)', 200, $post);
    }

    public function handlePostUnlikeActions( Post $post, User $user)
    {
        $user = auth()->user();

        if ($post->likes()
            ->where('user_id', $user->id)
            ->exists()
        ) {
            $post->likes()->delete(['user_id' => $user]);

            $post->usersLikes()->get();

            return $this->successResponse('You unliked this post :(', 203, $post);
        }

        return $this->errorResponse('Action unsuccessful', [], 404);
    }

    public function handleCommentLikeActions(Post $post, Comment $comment, User $user)
    {
        $user = auth()->user();

        if ($comment->likes()
            ->where('user_id', $user->id)
            ->exists()
        ) {
            return $this->errorResponse('You already liked this comment!');
        }

        $comment->likes()->create(['user_id' => $user->id]);

        $comment->usersLikes()->get();

        return $this->successResponse('You liked this comment :)', 200, $comment);
    }

    public function handleCommentUnlikeActions(Post $post, Comment $comment, User $user)
    {
        $user = auth()->user();

        if ($comment->likes()
            ->where('user_id', $user->id)
            ->exists()
        ) {
            $comment->likes()->delete(['user_id' => $user->id]);

            $comment->usersLikes()->get();

            return $this->successResponse('You unliked this comment :(', 200, $comment);
        }
        return $this->errorResponse('Action unsuccessful', [], 404);
    }
}

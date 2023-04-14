<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment\CommentResource;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class LikeController extends Controller
{
    public function handlePostLikeActions(Like $like, Post $post, User $user)
    {
        $post = new PostResource($post);
        $user = auth()->user();

        $post->likes()->create([
            'user_id' => $user->id,
        ]);

        $count = $post->likes()->count();
        return $count;
    }


    public function handleCommentLikeActions(Comment $comment, User $user, Like $like)
    {
        $comments = new CommentResource($comment);
        $user = auth()->user();

        $comments->likes()->create([
            'user_id' => $user->id,
        ]);

        $count = $comments->likes()->count();
        return $count;
    }

    public function commentDislike()
    {
    }
}

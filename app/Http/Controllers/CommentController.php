<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Post;

class CommentController extends Controller
{
    public function index()
    {
        $comment = Comment::all();

        return CommentResource::collection($comment);
    }

    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = $post->comments()
            ->save(new Comment([
                'user_id' => auth()->user()->id,
                'description' => $request->description,
            ]));

        return new CommentResource($comment);
    }

    public function delete(Post $post, Comment $comment)
    {
        $comment->delete();
        return $this->successResponse('Your Comment is Deleted.', 204);
    }
}

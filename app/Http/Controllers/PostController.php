<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;

class PostController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Post::class);

        $posts = Post::paginate();

        // select * from posts where exists ( select followers.following_id from followers where posts.user_id = followers.following_id and followers.status = 'Accepted' )

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Post::class);

        $post = auth()->user()->posts()->save(new Post($request->validated()));

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($request->validated());
        return new PostResource($post);
    }

    public function delete(Post $post)
    {
        $this->authorize('delete', Post::class);
        $post->delete();

        return $this->successResponse('Post deleted successfully', 204);
    }
}

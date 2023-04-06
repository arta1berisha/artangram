<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;

class PostController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Post::class);

        $posts = Post::paginate();

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Post::class);
        $post = Post::create($request->validated());
        return new PostResource($post);
        return response()->json(['success' => true]);
    }

    public function show($post)
    {
        $this->authorize('view', Post::class);

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

        return response()->json([
            'status' => true,
            'message' => 'Post deleted successfully',
        ], 204);
    }
}

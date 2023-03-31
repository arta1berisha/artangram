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
        $posts = Post::paginate();

        return PostResource::collection($posts);
    }

    public function create(StorePostRequest $request)
    {
        $user = Auth::user();
        $attributes = $request->attributes;
        $post = new Post();

        $post->save();
        return response()->json(['success' => true]);
    }

    public function show($post)
    {
        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, $post)
    {
        $post->update($request->validated());
        return new PostResource($post);
    }

    public function delete($post)
    {
        if ($post->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Post deleted successfully',
            ], 204);
        }

        return response()->json([
            'status' => false,
            'message' => 'Cannot delete post',
        ], 400);
    }
}

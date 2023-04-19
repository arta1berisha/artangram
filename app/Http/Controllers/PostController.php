<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use Illuminate\Database\Query\Builder;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Contracts\Database\Query\Expression;

class PostController extends Controller
{
    public function index(Post $post, User $following)
    {
        $this->authorize('viewAny', Post::class);

        // select * from posts where exists ( select followers.following_id  where posts.user_id = followers.following_id and followers.status = 'Accepted' )
        $user = auth()->id();

        $posts = Post::whereHas('user.followers', function ($query) use ($user) {
            $query->where('following_id', $user)
                ->where('status', 'Accepted');
        })
            ->get();
        $posts = Post::paginate();

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
        $this->authorize('delete', $post);
        $post->delete();

        return $this->successResponse('Post deleted successfully', 204);
    }
}

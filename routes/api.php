<?php

use App\Models\Post;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});


Route::group(['middleware' => ['auth.jwt']], function () {

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'delete']);

    Route::post('/users/{user}', [FollowController::class, 'follow']); //follow a user
    Route::post('/requests/{follower}', [FollowController::class, 'handleFollowerActions']);
    Route::get('/users/{user}/followers', [FollowController::class, 'listFollowers']); //my followers
    Route::get('/users/{user}/followings', [FollowController::class, 'listFollowings']); //my followings
    Route::post('/users/{user}/unfollow', [FollowController::class, 'unfollow']); //unfollow a user

    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'delete']);

    Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
    Route::post('/posts/{post}/comment', [CommentController::class, 'store']);
    Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'delete']);

    Route::post('/posts/{post}/like', [LikeController::class, 'handlePostLikeActions']);
    Route::post('/posts/{post}/unlike', [LikeController::class, 'handlePostUnlikeActions']);
    Route::post('/posts/{post}/comments/{comment}/like', [LikeController::class, 'handleCommentLikeActions']);
    Route::post('/posts/{post}/comments/{comment}/unlike', [LikeController::class, 'handleCommentUnlikeActions']);
});

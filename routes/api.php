<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Follow;

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

    Route::get('/{user}/followers', [FollowController::class, 'listFollowers']); //my followers
    Route::get('/{user}/followings', [FollowController::class, 'listFollowings']); //my followings
    Route::delete('/users/{user}', [FollowController::class, 'unfollow']); //unfollow a user

    Route::get('/{user}/posts', [PostController::class, 'index']);
    Route::post('/post', [PostController::class, 'create']);
    Route::get('/{user}/{post}', [PostController::class, 'show']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'delete']);

    // Route::get('/posts/{post}/comments', 'CommentController@index');
    // Route::post('/posts/{post}/comments', 'CommentController@create');
    // Route::get('/posts/{post}/comments/{comment}', 'CommentController@delete');

    // Route::post('/users/{user}/posts/{post}/likes', 'LikeController@like');
    // Route::delete('/users/{user}/posts/{post}/likes', 'LikeController@dislike');
    // Route::post('/users/{user}/posts/{post}/comments/{comment}/likes', 'LikeController@commentLike');
    // Route::delete('/users/{user}/posts/{post}/comments/{comment}/likes', 'LikeController@commentDislike');
});

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
    Route::post('/pending/followers/{follower}', [FollowController::class, 'handleFollowerActions']);

    // Route::get('/users/{user}/followers', [
    //     FollowController::class, 'followers']); //others followers
    // Route::get('/followers', [
    //     FollowController::class, 'followers'
    // ]); //my followers
    // Route::get('/followings', 'FollowController@followings'); //my followings

    // Route::delete('/users/{user}', 'FollowController@unfollow'); //unfollow a user

    // Route::get('/users/{user}/posts', 'PostController@index');
    // Route::post('/users/{user}/posts', 'PostController@create');
    // Route::get('/users/{user}/posts/{post}', 'PostController@show');
    // Route::put('/posts/{post}', 'PostController@update');
    // Route::delete('/posts/{post}', 'PostController@index');

    // Route::get('/posts/{post}/comments', 'CommentController@index');
    // Route::post('/posts/{post}/comments', 'CommentController@create');
    // Route::get('/posts/{post}/comments/{comment}', 'CommentController@delete');

    // Route::post('/users/{user}/posts/{post}/likes', 'LikeController@like');
    // Route::delete('/users/{user}/posts/{post}/likes', 'LikeController@dislike');
    // Route::post('/users/{user}/posts/{post}/comments/{comment}/likes', 'LikeController@commentLike');
    // Route::delete('/users/{user}/posts/{post}/comments/{comment}/likes', 'LikeController@commentDislike');
});

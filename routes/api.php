<?php

use App\Http\Controllers\api\authController;
use App\Http\Controllers\api\followerController;
use App\Http\Controllers\api\homeController;
use App\Http\Controllers\api\postsController;
use App\Http\Controllers\api\questionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [authController::class, 'login']);
Route::get('me', [authController::class, 'user']);
Route::get('user/{user}', [authController::class, 'getUser']);
Route::post('/addExpoPushToken', [authController::class, 'addExpoPushToken']);

Route::group([], function () {

    //this posts routes
    Route::get('/posts', [postsController::class, 'index']);
    Route::post('/posts', [postsController::class, 'create']);
    Route::get('/posts/{post}/comments', [postsController::class, 'getComments']);
    Route::post('/posts/{post}/comments', [postsController::class, 'addComment']);
    Route::post('/posts/{post}/like', [postsController::class, 'like']);

    Route::get('/deep/search', [homeController::class, 'deepSearch']);

    //this questions routes
    Route::get('/questions', [questionController::class, 'index']);
    Route::post('/questions', [questionController::class, 'create']);
    Route::delete('/questions/{id}', [questionController::class, 'delete']);

    Route::get('/add-and-remove-friend', [followerController::class, 'addAndRemoveFollower']);
});

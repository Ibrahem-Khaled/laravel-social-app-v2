<?php

use App\Http\Controllers\api\authController;
use App\Http\Controllers\api\postsController;
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

Route::group([], function () {

    //this posts routes
    Route::get('/posts', [postsController::class, 'index']);
    Route::post('/posts', [postsController::class, 'create']);
    Route::get('/posts/{post}/comments', [postsController::class, 'getComments']);
    Route::post('/posts/{post}/comments', [postsController::class, 'addComment']);
});

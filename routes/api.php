<?php

use App\Http\Controllers\api\authController;
use App\Http\Controllers\api\CallLogController;
use App\Http\Controllers\api\chatController;
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
Route::post('/register', [authController::class, 'register']);
Route::post('/update-profile', [authController::class, 'update']);
Route::post('/change-password', [authController::class, 'changePassword']);
Route::get('me', [authController::class, 'user']);
Route::get('user/{user}', [authController::class, 'getUser']);
Route::post('/addExpoPushToken', [authController::class, 'addExpoPushToken']);

Route::group([], function () {
    //this main routes
    Route::get('/deep/search', [homeController::class, 'deepSearch']);
    Route::get('/get/higher/points/from/users', [homeController::class, 'getHigherPointsFromUsers']);
    Route::get('/get/higher/points/from/users/followers', [homeController::class, 'getHigherPointsFromUsersFollowers']);
    Route::post('/submit/verification', [homeController::class, 'submitVerification']);

    //this posts routes
    Route::get('/posts', [postsController::class, 'index']);
    Route::post('/posts', [postsController::class, 'create']);
    Route::put('/posts/{post}', [postsController::class, 'update']);
    Route::delete('/posts/{post}', [postsController::class, 'delete']);

    //this posts comments routes
    Route::get('/posts/{post}/comments', [postsController::class, 'getComments']);
    Route::post('/posts/{post}/comments', [postsController::class, 'addComment']);
    Route::post('/posts/{post}/like', [postsController::class, 'like']);

    //this questions routes
    Route::get('/questions', [questionController::class, 'index']);
    Route::post('/questions', [questionController::class, 'create']);
    Route::post('/questions/{message}/reply', [questionController::class, 'replyMessage']);
    Route::delete('/questions/{id}', [questionController::class, 'delete']);

    //this chat and conversations routes
    Route::get('/conversations', [chatController::class, 'getConversations']);
    Route::post('/conversations', [chatController::class, 'startConversation']);
    Route::get('/conversations/{conversationId}/messages', [chatController::class, 'getMessages']);
    Route::post('/conversations/{conversationId}/messages', [chatController::class, 'sendMessage']);
    Route::delete('/conversations/{conversation}/messages', [chatController::class, 'deleteConversationMessages']);
    Route::delete('/conversations/{conversation}', [chatController::class, 'deleteConversation']);

    //this block and follow routes
    Route::post('/follow', [followerController::class, 'addAndRemoveFollower']);
    Route::get('/get/{user}/{type}', [followerController::class, 'getFollowersAndFollowing']);
    Route::post('/block', [followerController::class, 'addAndRemoveBlock']);
    Route::get('/blocked/users', [followerController::class, 'getBlockedUsers']);

    //this call log routes
    Route::get('/call-logs', [CallLogController::class, 'index']);
    Route::post('/call-logs', [CallLogController::class, 'store']);
    Route::put('/call-logs/{callLog}', [CallLogController::class, 'update']);
    Route::delete('/call-logs/{callLog}', [CallLogController::class, 'destroy']);
});

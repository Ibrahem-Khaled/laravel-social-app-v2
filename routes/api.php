<?php

use App\Events\MessageSent;
use App\Http\Controllers\api\authController;
use App\Http\Controllers\api\CallLogController;
use App\Http\Controllers\api\chatController;
use App\Http\Controllers\api\followerController;
use App\Http\Controllers\api\giftController;
use App\Http\Controllers\api\HashtagController;
use App\Http\Controllers\api\homeController;
use App\Http\Controllers\api\LiveStreamingController;
use App\Http\Controllers\api\notificationController;
use App\Http\Controllers\api\postsController;
use App\Http\Controllers\api\questionController;
use App\Http\Controllers\api\ReelsController;
use App\Http\Controllers\api\sellCoinsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;

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

Route::post('/auth/phone/check', [AuthController::class, 'checkPhoneExistence']);
Route::post('/auth/phone/verify', [AuthController::class, 'verifyPhoneNumber']); // هذا موجود من قبل

Route::post('/login', [authController::class, 'login']);
Route::post('/register', [authController::class, 'register']);
Route::post('/update-profile', [authController::class, 'update']);
Route::post('/change-password', [authController::class, 'changePassword']);
Route::get('me', [authController::class, 'user']);
Route::get('user/{user}', [authController::class, 'getUser']);
Route::post('/addExpoPushToken', [authController::class, 'addExpoPushToken']);
Route::post('/delete-account', [authController::class, 'deleteAccount']);


Route::group([], function () {
    //this main routes
    Route::group(['prefix' => 'deep/search'], function () {
        Route::get('suggestions', [homeController::class, 'getSuggestions']);
        Route::get('/', [homeController::class, 'search']);
    });
    Route::get('/get/higher/points/from/users', [homeController::class, 'getHigherPointsFromUsers']);
    Route::get('/get/higher/points/from/users/followers', [homeController::class, 'getHigherPointsFromUsersFollowers']);
    Route::post('/submit/verification', [homeController::class, 'submitVerification']);

    //this posts routes
    Route::get('/posts', [postsController::class, 'index']);
    Route::get('/posts/follow', [postsController::class, 'getFollowPosts']);
    Route::post('/posts', [postsController::class, 'create']);
    Route::post('/posts/{post}', [postsController::class, 'update']);
    Route::delete('/posts/{post}', [postsController::class, 'delete']);
    Route::post('/posts/{post}/pinned', [postsController::class, 'pinnedPost']);
    Route::post('/posts/{post}/like', [postsController::class, 'like']);
    Route::get('/post/{post}/likers', [postsController::class, 'getLikes']);

    //this posts comments routes
    Route::get('/posts/{post}/comments', [postsController::class, 'getComments']);
    Route::post('/posts/{post}/comments', [postsController::class, 'addComment']);
    Route::delete('/posts/delete/comment/{comment}', [postsController::class, 'deleteComment']);

    //this questions routes
    Route::get('/questions', [questionController::class, 'index']);
    Route::post('/questions', [questionController::class, 'create']);
    Route::post('/questions/{message}/reply', [questionController::class, 'replyMessage']);
    Route::delete('/questions/{id}', [questionController::class, 'delete']);

    //this chat and conversations routes
    Route::get('conversations', [ChatController::class, 'getConversations']);
    Route::get('conversations/private', [ChatController::class, 'getPrivateConversations']);
    Route::get('conversations/group', [ChatController::class, 'getGroupConversations']);
    Route::get('conversation/{conversation}', [ChatController::class, 'getConversation']);
    Route::post('conversations/private', [ChatController::class, 'createPrivate']);
    Route::post('conversations/group', [ChatController::class, 'createGroup']);
    Route::post('conversations/{conversation}', [ChatController::class, 'updateGroup']);
    Route::post('conversations/{conversation}/leave', [ChatController::class, 'LeaveGroup']);
    Route::get('conversations/{id}/messages', [ChatController::class, 'getMessages']);
    Route::post('messages', [ChatController::class, 'sendMessage']);
    Route::delete('conversations/{id}/messages', [ChatController::class, 'deleteConversationMessages']);
    Route::delete('conversations/{id}', [ChatController::class, 'deleteConversation']);
    Route::delete('messages/{id}', [ChatController::class, 'deleteMessage']);


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

    //this live streaming routes
    Route::apiResource('live-streamings', LiveStreamingController::class);
    Route::get('/live-streams/live', [LiveStreamingController::class, 'getLiveStreams']);
    Route::get('/live-streams/audio', [LiveStreamingController::class, 'getAudioRooms']);
    Route::get('/live-streams/following', [LiveStreamingController::class, 'getLiveStreamsByFollowing']);


    //this hashtags routes
    Route::get('/hashtags', [HashtagController::class, 'index']);
    Route::get('/hashtag/{hashtag}', [HashtagController::class, 'getPostsByHashtag']);

    //this notifications routes
    Route::get('/notifications', [notificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::put('/notifications/{notification}', [NotificationController::class, 'update']);
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy']);

    Route::post('/create/reel', [ReelsController::class, 'createReel']);
    Route::get('/reels', [ReelsController::class, 'getReels']);

    //this gift routes
    Route::get('/gifts', [giftController::class, 'index']);
    Route::post('/send-gift', [giftController::class, 'sendGift']);
    Route::get('/get-gifts/{user}', [giftController::class, 'getGifts']);
    Route::post('/sent-coins-from-post/{post}', [giftController::class, 'sentCoinsFromPost']);

    //this coins routes
    Route::get('/get-coins', [sellCoinsController::class, 'getCoins']);

    Route::get('/test-broadcast', function () {
        $user = User::inRandomOrder()->first();
        event(new MessageSent($user));

        return "تم إرسال البث يدوياً!";
    });
});

<?php

use App\Http\Controllers\dashboard\AgencyController;
use App\Http\Controllers\Dashboard\AgencyUserController;
use App\Http\Controllers\dashboard\FamilyController;
use App\Http\Controllers\dashboard\GiftController;
use App\Http\Controllers\dashboard\homeController;
use App\Http\Controllers\dashboard\LiveStreamingController;
use App\Http\Controllers\dashboard\MessageController;
use App\Http\Controllers\dashboard\NotificationController;
use App\Http\Controllers\dashboard\PostController;
use App\Http\Controllers\dashboard\SellCoinController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\UserFamilyController;
use App\Http\Controllers\dashboard\VerificationController;
use App\Http\Controllers\webController;
use App\Http\Controllers\website\WebsiteDataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [webController::class, 'index'])->name('home');
Route::post('/subscribe', [webController::class, 'subscribe'])->name('subscribe');

Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin'], function () {
    //this is dashboard route
    Route::get('/', [homeController::class, 'dashboard'])->name('home.dashboard');

    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-ban', [UserController::class, 'toggleBan'])->name('users.toggleBan');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::post('/users/{user}/manage-coins', [UserController::class, 'manageCoins'])->name('users.manageCoins');
    Route::patch('/users/{user}/toggle-is-verified', [UserController::class, 'toggleIsVerified'])->name('users.toggleIsVerified');


    Route::resource('posts', PostController::class);
    Route::get('/reports', [PostController::class, 'reports'])->name('reports.index');
    Route::patch('/reports/{report}/toggle-visibility', [PostController::class, 'toggleVisibility'])->name('reports.toggleVisibility');

    Route::resource('gifts', GiftController::class);

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/send-anonymous', [MessageController::class, 'sendAnonymous'])->name('messages.sendAnonymous');
    Route::delete('/messages/delete-multiple', [MessageController::class, 'deleteMultiple'])->name('messages.deleteMultiple');


    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::patch('/notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');

    Route::post('/verification', [VerificationController::class, 'store'])->name('verification.store');
    Route::get('/verifications', [VerificationController::class, 'index'])->name('verification.index');
    Route::patch('/verification/{verificationRequest}/approve', [VerificationController::class, 'approve'])->name('verification.approve');
    Route::patch('/verification/{verificationRequest}/reject', [VerificationController::class, 'reject'])->name('verification.reject');

    Route::resource('families', FamilyController::class);
    Route::resource('user-families', UserFamilyController::class)->only(['store', 'update', 'destroy']);

    Route::resource('live-streamings', LiveStreamingController::class);
    Route::get('live-streamings/statistics', [LiveStreamingController::class, 'statistics'])->name('live-streamings.statistics');

    Route::resource('agencies', AgencyController::class);
    Route::resource('agency-users', AgencyUserController::class);

    Route::resource('sell-coins', SellCoinController::class);



    Route::get('/website-data', [WebsiteDataController::class, 'index'])->name('website-data.index');
    Route::post('/website-data', [WebsiteDataController::class, 'storeOrUpdate'])->name('website-data.store-or-update');
});


require __DIR__ . '/web/auth.php';

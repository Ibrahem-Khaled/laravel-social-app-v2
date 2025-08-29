<?php

// use App\Http\Controllers\dashboard\AgencyController;
// use App\Http\Controllers\Dashboard\AgencyUserController;

use App\Http\Controllers\dashboard\ContactMessageController;
use App\Http\Controllers\dashboard\FamilyController;
use App\Http\Controllers\dashboard\FeatureSectionController;
use App\Http\Controllers\dashboard\GameController;
use App\Http\Controllers\dashboard\GiftController;
use App\Http\Controllers\dashboard\homeController;
use App\Http\Controllers\dashboard\LevelController;
use App\Http\Controllers\dashboard\LiveStreamingController;
use App\Http\Controllers\dashboard\MessageController;
use App\Http\Controllers\dashboard\NotificationController;
use App\Http\Controllers\dashboard\PostController;
use App\Http\Controllers\dashboard\SellCoinController;
use App\Http\Controllers\dashboard\SettingController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\UserFamilyController;
use App\Http\Controllers\dashboard\VerificationController;
use App\Http\Controllers\dashboard\WithdrawalRequestController;
use App\Http\Controllers\webController;
use App\Http\Controllers\website\FAQController;
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
    Route::patch('/users/{user}/set-level', [UserController::class, 'setLevel'])->name('users.setLevel');

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

    Route::resource('live-streamings', LiveStreamingController::class)->except(['show']);

    Route::get('live-streamings/statistics', [LiveStreamingController::class, 'statistics'])->name('live-streamings.statistics');

    // Route::resource('agencies', AgencyController::class);
    // Route::resource('agency-users', AgencyUserController::class);

    Route::resource('sell-coins', SellCoinController::class);

    Route::resource('levels', LevelController::class);

    Route::resource('withdrawal-requests', WithdrawalRequestController::class)->only([
        'index',
        'update',
        'destroy'
    ]);

    //this routes to control from website data
    Route::get('/website-data', [WebsiteDataController::class, 'index'])->name('website-data.index');
    Route::post('/website-data', [WebsiteDataController::class, 'storeOrUpdate'])->name('website-data.store-or-update');
    Route::resource('faqs', FAQController::class);
    Route::post('faqs.toggle-status', [FAQController::class, 'toggleStatus'])->name('faqs.toggle-status');
    Route::post('faqs.toggle-featured', [FAQController::class, 'toggleFeatured'])->name('faqs.toggle-featured');

    Route::get('settings', [SettingController::class, 'index'])->name('dashboard.settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('dashboard.settings.update');

    Route::get('/contacts', [ContactMessageController::class, 'index'])->name('contacts.index');
    Route::post('/contacts', [ContactMessageController::class, 'store'])->name('contacts.store');
    Route::put('/contacts/{contact_message}', [ContactMessageController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact_message}', [ContactMessageController::class, 'destroy'])->name('contacts.destroy');
    // مرفقات
    Route::delete('/attachments/{attachment}', [ContactMessageController::class, 'destroyAttachment'])->name('attachments.destroy');
    Route::get('/attachments/{attachment}/download', [ContactMessageController::class, 'downloadAttachment'])->name('attachments.download');

    Route::resource('feature-sections', FeatureSectionController::class)->except(['show']);
    //end routes to control from website data



    //this routes to control from games
    Route::resource('games', GameController::class);
});


require __DIR__ . '/web/auth.php';

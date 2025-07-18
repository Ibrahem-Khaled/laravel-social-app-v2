<?php

use App\Http\Controllers\dashboard\AuthController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'auth'], function () {

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'customLogin'])->name('customLogin');

    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'customRegister'])->name('customRegister');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('deleteAccount', [AuthController::class, 'deleteAccount'])->name('profile.destroy');
    Route::get('/profile/delete', [AuthController::class, 'showDeleteForm'])->name('profile.delete.form')->middleware('auth');

    Route::get('profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
    Route::get('profile-edit', [AuthController::class, 'profileUpdate'])->name('profile.edit')->middleware('auth');
    Route::put('/update', [AuthController::class, 'update'])->name('profile.update');
    Route::put('/update-password', [AuthController::class, 'updatePassword'])->name('user.update.password');

    Route::get('forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
    Route::post('resetPassword', [AuthController::class, 'resetPassword'])->name('resetPassword');

    Route::get('shipping-agent', [AuthController::class, 'shippingAgent'])->name('shippingAgent');
});

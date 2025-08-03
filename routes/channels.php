<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;
use Illuminate\Support\Facades\Log; // <-- أضف هذا السطر

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    \Log::info('Broadcast Auth Attempt', [
        'auth_user_id' => $user->id ?? null,
        'channel_user_id' => $id
    ]);


    return (int) $user->id === (int) $id;
});


Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    // اسمح للجميع بالدخول مؤقتًا لأغراض الاختبار فقط
    return true;
});

Broadcast::channel('messages.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel('questions.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('notifications.{userId}', function ($user, $userId) {

    // هذا هو الكود الأصلي للمصادقة
    return (int) $user->id === (int) $userId;
});

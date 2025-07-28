<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log; //  ✨ أضف هذا السطر
use App\Models\Conversation;

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
    return (int) $user->id === (int) $id;
});


Broadcast::channel('messages.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel('questions.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('notifications.{userId}', function ($user, $userId) {

    // ✨ أضف هذا الكود للتسجيل والتشخيص
    Log::info('Channel Authorization Attempt:', [
        'authenticated_user_id' => $user->id ?? 'GUEST (Not Authenticated!)',
        'requested_channel_for_userId' => $userId,
        'is_authorized' => isset($user) ? ((int) $user->id === (int) $userId) : false,
    ]);

    // هذا هو الكود الأصلي للمصادقة
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {

    // ✨ أضف هذا السطر للتحقق من أن الدالة تُستدعى
    Log::info("Authorizing channel for user: {$user->id} and conversation: {$conversationId}");

    $conversation = Conversation::find($conversationId);

    if ($conversation && $conversation->users->contains($user)) {
        // ✨ أضف هذا السطر للتأكد من نجاح الشرط
        Log::info("Authorization SUCCESSFUL for conversation: {$conversationId}");
        return true;
    }

    // ✨ أضف هذا السطر للتأكد من فشل الشرط
    Log::info("Authorization FAILED for conversation: {$conversationId}");
    return false;
});

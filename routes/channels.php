<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;
use Laravel\Reverb\Loggers\Log;

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



Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    try {
        if (!$user) {
            // This case handles if the user is not authenticated
            return false;
        }

        $conversation = Conversation::find($conversationId);

        if (!$conversation) {
            // This case handles if the conversation ID does not exist
            return false;
        }

        // This returns true if the user is a member, and false otherwise
        return $conversation->users()->where('user_id', $user->id)->exists();
    } catch (\Exception $e) {
        // This will catch any other unexpected PHP errors
        Log::error('EXCEPTION in conversation channel auth:', [
            'error' => $e->getMessage()
        ]);
        return false;
    }
});



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

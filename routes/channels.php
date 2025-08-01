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
    try {
        // الخطوة 1: التحقق من أن المستخدم مسجل دخوله
        if (!$user) {
            Log::warning('Channel Auth Failed: User is not authenticated.', [
                'channel' => 'conversation.' . $conversationId,
            ]);
            return false;
        }

        // الخطوة 2: البحث عن المحادثة
        $conversation = Conversation::find($conversationId);

        // الخطوة 3: التحقق من وجود المحادثة
        if (!$conversation) {
            Log::warning('Channel Auth Failed: Conversation not found.', [
                'user_id' => $user->id,
                'conversation_id' => $conversationId,
            ]);
            return false;
        }

        // الخطوة 4: التحقق من أن المستخدم عضو في المحادثة
        $isMember = $conversation->users()->where('user_id', $user->id)->exists();

        // تسجيل النتيجة النهائية للمساعدة في التشخيص
        Log::info('Channel Auth Result:', [
            'user_id' => $user->id,
            'conversation_id' => $conversationId,
            'is_member' => $isMember,
        ]);

        return $isMember;

    } catch (\Exception $e) {
        // ✨ هذا هو الجزء الأهم: تسجيل أي خطأ فادح يحدث ✨
        Log::error('EXCEPTION in Channel Authorization:', [
            'channel' => 'conversation.' . $conversationId,
            'user_id' => $user->id ?? 'GUEST',
            'error_message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(), // يعطينا تفاصيل كاملة عن مكان الخطأ
        ]);

        // إرجاع false لمنع أي سلوك غير متوقع في الواجهة الأمامية
        return false;
    }
});

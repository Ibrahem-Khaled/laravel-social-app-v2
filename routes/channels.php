<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;
use Illuminate\Support\Facades\Log;

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

/**
 * ======================================================================
 * الكود التالي هو ما تم تعديله لتشخيص المشكلة
 * ======================================================================
 */
Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    // --- بداية كود التشخيص ---
    Log::info('--- Broadcasting Auth Check for notifications channel ---');

    // هل المتغير $user يحتوي على بيانات المستخدم أم هو فارغ (null)؟
    Log::info('User Object received: ' . json_encode($user));

    // ما هو رقم المستخدم القادم من الطلب؟
    Log::info('Requested User ID from channel name: ' . $userId);

    // الآن نقوم بالتحقق
    if ($user) {
        $is_authorized = (int) $user->id === (int) $userId;
        Log::info('Result of comparison: ' . ($is_authorized ? 'Authorized (true)' : 'Not Authorized (false)'));
    } else {
        // إذا كان المستخدم null، فهذا يعني أنه غير مسجل دخوله
        Log::info('User is null. Authorization failed.');
        $is_authorized = false;
    }
    Log::info('--- End of Auth Check ---');
    // --- نهاية كود التشخيص ---

    // إرجاع النتيجة النهائية
    return $is_authorized;
});

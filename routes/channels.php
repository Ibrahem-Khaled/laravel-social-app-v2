<?php

use Illuminate\Support\Facades\Broadcast;
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

Broadcast::channel('test-channel', function () {
    return true;
});

// الأهم هو هذا الجزء
// هذا الكود سيتم تنفيذه عند طلب رابط المصادقة
// بغض النظر عن القناة المطلوبة
echo json_encode(['status' => 'OK, I am here!']);
exit();


// Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
//     // اسمح للجميع بالدخول مؤقتًا لأغراض الاختبار فقط
//     return true;
// });



// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


// Broadcast::channel('messages.{userId}', function ($user, $userId) {
//     return (int) $user->id === (int) $userId;
// });
// Broadcast::channel('questions.{userId}', function ($user, $userId) {
//     return (int) $user->id === (int) $userId;
// });

// Broadcast::channel('notifications.{userId}', function ($user, $userId) {

//     // هذا هو الكود الأصلي للمصادقة
//     return (int) $user->id === (int) $userId;
// });

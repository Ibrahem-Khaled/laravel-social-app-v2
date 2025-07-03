<?php

use Illuminate\Support\Facades\Broadcast;

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


Broadcast::presence('chat', function ($user) {
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});

Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    // هذا السطر هو قلب عملية المصادقة
    // يقوم بالتأكد من أن المستخدم الذي يحاول الاستماع للقناة
    // هو نفس المستخدم صاحب القناة
    // مثلاً، المستخدم رقم 27 فقط هو من يمكنه الاستماع للقناة 'notifications.27'
    return (int) $user->id === (int) $userId;
});

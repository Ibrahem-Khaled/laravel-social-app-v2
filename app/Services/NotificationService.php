<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;


class NotificationService
{
    public static function notify($toUserId, $message, $relatedModel = null)
    {
        Notification::create([
            'user_id' => $toUserId,
            'message' => $message,
            'related_id' => optional($relatedModel)->id,
            'related_type' => $relatedModel ? get_class($relatedModel) : null,
        ]);
    }
}

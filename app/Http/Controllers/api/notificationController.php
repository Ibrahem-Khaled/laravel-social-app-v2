<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class notificationController extends Controller
{
    public function index()
    {
        $user = auth()->guard('api')->user();

        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->with('related') // تحسين الاستعلام
            ->paginate(20); // استخدام paginate أفضل للأداء

        return NotificationResource::collection($notifications);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(['message' => 'تم حذف الاشعار بنجاح']);
    }

    public function markAsRead(Notification $notification)
    {
        // التأكد من أن المستخدم يملك هذا الإشعار (حماية إضافية)
        if ($notification->user_id !== auth()->guard('api')->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'Notification marked as read.']);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class notificationController extends Controller
{
    public function index()
    {
        $user = auth()->guard('api')->user();

        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->with('related') // لو محتاجين بيانات من related model
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'user_id ' => $notification->user_id,
                    'user' => $notification->related?->user?->name ?? 'مستخدم',
                    'image' => $notification->related?->user?->avatar_url,
                    'action' => $notification->message,
                    'is_read' => $notification->is_read,
                    'time' => $notification->created_at->diffForHumans(),
                ];
            });

        return response()->json($notifications);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(['message' => 'تم حذف الاشعار بنجاح']);
    }
}

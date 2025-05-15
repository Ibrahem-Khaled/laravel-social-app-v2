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
                    'user' => $notification->related?->user?->name ?? 'مستخدم',
                    'image' => $notification->related?->user?->avatar ?? 'https://example.com/default.jpg',
                    'action' => $notification->message,
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

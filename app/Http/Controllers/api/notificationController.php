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
        $notifications = $user->userNotifications()->paginate(10);
        return response()->json($notifications);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(['message' => 'تم حذف الاشعار بنجاح']);
    }
}

<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('user')->latest()->paginate(10);

        // إحصائيات
        $totalNotifications = Notification::count();
        $readNotifications = Notification::where('is_read', true)->count();
        $unreadNotifications = Notification::where('is_read', false)->count();
        $uniqueUsers = Notification::distinct('user_id')->count('user_id');

        $users = User::all();
        return view('dashboard.notifications.index', compact(
            'notifications',
            'users',
            'totalNotifications',
            'readNotifications',
            'unreadNotifications',
            'uniqueUsers'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Notification::create($request->all());

        return redirect()->back()->with('success', 'تم إضافة الإشعار بنجاح.');
    }

    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $notification->update($request->all());

        return redirect()->back()->with('success', 'تم تحديث الإشعار بنجاح.');
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'تم تعليم الإشعار كمقروء.');
    }

    public function delete(Notification $notification)
    {
        $notification->delete();

        return redirect()->back()->with('success', 'تم حذف الإشعار بنجاح.');
    }
}

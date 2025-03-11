<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Notifications\ExpoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('sender', 'receiver')->latest()->paginate(10);

        // إحصائيات
        $totalMessages = Message::count();
        $readMessages = Message::where('is_read', true)->count();
        $unreadMessages = Message::where('is_read', false)->count();
        $anonymousMessages = Message::where('is_anonymous', true)->count();
        $users = User::all();
        return view('dashboard.messages.index', compact(
            'messages',
            'totalMessages',
            'readMessages',
            'unreadMessages',
            'anonymousMessages',
            'users'
        ));
    }

    public function sendAnonymous(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            // 'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:2048',
            'recipients' => 'nullable|array',
            'filters' => 'nullable|array',
        ]);

        $messageContent = $request->message;
        // $mediaPath = $request->file('media') ? $request->file('media')->store('messages') : null;

        $recipientsQuery = User::query();

        // تطبيق الفلاتر
        if ($request->has('filters')) {
            foreach ($request->filters as $filter) {
                if ($filter === 'male') {
                    $recipientsQuery->where('gender', 'male');
                } elseif ($filter === 'female') {
                    $recipientsQuery->where('gender', 'female');
                } elseif ($filter === 'egypt') {
                    $recipientsQuery->where('country', 'Egypt');
                }
            }
        }

        // تحديد المستلمين مباشرة إذا تم اختيارهم
        if ($request->has('recipients') && !empty($request->recipients)) {
            $recipientsQuery->whereIn('id', $request->recipients);
        }

        $recipients = $recipientsQuery->get();

        // إنشاء الرسائل
        foreach ($recipients as $recipient) {
            Message::create([
                'sender_id' => null,
                'receiver_id' => $recipient->id,
                'message' => $messageContent,
                // 'media' => $mediaPath,
                'is_anonymous' => true,
            ]);

            if ($recipient->expo_push_token) {
                // إرسال الإشعار لكل مستخدم على حدة باستخدام التوكين الخاص به
                Notification::send($recipient, new ExpoNotification([$recipient->expo_push_token], 'رسالة جديدة', $messageContent));
            }
        }

        return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح.');
    }

    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:messages,id',
        ]);

        Message::whereIn('id', $request->message_ids)->delete();

        return redirect()->route('messages.index')->with('success', 'تم حذف الرسائل المحددة بنجاح.');
    }

}

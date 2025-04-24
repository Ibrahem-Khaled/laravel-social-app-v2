<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use App\Notifications\ExpoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class questionController extends Controller
{

    public function index()
    {
        $user = auth()->guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'unauthorized'], 401);
        }

        // 1) جلب كل الرسائل (بما في ذلك المجهولة وغير المجهولة)
        $messages = $user->receivedMessages()
            ->where('type_message', 'anonymous')
            ->where('is_anonymous', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        // 2) Eager load بيانات المرسل لجميع الرسائل دفعة واحدة للتوفير في الاستعلامات :contentReference[oaicite:0]{index=0}
        $messages->load('sender:id,name,avatar');

        // 3) استبعاد بيانات المرسل (Relation) للرسائل المجهولة
        $messages->each(function ($msg) {
            if ($msg->is_anonymous && $msg->type_message == 'anonymous') {
                // إذا كانت الرسالة مجهولة، نزيل العلاقة sender
                $msg->setRelation('sender', null);
            }
        });

        return response()->json($messages);
    }

    public function create(Request $request)
    {
        $user = auth()->guard('api')->user();
        $receiver = User::findOrFail($request->receiver_id);

        $question = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'message' => $request->message,
            'is_anonymous' => $request->is_anonymous,
            'type_message' => 'anonymous',
        ]);

        if ($receiver->expo_push_token) {
            Notification::send($receiver, new ExpoNotification([$receiver->expo_push_token], 'رسالة جديدة', $question->message));

        }

        return response()->json($question);
    }

    public function replyMessage(Request $request, Message $message)
    {
        $user = auth()->guard('api')->user();

        $validatedData = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validatedData->errors(),
            ], 422);
        }

        // إنشاء الرسالة الجديدة كرسالة رد مع تحديد الرسالة الأصل عبر parent_id
        $reply = Message::create([
            'parent_id' => $message->id,
            'sender_id' => $user->id,
            'receiver_id' => $message->sender_id,
            'message' => $request->message,
        ]);

        Post::create([
            'user_id' => $user->id,
            'message_id' => $message->id,
            'content' => $request->message,
        ]);

        if ($message->sender->expo_push_token) {
            Notification::send($message->sender, new ExpoNotification([$message->sender->expo_push_token], 'رسالة جديدة', $reply->message));
        }

        $message->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم إرسال الرد بنجاح',
            'data' => $reply
        ], 201);
    }


    public function delete($id)
    {
        $user = auth()->guard('api')->user();

        $question = Message::findOrFail($id);

        if ($question->receiver_id !== $user->id) {
            return response()->json(['message' => 'unauthorized'], 401);
        }

        $question->delete();
        return response()->json(['message' => 'question deleted successfully']);
    }

}

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

        $questions = $user->receivedMessages()
            ->where('is_anonymous', 1)
            ->doesntHave('replies')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($questions);
    }


    public function create(Request $request)
    {
        $user = auth()->guard('api')->user();
        $receiver = User::findOrFail($request->receiver_id);
        $question = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'message' => $request->message,
            'is_anonymous' => true,
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

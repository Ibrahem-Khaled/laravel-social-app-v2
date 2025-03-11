<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Notifications\ExpoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class questionController extends Controller
{
    public function index()
    {
        $user = auth()->guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'unauthorized'], 401);
        }

        $questions = $user->receivedMessages()->where('is_anonymous', 1)->get();

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

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

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

        $question = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_anonymous' => true,
        ]);

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

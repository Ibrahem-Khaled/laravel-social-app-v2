<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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


}

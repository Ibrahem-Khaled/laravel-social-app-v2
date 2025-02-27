<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class questionController extends Controller
{
    public function index()
    {
        $user = auth()->guard('api')->user();
        $questions = $user->receivedMessages()->where('is_anonymous', true)->get();
        return response()->json($questions);
    }

    
}

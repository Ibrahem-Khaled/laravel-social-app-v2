<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class followerController extends Controller
{
    public function addAndRemoveFollower(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user->followers()->toggle($request->input('user_id'));
        return response()->json('success');
    }
}

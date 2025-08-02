<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Tymon\JWTAuth\Facades\JWTAuth;
class BroadcastAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // لازم Laravel يعرف المستخدم
            auth()->setUser($user);

            // Laravel بيتولى الباقي (تشغيل Broadcast::channel() من routes/channels.php)
            return Broadcast::auth($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}

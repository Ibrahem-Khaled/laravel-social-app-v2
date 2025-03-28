<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class authController extends Controller
{
    public function login(Request $request)
    {
        // الحصول على رقم الهاتف من الطلب
        $phone = $request->input('phone');

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'بيانات الاعتماد غير صحيحة'], 401);
        }

        // البحث عن المستخدم باستخدام رقم الهاتف
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json(['error' => 'بيانات الاعتماد غير صحيحة'], 401);
        }

        // إنشاء التوكن للمستخدم دون التحقق من كلمة المرور
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }


    public function user(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json(['user' => $user]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'غير مصرح به'], 401);
        }
    }

    public function getUser(User $user)
    {
        $currentUser = auth()->guard('api')->user();

        // التحقق مما إذا كان المستخدم الحالي قد حظر المستخدم المطلوب
        if ($currentUser->blockedUsers()->where('blocked_user_id', $user->id)->exists()) {
            return response()->json(['error' => 'هذا المستخدم محظور'], 403);
        }

        $posts = $user->posts()->with('user', 'message')->get();
        return response()->json([
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function addExpoPushToken(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user->expo_push_token = $request->input('expo_push_token');
        $user->save();
        return response()->json('success added token');
    }

}

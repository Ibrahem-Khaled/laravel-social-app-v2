<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class authController extends Controller
{
    public function login(Request $request)
    {
        // الحصول على رقم الهاتف من الطلب
        $phone = $request->input('phone');

        // البحث عن المستخدم باستخدام رقم الهاتف
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return response()->json(['error' => 'بيانات الاعتماد غير صحيحة'], 401);
        }

        // ينصح بإضافة آلية تحقق إضافية مثل إرسال OTP للتأكد من هوية المستخدم

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
        return response()->json(['user' => $user]);
    }

}

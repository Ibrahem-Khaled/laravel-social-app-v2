<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class followerController extends Controller
{
    public function addAndRemoveFollower(Request $request)
    {
        // الحصول على المستخدم الحالي من خلال التوكن
        $user = JWTAuth::parseToken()->authenticate();

        // التحقق من صحة وجود معرف المستخدم في الطلب (يمكن إضافة عملية تحقق إضافية)
        $otherUserId = $request->input('user_id');
        if (!$otherUserId) {
            return response()->json(['error' => 'user_id is required'], 400);
        }

        // تبديل حالة متابعة المستخدم الآخر (إضافة إذا لم يكن موجوداً أو إزالته إذا كان موجوداً)
        $user->followings()->toggle($otherUserId);

        return response()->json('success');
    }

    public function addAndRemoveBlock(Request $request)
    {
        // الحصول على المستخدم الحالي من خلال التوكن
        $user = JWTAuth::parseToken()->authenticate();
        // التحقق من صحة وجود معرف المستخدم في الطلب (يمكن إضافة عملية تحقق إضافية)
        $otherUserId = $request->input('user_id');
        if (!$otherUserId) {
            return response()->json(['error' => 'user_id is required'], 400);
        }
        // تبديل حالة حظر المستخدم الآخر (إضافة إذا لم يكن موجوداً أو إزالته إذا كان موجوداً)
        $user->blockedUsers()->toggle($otherUserId);
        return response()->json('success');
    }

    public function getBlockedUsers()
    {
        // الحصول على المستخدم الحالي من خلال التوكن
        $user = JWTAuth::parseToken()->authenticate();
        $blockedUsers = $user->blockedUsers()->get();
        return response()->json($blockedUsers);
    }
}

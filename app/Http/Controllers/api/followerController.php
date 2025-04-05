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
        try {
            // الحصول على المستخدم الحالي من خلال التوكن
            $user = JWTAuth::parseToken()->authenticate();

            // التحقق من صحة وجود معرف المستخدم في الطلب
            $otherUserId = $request->input('user_id');
            if (!$otherUserId) {
                return response()->json(['error' => 'user_id is required'], 400);
            }

            // تبديل حالة حظر المستخدم الآخر (إضافة إذا لم يكن موجوداً أو إزالته إذا كان موجوداً)
            $result = $user->blockedUsers()->toggle($otherUserId);
            // نتيجة toggle ترجع مصفوفة تحتوي على مفتاحي 'attached' و 'detached'

            // إذا تم حظر المستخدم، قم بإزالته من قوائم المتابعة (followings) والمتابعين (followers)
            if ($result) {
                if ($user->followings()->where('follower_id', $otherUserId)->exists()) {
                    $user->followings()->detach($otherUserId);
                }
                if ($user->followings()->where('following_id', $otherUserId)->exists()) {
                    $user->followings()->detach($otherUserId);
                }
                if ($user->conversations()->where('user_one', $otherUserId)->exists()) {
                    $user->conversations()->detach($otherUserId);
                }
                if ($user->conversations()->where('user_two', $otherUserId)->exists()) {
                    $user->conversations()->detach($otherUserId);
                }
            }

            return response()->json([
                'status' => 'success',
                'blocked' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ أثناء تنفيذ العملية',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getBlockedUsers()
    {
        try {
            // الحصول على المستخدم الحالي من خلال التوكن
            $user = JWTAuth::parseToken()->authenticate();
            $blockedUsers = $user->blockedUsers()->get();
            return response()->json($blockedUsers, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'فشل جلب المستخدمين المحظورين', 'message' => $e->getMessage()], 500);
        }
    }
}

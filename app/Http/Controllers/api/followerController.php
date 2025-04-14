<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

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

        // التحقق من صحة وجود معرف المستخدم في الطلب
        $otherUserId = $request->input('user_id');
        if (!$otherUserId) {
            return response()->json(['error' => 'user_id is required'], 400);
        }

        // بدء معاملة لضمان سلامة العملية
        DB::beginTransaction();

        try {
            // تبديل حالة حظر المستخدم الآخر (إضافة إذا لم يكن موجوداً أو إزالته إذا كان موجوداً)
            $result = $user->blockedUsers()->toggle($otherUserId);
            // نتيجة toggle ترجع مصفوفة تحتوي على مفتاحي 'attached' و 'detached'

            // إذا تم حظر المستخدم، قم بإزالة العلاقات بين المستخدمين
            if (!empty($result['attached'])) {
                // إزالة من قوائم المتابعة - نفترض هنا أن العلاقة من نوع belongsToMany
                $user->followings()->detach($otherUserId);

                // إزالة من المحادثات - في حالة كانت العلاقة من نوع belongsToMany أو يتطلب حذف سجلات معينة في حالة hasMany
                // $user->conversations()->where(function ($query) use ($otherUserId) {
                //     $query->where('user_one', $otherUserId)
                //         ->orWhere('user_two', $otherUserId);
                // })->delete();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'blocked' => $result
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
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

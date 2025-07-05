<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\NotificationService;
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

        NotificationService::notify(
            $otherUserId,
            auth()->guard('api')->user()->name . ' قام بمتابعةك',
            $user
        );

        return response()->json('success');
    }

    public function getFollowersAndFollowing(User $user, $type)
    {
        if ($type === 'followers') {
            return $user->followers()->get();
        } elseif ($type === 'following') {
            return $user->followings()->get();
        }
        return response()->json(['error' => 'Invalid type'], 400);
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


    public function suggestions(Request $request)
    {
        $user = auth()->guard('api')->user();

        // Get the IDs of users that the current user is already following.
        // We assume you have a 'following' relationship defined in your User model.
        $followingIds = $user->followings()->pluck('users.id')->all();

        // Add the current user's ID to the array to exclude them from suggestions.
        $excludeIds = array_merge($followingIds, [$user->id]);

        // Fetch users to suggest.
        // We get users who are not in the exclusion list,
        // order them randomly, and take the first 10.
        $suggestedUsers = User::whereNotIn('id', $excludeIds)
            ->inRandomOrder()
            ->limit(10)
            ->get(['id', 'name', 'username']); // Select only needed fields

        return response()->json($suggestedUsers);
    }
}

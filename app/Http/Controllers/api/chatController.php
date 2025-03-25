<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class chatController extends Controller
{
    public function getConversations()
    {
        // استرجاع المستخدم المُسجّل
        $user = auth()->guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'unauthorized'], 401);
        }

        // استرجاع المحادثات التي يكون فيها المستخدم مشترك
        $conversations = Conversation::where('user_one', $user->id)
            ->orWhere('user_two', $user->id)
            ->with([
                'userOne',
                'userTwo',
                'messages' => function ($query) {
                    // جلب أحدث رسالة لكل محادثة (اختياري)
                    $query->orderBy('created_at', 'desc')->limit(1);
                }
            ])
            ->get();

        // استخراج بيانات جهة الاتصال لكل محادثة
        $chatPartners = $conversations->map(function ($conversation) use ($user) {
            // إذا كان المستخدم الحالي هو user_one، فإن جهة الاتصال هي userTwo والعكس صحيح
            return ($conversation->user_one == $user->id)
                ? $conversation->userTwo
                : $conversation->userOne;
        });

        // إعادة المصفوفة كاستجابة JSON
        return response()->json($chatPartners->values());
    }

    public function startConversation(Request $request)
    {
        // استرجاع المستخدم المُسجّل عبر API
        $user = auth()->guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'unauthorized'], 401);
        }

        // استلام معرف جهة الاتصال من الطلب
        $otherUserId = $request->input('user_id');

        // التحقق من صحة معرف جهة الاتصال وعدم مساواته لمعرف المستخدم الحالي
        if (!$otherUserId || $otherUserId == $user->id) {
            return response()->json(['message' => 'Invalid user id'], 400);
        }

        // التأكد من عدم وجود محادثة سابقة بين المستخدمين
        $conversation = Conversation::where(function ($query) use ($user, $otherUserId) {
            $query->where('user_one', $user->id)
                ->where('user_two', $otherUserId);
        })->orWhere(function ($query) use ($user, $otherUserId) {
            $query->where('user_one', $otherUserId)
                ->where('user_two', $user->id);
        })->first();

        if ($conversation) {
            // في حال وجود محادثة سابقة يتم إرجاعها مع رسالة توضيحية
            return response()->json([
                'message' => 'Conversation already exists',
                'conversation' => $conversation
            ], 200);
        }

        // إنشاء محادثة جديدة إذا لم تكن موجودة مسبقاً
        $conversation = Conversation::create([
            'user_one' => $user->id,
            'user_two' => $otherUserId,
        ]);

        return response()->json([
            'message' => 'Conversation started successfully',
            'conversation' => $conversation
        ], 201);
    }
}

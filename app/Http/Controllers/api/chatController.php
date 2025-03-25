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

        // استرجاع جميع المحادثات التي يكون فيها المستخدم مشترك (سواء كـ user_one أو user_two)
        $conversations = Conversation::where('user_one', $user->id)
            ->orWhere('user_two', $user->id)
            ->with([
                'messages' => function ($query) {
                    // جلب أحدث رسالة لكل محادثة
                    $query->orderBy('created_at', 'desc')->limit(1);
                },
                // جلب بيانات الطرفين من جدول users
                'userOne',
                'userTwo'
            ])
            ->get();

        // تحديد جهة الاتصال (الشريك في المحادثة) بناءً على المستخدم الحالي
        $conversations->transform(function ($conversation) use ($user) {
            // إذا كان المستخدم الحالي هو user_one، فإن الشريك هو userTwo، والعكس صحيح
            $conversation->chat_partner = ($conversation->user_one == $user->id)
                ? $conversation->userTwo
                : $conversation->userOne;
            return $conversation;
        });

        // ترتيب المحادثات بناءً على أحدث رسالة (أو تاريخ إنشاء المحادثة إذا لم توجد رسالة)
        $sortedConversations = $conversations->sortByDesc(function ($conversation) {
            return $conversation->messages->first()->created_at ?? $conversation->created_at;
        })->values();

        return response()->json($sortedConversations);
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

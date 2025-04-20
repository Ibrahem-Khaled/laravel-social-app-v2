<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExpoNotification;
use Illuminate\Support\Facades\Validator;

class chatController extends Controller
{
    public function getConversations()
    {
        // استرجاع المستخدم المُسجّل
        $user = auth()->guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'unauthorized'], 401);
        }

        // استرجاع المحادثات التي يكون فيها المستخدم مشترك مع تحميل بيانات الطرفين وأحدث رسالة
        $conversations = Conversation::where('user_one', $user->id)
            ->orWhere('user_two', $user->id)
            ->get();

        // إعادة النتائج كمصفوفة
        return response()->json([
            'conversations' => $conversations,
        ]);
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

    public function getMessages($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->where('type_message', 'normal')
            ->get();
        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        // التحقق من صحة المستخدم
        $user = auth()->guard('api')->user();
        if (!$user) {
            return response()->json(['message' => 'غير مصرح لك'], 401);
        }

        // التحقق من صحة البيانات الواردة باستخدام Validator
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // بدء معاملة قاعدة البيانات لضمان التكامل في حالة حدوث خطأ
            \DB::beginTransaction();

            // معالجة ملف الوسائط إذا وُجد
            $mediaPath = null;
            if ($request->hasFile('media')) {
                $mediaPath = $request->file('media')->store('uploads/media', 'public');
            }

            // تجهيز بيانات الرسالة
            $messageData = [
                'conversation_id' => $request->conversation_id,
                'sender_id' => $user->id,
                'message' => $request->message,
                'receiver_id' => $request->receiver_id,
            ];

            if ($mediaPath) {
                $messageData['media'] = $mediaPath;
            }

            // إنشاء سجل الرسالة في قاعدة البيانات
            $message = Message::create($messageData);

            // إرسال الإشعار للمستقبل إن وجد
            $receiver = User::find($request->receiver_id);
            if ($receiver && $receiver->expo_push_token) {
                Notification::send(
                    $receiver,
                    new ExpoNotification(
                        [$receiver->expo_push_token],
                        'رسالة جديدة من ' . $user->name,
                        $request->message
                    )
                );
            }

            // تأكيد المعاملة
            \DB::commit();

            return response()->json($message, 201);
        } catch (\Exception $e) {
            // التراجع عن المعاملة في حالة حدوث خطأ
            \DB::rollBack();
            return response()->json([
                'message' => 'حدث خطأ أثناء إرسال الرسالة',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteConversationMessages(Conversation $conversation)
    {
        $conversation->messages()->delete();
        return response()->json(['message' => 'تم حذف الرسائل بنجاح']);
    }

    public function deleteConversation($id)
    {
        $conversation = Conversation::findOrFail($id);
        $conversation->delete();
        return response()->json(['message' => 'تم حذف المحادثة بنجاح']);
    }


}

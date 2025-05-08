<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ExpoNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder; // تأكد من استيراد Builder
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function getConversations()
    {
        $user = auth()->guard('api')->user();

        // جلب المحادثات التي يشارك فيها المستخدم
        // مع تحميل بيانات الأعضاء، وأحدث رسالة لكل محادثة
        $conversations = Conversation::whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->with([
                'users',
            ])
            ->get();

        return response()->json([
            'conversations' => $conversations
        ], 200);
    }

    public function getPrivateConversations()
    {
        $user = auth()->guard('api')->user();

        $private = Conversation::where('is_group', false)                    // فِلترة المحادثات الثنائية
            ->whereHas('users', fn($q) => $q->where('user_id', $user->id))    // التأكد من اشتراك المستخدم
            ->with([
                'users',
            ])
            ->get();                                                        // تنفيذ الاستعلام :contentReference[oaicite:0]{index=0}

        return response()->json([
            'private_conversations' => $private
        ], 200);
    }

    /**
     * جلب المحادثات الجماعية فقط (جروبات)
     */
    public function getGroupConversations(Request $request)
    {
        $user = auth()->guard('api')->user();

        $groups = Conversation::where('is_group', true)
            ->where(function (Builder $q) use ($user) {
                $q->where('created_by', $user->id)
                    // أو الجروبات التي يشارك فيها
                    ->orWhereHas('users', function (Builder $q2) use ($user) {
                        $q2->where('user_id', $user->id);
                    });
            })
            ->get();

        return response()->json([
            'group_conversations' => $groups
        ], 200);
    }

    public function getConversation(Conversation $conversation)
    {
        $user = auth()->guard('api')->user();
        
        // get the conversation with the users, createdBy, and rules only it
        $conversation = $conversation->load(['users', 'createdBy']);
        return response()->json([
            'conversation' => $conversation
        ], 200);
    }

    /**
     * إنشاء أو جلب محادثة ثنائية (1-1)
     */
    public function createPrivate(Request $request)
    {
        $user = auth()->guard('api')->user();

        // التحقق من معرف الطرف الآخر
        $request->validate([
            'member_id' => 'required|exists:users,id|not_in:' . $user->id,
        ]);

        $otherId = $request->member_id;

        // البحث عن محادثة ثنائية قائمة بوجود العضوين
        $conversation = Conversation::where('is_group', false)
            ->whereHas('users', fn($q) => $q->where('user_id', $user->id))
            ->whereHas('users', fn($q) => $q->where('user_id', $otherId))
            ->withCount('users')
            ->having('users_count', 2)
            ->first();

        if (!$conversation) {
            // إن لم توجد، ننشئ محادثة جديدة
            $conversation = Conversation::create([
                'name' => null,
                'is_group' => false,
                'created_by' => $user->id,
            ]);
            // ربط العضوين
            $conversation->users()->attach([$user->id, $otherId]);
        }

        return response()->json([
            'conversation' => $conversation->load('users')
        ], 200);
    }

    /**
     * إنشاء جروب جديد
     */
    public function createGroup(Request $request)
    {
        $user = auth()->guard('api')->user();

        // 1) التحقق من البيانات الواردة
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'type' => 'nullable|string|in:normal,private',
            'members' => 'required|array|min:2',
            'members.*' => 'exists:users,id|not_in:' . $user->id,
        ]);

        // 2) استخدام معاملة قاعدة البيانات لضمان الاتساق
        $conversation = DB::transaction(function () use ($data, $user, $request) {
            // رفع الصورة إذا وجدت
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')
                    ->store('uploads/conversations', 'public');
            }

            // إنشاء الصف في جدول المحادثات
            $conv = Conversation::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'image' => $imagePath,
                'type' => $data['type'] ?? 'normal',
                'is_group' => true,
                'created_by' => $user->id,
            ]);

            // إرفاق الأعضاء المرسلة من الواجهة
            $conv->users()->attach($data['members']);

            // تعيين دور المنشئ كـ admin
            $conv->users()->updateExistingPivot($user->id, [
                'role' => 'admin'
            ]);

            return $conv;
        });

        // 3) إعادة المحادثة مع تحميل العلاقة users (ولاحقاً messages مثلاً)
        return response()->json([
            'conversation' => $conversation->load('users')
        ], 201);
    }

    /**
     * استرجاع جميع الرسائل من محادثة محددة
     */
    public function getMessages($conversationId)
    {
        // جلب الرسائل العادية فقط
        $messages = Message::where('conversation_id', $conversationId)
            ->where('type_message', 'normal')
            ->with([
                'sender' => function ($q) {
                    $q->select('id', 'name', 'image');
                },
                'receiver' => function ($q) {
                    $q->select('id', 'name', 'image');
                },
            ])
            ->get();

        return response()->json($messages, 200);
    }

    /**
     * إرسال رسالة (نصية أو وسائط)
     */
    public function sendMessage(Request $request)
    {
        $user = auth()->guard('api')->user();

        // التحقق من البيانات الواردة
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string',
            'receiver_id' => 'nullable|exists:users,id',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        \DB::beginTransaction();
        try {
            // معالجة ملف الوسائط إن وُجد وخزنه في القرص public
            $mediaPath = null;
            if ($request->hasFile('media')) {
                $mediaPath = $request->file('media')
                    ->store('uploads/media', 'public'); // :contentReference[oaicite:0]{index=0}
            }

            // إنشاء الرسالة
            $message = Message::create([
                'conversation_id' => $request->conversation_id,
                'sender_id' => $user->id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'media' => $mediaPath,
            ]);

            // إرسال إشعار للمستقبل عبر Expo (إذا ثبت التوكين)
            $receiver = User::find($request->receiver_id);
            if ($receiver && $receiver->expo_push_token) {
                Notification::send(
                    $receiver,
                    new ExpoNotification(
                        [$receiver->expo_push_token],
                        'رسالة جديدة من ' . $user->name,
                        $request->message
                    )
                ); // :contentReference[oaicite:1]{index=1}
            }

            \DB::commit();
            return response()->json($message, 201);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'message' => 'حدث خطأ أثناء إرسال الرسالة',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف كافة رسائل محادثة معينة
     */
    public function deleteConversationMessages($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $conversation->messages()->delete();

        return response()->json(['message' => 'تم حذف الرسائل بنجاح'], 200);
    }

    /**
     * حذف المحادثة بكامل بياناتها (وسائط ورسائل)
     */
    public function deleteConversation($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $conversation->delete();

        return response()->json(['message' => 'تم حذف المحادثة بنجاح'], 200);
    }
    /**
     * حذف رسالة معينة
     */
    public function deleteMessage($messageId)
    {
        $message = Message::findOrFail($messageId);

        // حذف ملف الوسائط من القرص إن وُجد
        if ($message->media) {
            Storage::disk('public')->delete($message->media);
        }

        $message->delete();

        return response()->json(['message' => 'تم حذف الرسالة بنجاح'], 200);
    }
}
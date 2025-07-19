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
use Carbon\Carbon;


class ChatController extends Controller
{
    public function getConversations()
    {
        $user = auth()->guard('api')->user();

        $conversations = Conversation::whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->with([
                'users' => function ($query) use ($user) {
                    // ...
                },
                'latestMessage'
            ])
            // -- الإضافة الجديدة هنا --
            // حساب عدد الرسائل غير المقروءة لكل محادثة بكفاءة
            ->withCount('unreadMessagesForCurrentUser')
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->limit(1)
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'conversations' => $conversations
        ], 200);
    }

    public function getPrivateConversations()
    {
        $user = auth()->guard('api')->user();

        $private = Conversation::where('is_group', false)
            ->whereHas('users', fn($q) => $q->where('user_id', $user->id))
            ->with(['users', 'latestMessage'])
            // -- الإضافة الجديدة هنا --
            // حساب عدد الرسائل غير المقروءة لكل محادثة بكفاءة
            ->withCount('unreadMessagesForCurrentUser')
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->limit(1)
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'private_conversations' => $private
        ], 200);
    }

    /**
     * جلب المحادثات الجماعية مرتبة حسب آخر رسالة
     */
    public function getGroupConversations(Request $request)
    {
        $user = auth()->guard('api')->user();

        $groups = Conversation::where('is_group', true)
            ->where(function (Builder $q) use ($user) {
                $q->where('created_by', $user->id)
                    ->orWhereHas('users', fn(Builder $q2) => $q2->where('user_id', $user->id));
            })
            // -- نفس التعديلات هنا --
            ->with(['users', 'latestMessage']) // جلب المستخدمين وآخر رسالة
            ->orderByDesc( // الترتيب حسب آخر رسالة
                Message::select('created_at')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->limit(1)
            )
            ->orderBy('created_at', 'desc') // ترتيب ثانوي
            ->get();

        return response()->json([
            'group_conversations' => $groups
        ], 200);
    }

    // ... (دالة getConversation تبقى كما هي)
    public function getConversation(Conversation $conversation)
    {
        $user = auth()->guard('api')->user();
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
            'members' => 'required|array|min:1',
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

    public function updateGroup(Request $request, Conversation $conversation)
    {
        $user = auth()->guard('api')->user();

        // التحقق من أن المستخدم هو منشئ المحادثة
        if ($conversation->created_by !== $user->id) {
            return response()->json(['message' => 'ليس لديك إذن لتحديث هذه المحادثة'], 403);
        }

        // التحقق من البيانات الواردة
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'type' => 'nullable|string|in:normal,private',
        ]);

        // رفع الصورة إذا وجدت
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('uploads/conversations', 'public');
            $conversation->update(['image' => $imagePath]);
        }

        // تحديث بيانات المحادثة
        $conversation->update($data);

        return response()->json([
            'conversation' => $conversation
        ], 200);
    }

    public function LeaveGroup(Conversation $conversation)
    {
        $user = auth()->guard('api')->user();

        // التحقق من أن المستخدم هو أحد أعضاء المحادثة
        if (!$conversation->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'لا يمكنك مغادرة هذه المحادثة'], 403);
        }

        // حذف المستخدم من المحادثة
        $conversation->users()->detach($user->id);

        return response()->json(['message' => 'تم مغادرة المحادثة بنجاح'], 200);
    }

    /**
     * استرجاع جميع الرسائل من محادثة محددة
     */
    public function getMessages($conversationId)
    {
        $currentUser = auth()->guard('api')->user();

        // هذا الجزء يبقى كما هو لتحديث حالة القراءة
        Message::where('conversation_id', 'like', $conversationId)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // --- ✨ التعديل هنا لجلب الرسائل بدون المحذوفة ✨ ---
        $messages = Message::where('conversation_id', 'like', $conversationId)
            ->where('type_message', 'normal')

            // -- الجزء المضاف --
            // لا تجلب الرسائل التي لها علاقة بـ "المستخدمين الحاذفين"
            // حيث يكون المستخدم الحالي واحدًا منهم
            ->whereDoesntHave('deletedByUsers', function ($query) use ($currentUser) {
                $query->where('user_id', $currentUser->id);
            })
            // -- نهاية الجزء المضاف --

            ->with([
                'sender' => function ($q) {
                    $q->select('id', 'name');
                },
                'receiver' => function ($q) {
                    $q->select('id', 'name');
                },
            ])
            ->paginate(30);

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
            'message' => 'nullable|required_without:media|string|max:1000',
            'receiver_id' => 'nullable|exists:users,id',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi,mkv|max:20480',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
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

            DB::commit();
            return response()->json($message, 201);
        } catch (\Exception $e) {
            DB::rollBack();
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
        // جلب المستخدم الحالي المسجل
        $user = auth()->guard('api')->user();

        // التأكد من وجود المحادثة لتجنب الأخطاء
        $conversation = Conversation::findOrFail($conversationId);

        // 1. جلب كل معرفات (IDs) الرسائل الموجودة في هذه المحادثة
        $messageIds = $conversation->messages()->pluck('id')->all();

        // 2. التحقق من وجود رسائل لحذفها
        if (empty($messageIds)) {
            return response()->json(['message' => 'لا توجد رسائل لحذفها في هذه المحادثة.'], 200);
        }

        // 3. ✨ الجزء الأساسي: ربط كل هذه الرسائل بالمستخدم الحالي كـ "محذوفة"
        // نستخدم العلاقة التي أنشأناها في موديل User
        // attach() ستقوم بإضافة كل الأزواج (user_id, message_id) إلى الجدول الوسيط
        $user->deletedMessages()->syncWithoutDetaching($messageIds);

        return response()->json(['message' => 'تم حذف جميع رسائل المحادثة لديك فقط.'], 200);
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
    public function deleteMessage(Request $request, $messageId)
    {
        $request->validate([
            'scope' => 'nullable|string|in:me,all', // 'me' for me, 'all' for everyone
        ]);

        $user = $request->user(); // أو Auth::user()
        $message = Message::findOrFail($messageId);

        // إذا لم يحدد المستخدم النطاق، يكون الافتراضي هو 'me'
        $scope = $request->input('scope', 'me');

        if ($scope === 'all') {
            // --- منطق الحذف للجميع ---

            // الشرط 1: فقط مُرسل الرسالة يمكنه حذفها للجميع
            if ($message->sender_id !== $user->id) {
                return response()->json(['message' => 'لا تملك الصلاحية لحذف هذه الرسالة للجميع.'], 403);
            }

            // الشرط 2 (اختياري): السماح بالحذف للجميع خلال فترة زمنية محددة (مثلاً: ساعة)
            if (Carbon::now()->diffInMinutes($message->created_at) > 60) {
                return response()->json(['message' => 'انتهت الفترة الزمنية المسموحة لحذف هذه الرسالة للجميع.'], 403);
            }

            // حذف ملف الوسائط من القرص إن وُجد
            if ($message->media) {
                Storage::disk('public')->delete($message->media);
            }

            // الحذف الفعلي للرسالة من قاعدة البيانات
            $message->delete();

            return response()->json(['message' => 'تم حذف الرسالة للجميع بنجاح.'], 200);
        } else {

            $user->deletedMessages()->attach($message->id);

            return response()->json(['message' => 'تم حذف الرسالة لديك فقط.'], 200);
        }
    }
}

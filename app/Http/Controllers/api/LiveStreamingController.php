<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LiveStreaming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Throwable;

class LiveStreamingController extends Controller
{
    public function index()
    {
        $liveStreams = LiveStreaming::with(['user', 'agency'])
            ->where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status'  => true,
            'message' => $liveStreams->isEmpty()
                ? 'لا توجد بثوث حية حالياً'
                : 'تم استرجاع البثوث الحية بنجاح',
            'data'    => $liveStreams,
        ]);
    }

    public function getLiveStreams()
    {
        $liveStream = LiveStreaming::with(['user', 'agency'])
            ->where('status', true)
            ->where('type', 'live')
            ->orderBy('created_at', 'desc')
            ->get();

        if (!$liveStream) {
            return response()->json([
                'status'  => false,
                'message' => 'لا يوجد بث مباشر حاليًا',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'تم استرجاع البث المباشر بنجاح',
            'data'    => $liveStream,
        ]);
    }

    public function getAudioRooms()
    {
        $audioRooms = LiveStreaming::with(['user', 'agency'])
            ->where('status', true)
            ->where('type', 'audio_room')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($audioRooms->isEmpty()) {
            return response()->json([
                'status'  => false,
                'message' => 'لا توجد غرف صوتية حاليًا',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'تم استرجاع الغرف الصوتية بنجاح',
            'data'    => $audioRooms,
        ]);
    }

    public function getLiveStreamsByFollowing()
    {
        $userId = auth()->guard('api')->id();

        $liveStreams = LiveStreaming::with(['user', 'agency'])
            ->where('status', true)
            ->where('type', 'live')
            ->whereHas('user.followers', function ($query) use ($userId) {
                $query->where('follower_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        if ($liveStreams->isEmpty()) {
            return response()->json([
                'status'  => false,
                'message' => 'لا توجد بثوث حية من المتابعين',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'تم استرجاع البثوث الحية من المتابعين بنجاح',
            'data'    => $liveStreams,
        ]);
    }

    public function show(LiveStreaming $liveStream)
    {
        $liveStream->load(['user', 'agency']);

        return response()->json([
            'status'  => true,
            'message' => 'تم استرجاع البث بنجاح',
            'data'    => $liveStream,
        ]);
    }
    public function store(Request $request)
    {
        // الطريقة الأفضل لجلب المستخدم الحالي للـ API
        $user = auth()->guard('api')->user();

        $validator = Validator::make($request->all(), [
            'agency_id'    => 'nullable|exists:agencies,id',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string|max:1000',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'     => 'nullable|string|max:255',
            'type'         => 'required|in:live,audio_room',
            'scheduled_at' => 'nullable|date|after_or_equal:now', // تحسين: التأكد أن الوقت مجدول في المستقبل
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'خطأ في التحقق من البيانات.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();

        // استخدام العمليات المجمعة (Transaction) لضمان تكامل البيانات
        try {
            $liveStream = DB::transaction(function () use ($request, $validatedData, $user) {
                // 1. التعامل مع رفع الصورة
                if ($request->hasFile('thumbnail')) {
                    // حذف الصورة القديمة إذا كانت موجودة قبل رفع الجديدة
                    if ($user->livestream && $user->livestream->thumbnail) {
                        Storage::disk('public')->delete($user->livestream->thumbnail);
                    }
                    $validatedData['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
                }

                // 2. إضافة البيانات الافتراضية
                $validatedData['status'] = true; // الحالة الافتراضية للبث هي "فعال"

                // 3. ✨ التصحيح والمنطق الأساسي: تحديث البث الموجود أو إنشاء جديد
                // هذه هي الطريقة الصحيحة لتطبيق علاقة hasOne
                return $user->livestream()->updateOrCreate(
                    [], // لا حاجة لتمرير شروط البحث، فالعلاقة تحددها تلقائياً
                    $validatedData // البيانات التي سيتم تحديثها أو استخدامها للإنشاء
                );
            });

            return response()->json([
                'status'  => true,
                'message' => 'تم حفظ بيانات البث بنجاح.',
                'data'    => $liveStream,
            ], 201);
        } catch (Throwable $e) {
            // في حالة حدوث أي خطأ، تراجع عن كل شيء
            // إذا تم رفع صورة جديدة أثناء الخطأ، قم بحذفها
            if (!empty($validatedData['thumbnail'])) {
                Storage::disk('public')->delete($validatedData['thumbnail']);
            }

            Log::error('Livestream store/update failed: ' . $e->getMessage()); // تسجيل الخطأ للمطورين

            return response()->json([
                'status'  => false,
                'message' => 'حدث خطأ غير متوقع أثناء حفظ البث.',
            ], 500);
        }
    }

    public function destroyMyLivestream()
    {
        // 1. جلب المستخدم المسجل دخوله
        $user = auth()->guard('api')->user();

        // 2. الوصول إلى البث المرتبط به عبر علاقة hasOne
        $liveStream = $user->livestream;

        // 3. التأكد من أن المستخدم لديه بث أصلاً
        if (!$liveStream) {
            return response()->json([
                'status'  => false,
                'message' => 'ليس لديك بث مباشر لحذفه',
            ], 404); // 404 Not Found
        }

        // 4. تنفيذ الحذف
        // ملاحظة: إذا كنت قد طبقت الـ Model Event، فلن تحتاج لسطر حذف الصورة هنا
        if ($liveStream->thumbnail) {
            Storage::disk('public')->delete($liveStream->thumbnail);
        }
        $liveStream->delete();

        // 5. إرجاع رسالة نجاح
        return response()->json([
            'status'  => true,
            'message' => 'تم حذف البث الخاص بك بنجاح',
        ]);
    }
}

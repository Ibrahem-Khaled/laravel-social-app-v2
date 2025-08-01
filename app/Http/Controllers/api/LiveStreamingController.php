<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LiveStreaming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // <-- لاستخدامه في إنشاء اسم القناة
use Throwable;

class LiveStreamingController extends Controller
{
    /**
     * جلب كل البثوث الحية (فيديو وصوت) مع دعم التصفح (Pagination).
     */
    public function index()
    {
        // التحسين: استخدام status enum بدلاً من boolean.
        // التحسين: إضافة paginate لجلب عدد محدد من النتائج في كل مرة.
        $liveStreams = LiveStreaming::with(['user', 'agency'])
            ->where('status', 'live') // <-- التغيير: البحث عن البثوث الحية فقط
            ->orderBy('created_at', 'desc')
            ->paginate(15); // <-- إضافة: لجعل الـ API قابلاً للتطوير

        return response()->json([
            'status'  => true,
            'message' => $liveStreams->isEmpty()
                ? 'لا توجد بثوث حية حالياً'
                : 'تم استرجاع البثوث الحية بنجاح',
            'data'    => $liveStreams,
        ]);
    }

    /**
     * جلب بثوث الفيديو الحية فقط.
     */
    public function getLiveStreams()
    {
        $liveStreams = LiveStreaming::with(['user', 'agency'])
            ->where('status', 'live') // <-- التغيير: استخدام status enum
            ->where('type', 'live')
            ->orderBy('created_at', 'desc')
            ->get();

        // التصحيح: التحقق من أن المجموعة فارغة باستخدام isEmpty()
        if ($liveStreams->isEmpty()) {
            return response()->json([
                'status'  => true, // إرجاع true ولكن مع بيانات فارغة ورسالة مناسبة
                'message' => 'لا يوجد بث مباشر حاليًا',
                'data'    => [],
            ], 200);
        }

        return response()->json([
            'status'  => true,
            'message' => 'تم استرجاع البث المباشر بنجاح',
            'data'    => $liveStreams,
        ]);
    }

    /**
     * جلب الغرف الصوتية الحية فقط.
     */
    public function getAudioRooms()
    {
        $audioRooms = LiveStreaming::with(['user', 'agency'])
            ->where('status', 'live') // <-- التغيير: استخدام status enum
            ->where('type', 'audio_room')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($audioRooms->isEmpty()) {
            return response()->json([
                'status'  => true,
                'message' => 'لا توجد غرف صوتية حاليًا',
                'data'    => [],
            ], 200);
        }

        return response()->json([
            'status'  => true,
            'message' => 'تم استرجاع الغرف الصوتية بنجاح',
            'data'    => $audioRooms,
        ]);
    }

    /**
     * جلب البثوث الحية للمستخدمين الذين يتابعهم المستخدم الحالي.
     */
    public function getLiveStreamsByFollowing()
    {
        $userId = auth()->guard('api')->id();
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $liveStreams = LiveStreaming::with(['user', 'agency'])
            ->where('status', 'live') // <-- التغيير: استخدام status enum
            ->where('type', 'live')
            ->whereHas('user.followers', function ($query) use ($userId) {
                $query->where('follower_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        if ($liveStreams->isEmpty()) {
            return response()->json([
                'status'  => true,
                'message' => 'لا توجد بثوث حية من المستخدمين الذين تتابعهم',
                'data'    => [],
            ], 200);
        }

        return response()->json([
            'status'  => true,
            'message' => 'تم استرجاع البثوث الحية من المتابعين بنجاح',
            'data'    => $liveStreams,
        ]);
    }

    /**
     * عرض تفاصيل بث مباشر محدد.
     */
    public function show(LiveStreaming $liveStream)
    {
        $liveStream->load(['user', 'agency']);

        return response()->json([
            'status'  => true,
            'message' => 'تم استرجاع البث بنجاح',
            'data'    => $liveStream,
        ]);
    }

    /**
     * إنشاء أو تحديث بث مباشر للمستخدم الحالي.
     */
    public function store(Request $request)
    {
        $user = auth()->guard('api')->user();

        $validator = Validator::make($request->all(), [
            'title'       => 'nullable|string|max:255',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type'        => 'required|in:live,audio_room',
            // الحقول القديمة التي لم نعد بحاجة إليها في الإنشاء:
            // agency_id, description, password, scheduled_at
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'خطأ في التحقق.', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        try {
            $liveStream = DB::transaction(function () use ($request, $validatedData, $user) {
                if ($request->hasFile('thumbnail')) {
                    // حذف الصورة القديمة إذا وجدت
                    if ($user->livestream && $user->livestream->thumbnail) {
                        Storage::disk('public')->delete($user->livestream->thumbnail);
                    }
                    $validatedData['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
                }

                // التحسين: إضافة البيانات الجديدة المطلوبة حسب السكيما
                $validatedData['status'] = 'live'; // <-- الحالة الافتراضية هي "live"
                $validatedData['channel_name'] = "stream_{$user->id}_" . Str::random(10); // <-- إنشاء اسم قناة فريد

                // تحديث البث الموجود أو إنشاء جديد (لضمان أن لكل مستخدم بث واحد فعال)
                return $user->livestream()->updateOrCreate(
                    ['user_id' => $user->id], // الشرط للبحث عن البث
                    $validatedData // البيانات للتحديث أو الإنشاء
                );
            });

            return response()->json([
                'status'  => true,
                'message' => 'تم بدء البث المباشر بنجاح.',
                'data'    => $liveStream,
            ], 201);

        } catch (Throwable $e) {
            Log::error('Livestream store/update failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'حدث خطأ غير متوقع.'], 500);
        }
    }

    /**
     * إنهاء البث المباشر للمستخدم الحالي (بدلاً من حذفه).
     */
    public function destroyMyLivestream()
    {
        $user = auth()->guard('api')->user();

        // التحسين: البحث عن البث "الحي" فقط لإنهاءه
        $liveStream = $user->livestream();

        if (!$liveStream) {
            return response()->json([
                'status'  => false,
                'message' => 'ليس لديك بث مباشر فعال حاليًا',
            ], 404);
        }

        // التحسين: تغيير الحالة إلى "منتهي" بدلاً من الحذف
        // هذا يحافظ على سجل البث (الهدايا، الإعجابات، إلخ)
        $liveStream->update(['status' => 'ended']);

        return response()->json([
            'status'  => true,
            'message' => 'تم إنهاء البث الخاص بك بنجاح',
        ]);
    }
}

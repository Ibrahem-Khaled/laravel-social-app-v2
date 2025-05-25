<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LiveStreaming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'agency_id'         => 'nullable|exists:agencies,id',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string|max:1000',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'          => 'nullable|string|max:255',
            'type'              => 'required|in:live,audio_room',
            'scheduled_at'      => 'nullable|date',
        ]);                                                       // قواعد التحقق من البيانات :contentReference[oaicite:1]{index=1}

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'خطأ في التحقق من البيانات',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->guard('api')->id();
        $data['status']  = true;  // افتراضياً غير مُباشر

        // تخزين الصورة إن وجدت
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('thumbnails', 'public');
        }

        $liveStream = LiveStreaming::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'تم إنشاء البث بنجاح',
            'data'    => $liveStream,
        ], 201);
    }

    public function update(Request $request, LiveStreaming $liveStream)
    {
        if (auth()->guard('api')->id() !== $liveStream->user_id) {
            return response()->json([
                'status'  => false,
                'message' => 'غير مصرح لك بتعديل هذا البث',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'agency_id'         => 'nullable|exists:agencies,id',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string|max:1000',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'          => 'nullable|string|max:255',
            'type'              => 'required|in:live,audio_room',
            'status'            => 'required|boolean',
            'scheduled_at'      => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'خطأ في التحقق من البيانات',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('thumbnails', 'public');
        }

        $liveStream->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'تم تحديث البث بنجاح',
            'data'    => $liveStream,
        ]);
    }

    public function destroy(LiveStreaming $liveStream)
    {
        if (auth()->guard('api')->id() !== $liveStream->user_id) {
            return response()->json([
                'status'  => false,
                'message' => 'غير مصرح لك بحذف هذا البث',
            ], 403);
        }

        $liveStream->delete();

        return response()->json([
            'status'  => true,
            'message' => 'تم حذف البث بنجاح',
        ]);
    }
}

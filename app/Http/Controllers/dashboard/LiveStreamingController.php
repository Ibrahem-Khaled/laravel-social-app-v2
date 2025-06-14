<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\LiveStreaming;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LiveStreamingController extends Controller
{
    public function index(Request $request)
    {
        $query = LiveStreaming::with(['user', 'agency']);

        // فلترة حسب النوع
        if ($request->has('type') && in_array($request->type, ['live', 'audio_room'])) {
            $query->where('type', $request->type);
        }

        // فلترة حسب الحالة
        if ($request->has('status') && in_array($request->status, ['0', '1'])) {
            $query->where('status', $request->status);
        }

        // البحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        $streams = $query->latest()->paginate(10);

        // إحصائيات
        $totalStreams = LiveStreaming::count();
        $activeStreams = LiveStreaming::where('status', true)->count();
        $liveStreams = LiveStreaming::where('type', 'live')->count();
        $audioRooms = LiveStreaming::where('type', 'audio_room')->count();
        $agencies = Agency::all();
        return view('dashboard.live-streamings.index', compact(
            'streams',
            'totalStreams',
            'activeStreams',
            'liveStreams',
            'audioRooms',
            'agencies'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:live,audio_room',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6',
            'scheduled_at' => 'nullable|date',
            'agency_id' => 'nullable|exists:agencies,id'
        ]);

        $data = $request->except('thumbnail');

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('live-streamings/thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        $data['user_id'] = auth()->id();
        $data['status'] = $request->has('status');

        LiveStreaming::create($data);

        return redirect()->route('live-streamings.index')
            ->with('success', 'تم إنشاء البث المباشر بنجاح');
    }

    public function update(Request $request, LiveStreaming $liveStreaming)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:live,audio_room',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6',
            'scheduled_at' => 'nullable|date',
            'agency_id' => 'nullable|exists:agencies,id'
        ]);

        $data = $request->except('thumbnail');

        if ($request->hasFile('thumbnail')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($liveStreaming->thumbnail) {
                Storage::disk('public')->delete($liveStreaming->thumbnail);
            }

            $path = $request->file('thumbnail')->store('live-streamings/thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        $data['status'] = $request->has('status');

        $liveStreaming->update($data);

        return redirect()->route('live-streamings.index')
            ->with('success', 'تم تحديث البث المباشر بنجاح');
    }

    public function destroy(LiveStreaming $liveStreaming)
    {
        // حذف الصورة إذا كانت موجودة
        if ($liveStreaming->thumbnail) {
            Storage::disk('public')->delete($liveStreaming->thumbnail);
        }

        $liveStreaming->delete();

        return redirect()->route('live-streamings.index')
            ->with('success', 'تم حذف البث المباشر بنجاح');
    }

    public function statistics()
    {
        // إحصائيات متقدمة
        $streamStats = LiveStreaming::selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN type = "live" THEN 1 ELSE 0 END) as live,
            SUM(CASE WHEN type = "audio_room" THEN 1 ELSE 0 END) as audio_rooms,
            SUM(likes) as total_likes
        ')->first();

        // البثوث المجدولة
        $upcomingStreams = LiveStreaming::where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get();

        // أكثر البثوث تفاعلاً
        $mostLikedStreams = LiveStreaming::orderBy('likes', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.live-streamings.statistics', compact(
            'streamStats',
            'upcomingStreams',
            'mostLikedStreams'
        ));
    }
}

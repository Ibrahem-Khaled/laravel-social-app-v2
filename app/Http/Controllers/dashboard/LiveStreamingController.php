<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\LiveStreaming;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LiveStreamingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedStatus = $request->query('status', 'all');
        $statuses = ['scheduled', 'live', 'ended'];

        $liveStreamingsQuery = LiveStreaming::with('user');

        // Filter by status
        if (in_array($selectedStatus, $statuses)) {
            $liveStreamingsQuery->where('status', $selectedStatus);
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $liveStreamingsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $liveStreamings = $liveStreamingsQuery->latest()->paginate(10);

        // Statistics
        $stats = [
            'total' => LiveStreaming::count(),
            'live' => LiveStreaming::where('status', 'live')->count(),
            'scheduled' => LiveStreaming::where('status', 'scheduled')->count(),
            'ended' => LiveStreaming::where('status', 'ended')->count(),
        ];

        // For create/edit modals
        $users = User::all(); // Assuming you want to assign a user to a stream

        return view('dashboard.live_streamings.index', compact('liveStreamings', 'stats', 'statuses', 'selectedStatus', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:6',
            'type' => ['required', Rule::in(['live', 'audio_room'])],
            'status' => ['required', Rule::in(['scheduled', 'live', 'ended'])],
            'scheduled_at' => 'nullable|date',
        ]);

        $data = $request->except('thumbnail');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('live_streamings/thumbnails', 'public');
        }

        LiveStreaming::create($data);

        return redirect()->route('live-streamings.index')->with('success', 'تم إضافة البث المباشر بنجاح.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LiveStreaming $liveStreaming)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:6',
            'type' => ['required', Rule::in(['live', 'audio_room'])],
            'status' => ['required', Rule::in(['scheduled', 'live', 'ended'])],
            'scheduled_at' => 'nullable|date',
        ]);

        $data = $request->except('thumbnail');

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists
            if ($liveStreaming->thumbnail) {
                Storage::disk('public')->delete($liveStreaming->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('live_streamings/thumbnails', 'public');
        }

        $liveStreaming->update($data);

        return redirect()->route('live-streamings.index')->with('success', 'تم تحديث البث المباشر بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LiveStreaming $liveStreaming)
    {
        // Delete the thumbnail from storage
        if ($liveStreaming->thumbnail) {
            Storage::disk('public')->delete($liveStreaming->thumbnail);
        }

        $liveStreaming->delete();

        return redirect()->route('live-streamings.index')->with('success', 'تم حذف البث المباشر بنجاح.');
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

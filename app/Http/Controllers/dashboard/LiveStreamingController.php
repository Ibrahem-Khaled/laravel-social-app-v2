<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\LiveStreaming;
use App\Models\User;
use Illuminate\Http\Request;

class LiveStreamingController extends Controller
{
    public function index()
    {
        $liveStreamings = LiveStreaming::all();
        $users = User::all();
        $agencies = Agency::all();
        return view('dashboard.live_streamings.index', compact('liveStreamings', 'users', 'agencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'agency_id' => 'nullable|exists:agencies,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,live,completed,cancelled',
            'scheduled_at' => 'nullable|date',
        ]);

        LiveStreaming::create($request->all());

        return redirect()->route('live_streamings.index')->with('success', 'Live Streaming created successfully.');
    }

    public function update(Request $request, LiveStreaming $liveStreaming)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'agency_id' => 'nullable|exists:agencies,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,live,completed,cancelled',
            'scheduled_at' => 'nullable|date',
        ]);

        $liveStreaming->update($request->all());

        return redirect()->route('live_streamings.index')->with('success', 'Live Streaming updated successfully.');
    }

    public function destroy(LiveStreaming $liveStreaming)
    {
        $liveStreaming->delete();
        return redirect()->route('live_streamings.index')->with('success', 'Live Streaming deleted successfully.');
    }
}

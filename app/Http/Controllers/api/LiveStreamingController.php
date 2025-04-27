<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LiveStreaming;
use Illuminate\Http\Request;

class LiveStreamingController extends Controller
{
    public function index()
    {
        $liveStreams = LiveStreaming::with('user')
            ->where('status', 'live')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($liveStreams->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No live streams found',
                'data' => [],
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Live streams retrieved successfully',
            'data' => $liveStreams,
        ]);
    }

    public function show(LiveStreaming $liveStream)
    {
        $liveStream->load('user');

        return response()->json([
            'status' => true,
            'message' => 'Live stream retrieved successfully',
            'data' => $liveStream,
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|max:255',
            'scheduled_at' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $liveStream = LiveStreaming::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $request->file('thumbnail') ? $request->file('thumbnail')->store('thumbnails', 'public') : null,
            'password' => $request->password,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Live stream created successfully',
            'data' => $liveStream,
        ]);
    }

    public function update(Request $request, LiveStreaming $liveStream)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|max:255',
            'scheduled_at' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $liveStream->update([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $request->file('thumbnail') ? $request->file('thumbnail')->store('thumbnails', 'public') : null,
            'password' => $request->password,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Live stream updated successfully',
            'data' => $liveStream,
        ]);
    }
    public function destroy(LiveStreaming $liveStream)
    {
        $liveStream->delete();

        return response()->json([
            'status' => true,
            'message' => 'Live stream deleted successfully',
        ]);
    }

}

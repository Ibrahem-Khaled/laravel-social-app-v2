<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReelsController extends Controller
{
    public function createReel(Request $request)
    {
        $user = auth()->guard('api')->user();

        $validator = Validator::make($request->all(), [
            'content' => 'nullable|string',
            'video' => 'required|file|mimes:mp4,avi,mov|max:20480', // 20MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('video');
        // معالجة الفيديو
        if ($request->hasFile('video')) {
            try {
                $path = $request->file('video')->store('public/reels');
                $data['video'] = str_replace('public/', '', $path);
            } catch (\Exception $e) {
                return response()->json(['message' => 'فشل رفع الفيديو', 'error' => $e->getMessage()], 500);
            }
        }

        $post = $user->posts()->create([
            'content' => $data['content'] ?? null,
            'video' => $data['video'],
            'type' => 'video',
        ]);

        return response()->json($post);
    }

    public function getReels()
    {
        $reels = Post::where('type', 'video')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($reels->isEmpty()) {
            return response()->json(['message' => 'لا توجد مقاطع فيديو'], 404);
        }
        return response()->json($reels);
    }
}

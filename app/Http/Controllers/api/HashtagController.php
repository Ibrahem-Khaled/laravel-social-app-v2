<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    public function index()
    {
        $topHashtags = Hashtag::orderByDesc('usage_count')->take(10)->get();
        if ($topHashtags->isEmpty()) {
            return response()->json(['message' => 'No hashtags found.'], 404);
        }
        return response()->json($topHashtags);
    }

    public function getPostsByHashtag(Request $request)
    {
        $hashtag = Hashtag::where('name', $request->hashtag)->first();
        if (!$hashtag) {
            return response()->json(['message' => 'Hashtag not found.'], 404);
        }
        $posts = $hashtag->posts()
            ->with('user', 'hashtags')
            ->latest()
            ->paginate(10);

        return response()->json($posts);
    }
}

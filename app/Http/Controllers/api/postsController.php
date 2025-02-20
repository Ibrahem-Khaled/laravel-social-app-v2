<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class postsController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->get();

        return response()->json($posts);
    }
}

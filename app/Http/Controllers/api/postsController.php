<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function create(Request $request)
    {
        $user = auth()->guard('api')->user();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'content' => 'nullable|string',
            'status' => 'required|in:active,inactive,banned',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $request->except('images');

        // معالجة الصور
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/posts');
                $images[] = str_replace('public/', '', $path);
            }
            $data['images'] = json_encode($images);
        }
        $post = Post::create($data);
        return response()->json($post);
    }
}

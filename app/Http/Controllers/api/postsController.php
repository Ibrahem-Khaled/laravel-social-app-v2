<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class postsController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = auth()->guard('api')->user();
        $blockedUserIds = $currentUser->blockedUsers()->pluck('blocked_user_id');

        // احصل على رقم الصفحة من الاستعلام (افتراضي 1)
        $pageSize = 10;

        $posts = Post::where('status', 'active')
            ->whereNotIn('user_id', $blockedUserIds)
            ->orderBy('created_at', 'desc')
            ->with('user', 'message')
            ->paginate($pageSize);

        return response()->json($posts);
    }

    public function getUserPosts($id)
    {
        $posts = Post::where('user_id', $id)->with('user')->get();
        return response()->json($posts);
    }
    public function create(Request $request)
    {
        $user = auth()->guard('api')->user();

        $validator = Validator::make($request->all(), [
            'content' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
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

        $post = $user->posts()->create($data);

        return response()->json($post);
    }
    public function update(Request $request, $post)
    {
        $user = auth()->guard('api')->user();
        $post = Post::findOrFail($post);

        if ($post->user_id != $user->id) {
            return response()->json(['message' => 'غير مصرح به'], 401);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('images');

        // معالجة الصور إذا تم رفع صور جديدة
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                try {
                    $path = $image->store('public/posts');
                    $images[] = str_replace('public/', '', $path);
                } catch (\Exception $e) {
                    return response()->json(['message' => 'فشل رفع الصور', 'error' => $e->getMessage()], 500);
                }
            }
            $data['images'] = json_encode($images);
        }

        $post->update($data);

        // في الاختبار، يمكنك عرض بيانات الطلب للتأكد من وصولها، ولكن في النهاية يُفضل إرجاع المنشور المحدث
        return response()->json($post);
    }


    public function delete(Post $post)
    {
        $user = auth()->guard('api')->user();
        if ($post->user_id == $user->id) {
            $post->delete();
            return response()->json(['message' => 'تم حذف المنشور بنجاح']);
        }
        return response()->json(['message' => 'غير مصرح به'], 401);
    }

    public function pinnedPost(Post $post)
    {
        $user = auth()->guard('api')->user();
        if ($post->user_id == $user->id) {
            $post->pinned = !$post->pinned;
            $post->save();
            return response()->json(['message' => 'تم تغيير حالة التثبيت']);
        }
        return response()->json(['message' => 'غير مصرح به'], 401);
    }

    public function getComments(Post $post)
    {
        return response()->json($post->comments()->with('user', 'replies.user')
            ->orderBy('created_at', 'desc')
            ->get());
    }

    public function addComment(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'comment_id' => 'nullable|exists:post_comments,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $post = PostComment::create([
            'post_id' => $post->id,
            'user_id' => auth()->guard('api')->user()->id,
            'comment_id' => $request->comment_id,
            'content' => $request->content
        ]);

        return response()->json($post);
    }

    public function deleteComment(PostComment $comment)
    {
        $user = auth()->guard('api')->user();
        if ($comment->user_id == $user->id) {
            $comment->delete();
            return response()->json(['message' => 'تم حذف التعليق بنجاح']);
        }
        return response()->json(['message' => 'غير مصرح به'], 401);
    }

    public function like(Post $post)
    {
        if ($post->likes()->where('user_id', auth()->guard('api')->user()->id)->exists()) {
            $post->likes()->where('user_id', auth()->guard('api')->user()->id)->delete();

        } else {
            $post->likes()->create([
                'user_id' => auth()->guard('api')->user()->id
            ]);
        }
        return response()->json($post);
    }
}

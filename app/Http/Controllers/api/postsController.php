<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Throwable;


class postsController extends Controller
{
    public function index()
    {
        // ١. جلب المستخدم الحالي ومعرّفات المحظورين
        $currentUser = auth()->guard('api')->user();

        // ٢. تحديد حجم الصفحة (مثلاً 10 منشورات)
        $pageSize = 10;

        // ٣. بناء الاستعلام
        $posts = Post::where('status', 'active')
            ->with('user', 'message')                              // تحميل العلاقات إذا لزم الأمر
            ->withCount(['likes', 'comments'])                     // إضافة likes_count و comments_count
            ->orderBy('created_at', 'desc')                        // الأحدث أولًا
            ->orderBy('likes_count', 'desc')                       // ثم حسب الإعجابات
            ->orderBy('comments_count', 'desc')                    // ثم حسب التعليقات
            ->paginate($pageSize);                                 // تقسيم الصفحات

        // ٤. إرجاع الاستجابة بصيغة JSON
        return response()->json($posts);
    }

    public function getPost(Post $post)
    {
        // تحميل العلاقات إذا لزم الأمر
        $post->load('user', 'message');
        return response()->json($post);
    }

    public function getFollowPosts()
    {
        $user = auth()->guard('api')->user();
        $followingIds = $user->followings()->pluck('following_id');
        $posts = Post::whereIn('user_id', $followingIds)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->withCount(['likes', 'comments'])
            ->with('user', 'message')                              // تحميل العلاقات إذا لزم الأمر
            ->paginate(10);
        return response()->json($posts);
    }

    public function getUserPosts($id)
    {
        $posts = Post::where('user_id', $id)->with('user')->get();
        return response()->json($posts);
    }
    public function create(Request $request)
    {
        // استخدام $request->user() هي الطريقة الأحدث والأفضل لجلب المستخدم في API
        $user = auth()->guard('api')->user();

        // --- ✨ التحسين الأساسي: التحقق من حد النشر اليومي ✨ ---
        $dailyPostLimit = 10;
        $postsTodayCount = $user->posts()
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->count();

        if ($postsTodayCount >= $dailyPostLimit) {
            return response()->json([
                'status' => false,
                'message' => 'لقد وصلت إلى الحد الأقصى للنشر اليومي (10 منشورات). لحذف منشور قديم وإضافة منشور جديد، يرجى استخدام التطبيق.',
            ], 429); // 429 Too Many Requests
        }

        // --- تحسين قواعد التحقق ---
        $validator = Validator::make($request->all(), [
            'content'  => 'required_without:images|nullable|string|max:5000', // المحتوى مطلوب إذا لم توجد صور
            'images'   => 'required_without:content|nullable|array|max:5', // الصور مطلوبة إذا لم يوجد محتوى، والحد الأقصى 5 صور
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // كل صورة يجب أن تكون من الأنواع المحددة
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'خطأ في التحقق من البيانات.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();

        // --- استخدام Transactions لضمان سلامة البيانات ---
        try {
            $post = DB::transaction(function () use ($request, $validatedData, $user) {

                $postData = ['content' => $validatedData['content'] ?? null];

                // 1. معالجة وتخزين الصور إن وجدت
                if ($request->hasFile('images')) {
                    $imagePaths = [];
                    foreach ($request->file('images') as $image) {
                        // استخدام store يضمن اسم ملف فريد وآمن
                        $path = $image->store('posts', 'public');
                        $imagePaths[] = $path;
                    }
                    // تخزين مسارات الصور كـ JSON في قاعدة البيانات
                    $postData['images'] = json_encode($imagePaths);
                }

                // 2. إنشاء المنشور وربطه بالمستخدم
                return $user->posts()->create($postData);
            });

            // تحميل العلاقة مع المستخدم لإرجاع بياناته مع المنشور
            $post->load('user');

            return response()->json([
                'status' => true,
                'message' => 'تم نشر المنشور بنجاح.',
                'data' => $post,
            ], 201);
        } catch (Throwable $e) {
            // في حالة حدوث أي خطأ، قم بتسجيله للمطورين
            Log::error('فشل إنشاء المنشور للمستخدم ID ' . $user->id . ': ' . $e->getMessage());

            // إرجاع رد خطأ عام للمستخدم
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ غير متوقع أثناء إنشاء المنشور.',
            ], 500);
        }
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

        NotificationService::notify(
            $post->post->user_id,
            auth()->guard('api')->user()->name . ' قام بتعليق على منشورك',
            $post->post
        );

        return response()->json($post->load('user', 'replies.user'));
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

        NotificationService::notify(
            $post->user_id,
            auth()->guard('api')->user()->name . ' قام بعمل اعجاب على منشورك',
            $post
        );

        return response()->json($post);
    }

    public function getLikes(Post $post)
    {
        return response()->json($post->likes()->with('user')->get());
    }
}

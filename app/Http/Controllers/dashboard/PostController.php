<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('content', 'like', "%$search%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
        }

        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        $posts = $query->paginate(10);

        // إحصائيات
        $totalPosts = Post::count(); // إجمالي المنشورات
        $postsWithoutMedia = Post::whereNull('images')->count(); // المنشورات بدون وسائط
        $postsMediaOnly = Post::whereNotNull('images')->whereNull('content')->count(); // المنشورات وسائط فقط
        $postsMediaAndContent = Post::whereNotNull('images')->whereNotNull('content')->count(); // المنشورات التي تحتوي على وسائط ومحتوى
        $pinnedPosts = Post::where('pinned', true)->count(); // المنشورات المثبتة
        $activePosts = Post::where('status', 'active')->count(); // المنشورات النشطة

        return view('dashboard.posts.index', compact(
            'posts',
            'totalPosts',
            'postsWithoutMedia',
            'postsMediaOnly',
            'postsMediaAndContent',
            'pinnedPosts',
            'activePosts'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'nullable|string',
            'status' => 'required|in:active,inactive,banned',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

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

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'تم إضافة المنشور بنجاح');
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'nullable|string',
            'status' => 'required|in:active,inactive,banned',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deleted_images' => 'sometimes|array',
        ]);

        $data = $request->except(['images', 'deleted_images']);
        $currentImages = $post->images ? json_decode($post->images) : [];

        // حذف الصور المحددة
        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $deletedImage) {
                Storage::delete('public/' . $deletedImage);
                $currentImages = array_filter($currentImages, fn($img) => $img !== $deletedImage);
            }
        }

        // إضافة الصور الجديدة
        if ($request->hasFile('images')) {
            $newImages = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/posts');
                $newImages[] = str_replace('public/', '', $path);
            }
            $currentImages = array_merge($currentImages, $newImages);
        }

        $data['images'] = json_encode($currentImages);

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'تم تحديث المنشور بنجاح');
    }

    public function destroy(Post $post)
    {
        // حذف الصورة إذا كانت موجودة
        if ($post->images && Storage::disk('public')->exists($post->images)) {
            Storage::disk('public')->delete($post->images);
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'تم حذف المنشور بنجاح');
    }

    public function reports(Request $request)
    {
        // بدء الاستعلام الأساسي
        $reports = Report::query();

        // تصفية البلاغات حسب الحالة (مخفية/غير مخفية)
        if ($request->has('hidden') && $request->get('hidden')) {
            $reports->where('is_hidden', true);
        } else {
            $reports->where('is_hidden', false);
        }

        // تصفية البلاغات حسب معرف المنشور
        if ($request->has('post_id')) {
            $reports->where('post_id', $request->get('post_id'));
        }

        // إضافة العلاقات اللازمة
        $reports = $reports->with('user','reportable')
            ->orderByDesc('created_at') // ترتيب حسب تاريخ الإنشاء
            ->paginate(10); // الترقيم

        // إحصائيات
        $totalReports = Report::count(); // إجمالي البلاغات
        $reportedPosts = 0;
        $topReasons = Report::select('reason', \DB::raw('count(*) as count'))
            ->groupBy('reason')
            ->orderByDesc('count')
            ->take(5)
            ->get(); // الأسباب الأكثر شيوعًا

        // عرض الصفحة
        return view('dashboard.posts.reports', compact('reports', 'totalReports', 'reportedPosts', 'topReasons'));
    }


    public function toggleVisibility(Report $report)
    {
        $report->update([
            'is_hidden' => !$report->is_hidden, // تبديل حالة الإخفاء
        ]);

        $message = $report->is_hidden ? 'تم إخفاء البلاغ بنجاح' : 'تم إظهار البلاغ بنجاح';
        return redirect()->route('reports.index')->with('success', $message);
    }
}

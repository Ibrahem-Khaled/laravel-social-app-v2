<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\ReportPost;
use Illuminate\Http\Request;

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
        $postsWithoutMedia = Post::whereNull('media')->count(); // المنشورات بدون وسائط
        $postsMediaOnly = Post::whereNotNull('media')->whereNull('content')->count(); // المنشورات وسائط فقط
        $postsMediaAndContent = Post::whereNotNull('media')->whereNotNull('content')->count(); // المنشورات التي تحتوي على وسائط ومحتوى
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
            'media' => 'nullable|string',
            'status' => 'required|in:active,inactive,banned',
        ]);

        Post::create($request->all());

        return redirect()->route('posts.index')->with('success', 'تم إضافة المنشور بنجاح');
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'nullable|string',
            'media' => 'nullable|string',
            'status' => 'required|in:active,inactive,banned',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')->with('success', 'تم تحديث المنشور بنجاح');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'تم حذف المنشور بنجاح');
    }

    public function reports(Request $request)
    {
        // بدء الاستعلام الأساسي
        $reports = ReportPost::query();

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
        $reports = $reports->with('post', 'user')->paginate(10);

        // إحصائيات
        $totalReports = ReportPost::count(); // إجمالي البلاغات
        $reportedPosts = ReportPost::distinct('post_id')->count('post_id'); // عدد المنشورات المبلغ عنها
        $topReasons = ReportPost::select('reason', \DB::raw('count(*) as count'))
            ->groupBy('reason')
            ->orderByDesc('count')
            ->take(5)
            ->get(); // الأسباب الأكثر شيوعًا

        // عرض الصفحة
        return view('dashboard.posts.reports', compact('reports', 'totalReports', 'reportedPosts', 'topReasons'));
    }


    public function toggleVisibility(ReportPost $report)
    {
        $report->update([
            'is_hidden' => !$report->is_hidden, // تبديل حالة الإخفاء
        ]);

        $message = $report->is_hidden ? 'تم إخفاء البلاغ بنجاح' : 'تم إظهار البلاغ بنجاح';
        return redirect()->route('reports.index')->with('success', $message);
    }
}

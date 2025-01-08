<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Models\Message;
use App\Models\Post;
use App\Models\ReportPost;
use App\Models\PostComment as Comment;
use App\Models\PostLike as Like;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $totalVerificationRequests = VerificationRequest::count();

        $totalPosts = Post::count();
        $totalComments = Comment::count();
        $totalMessages = Message::count();
        $totalReports = ReportPost::count();
        $totalGifts = Gift::count();

        $totalLikes = Like::count(); // إجمالي الإعجابات
        $totalShares = 0; // إجمالي المشاركات

        $topPosts = Post::withCount(['comments', 'likes'])
            ->orderByDesc('comments_count')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'totalVerificationRequests',
            'totalPosts',
            'totalComments',
            'totalMessages',
            'totalReports',
            'totalGifts',
            'totalLikes',
            'totalShares',
            'topPosts'
        ));
    }

}

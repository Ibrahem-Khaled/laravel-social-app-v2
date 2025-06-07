<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;

class homeController extends Controller
{

    // جلب الاقتراحات الأولية
    public function getSuggestions()
    {
        // المستخدمون المقترحون (يمكن تغيير الخوارزمية حسب احتياجاتك)
        $suggestedUsers = User::query()
            ->where('id', '!=', auth()->guard('api')->user()->id)
            ->withCount('followers')
            ->orderByDesc('followers_count')
            ->limit(5)
            ->get();


        // الهاشتاجات الشائعة
        $trendingHashtags = Hashtag::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get();

        // المنشورات الشائعة
        $trendingPosts = Post::query()
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->limit(5)
            ->get();

        return response()->json([
            'suggested_users' => $suggestedUsers,
            'trending_hashtags' => $trendingHashtags,
            'trending_posts' => $trendingPosts,
        ]);
    }

    // البحث الشامل
    public function search(Request $request)
    {
        $searchTerm = $request->query('search');

        if (empty($searchTerm)) {
            return response()->json([
                'users' => [],
                'hashtags' => [],
                'posts' => [],
            ]);
        }

        // البحث في المستخدمين
        $users = User::query()
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('username', 'LIKE', "%{$searchTerm}%");
            })
            ->where('id', '!=', auth()->guard('api')->user()->id)
            ->get();

        // البحث في الهاشتاجات
        $hashtags = Hashtag::query()
            ->where('name', 'LIKE', "%{$searchTerm}%")
            ->withCount('posts')
            ->get();

        // البحث في المنشورات
        $posts = Post::query()
            ->where('text', 'LIKE', "%{$searchTerm}%")
            ->withCount('likes')
            ->get();

        return response()->json([
            'users' => $users,
            'hashtags' => $hashtags,
            'posts' => $posts,
        ]);
    }

    public function getHigherPointsFromUsersFollowers(Request $request)
    {
        $user = auth()->guard('api')->user();

        // استرجاع بيانات المستخدمين المتابعين وترتيبهم حسب نقاطهم بشكل تنازلي
        $followers = $user->followers()
            ->orderBy('users.coins', 'desc')
            ->get();

        return response()->json($followers);
    }


    public function getHigherPointsFromUsers()
    {
        // جلب أفضل 10 مستخدمين ترتيباً حسب النقاط من قاعدة البيانات
        $users = User::orderBy('coins', 'desc')
            ->limit(20)
            ->get();

        return response()->json($users);
    }

    public function submitVerification(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'front_id_image' => 'required|image|max:2048',
            'back_id_image' => 'required|image|max:2048',
        ]);

        $frontImagePath = $request->file('front_id_image')->store('verifications');
        $backImagePath = $request->file('back_id_image')->store('verifications');

        VerificationRequest::create([
            'user_id' => auth()->guard('api')->user()->id,
            'full_name' => $request->full_name,
            'front_id_image' => $frontImagePath,
            'back_id_image' => $backImagePath,
        ]);

        return response()->json(['message' => 'تم تقديم طلب التوثيق بنجاح.'], 200);
    }
}

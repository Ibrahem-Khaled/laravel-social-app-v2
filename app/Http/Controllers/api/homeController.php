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

    private function getArabicSearchVariations(string $term): array
    {
        // إزالة التشكيل (الحركات) إن وجد
        $term = preg_replace('/[ًٌٍَُِّْ]/u', '', $term);

        // التعامل مع أشكال الألف
        $term_alef = str_replace(['أ', 'إ', 'آ'], 'ا', $term);
        // التعامل مع التاء المربوطة والهاء
        $term_taa = str_replace('ة', 'ه', $term_alef);
        // التعامل مع الألف المقصورة والياء
        $term_yaa = str_replace('ى', 'ي', $term_taa);

        // إرجاع مصفوفة فريدة من أشكال الكلمة المحتملة
        return array_unique([$term, $term_alef, $term_taa, $term_yaa]);
    }

    // جلب الاقتراحات الأولية
    public function getSuggestions()
    {
        $user = auth()->guard('api')->user();

        // المستخدمون المقترحون
        $suggestedUsers = User::query()
            // 1. استبعاد المستخدم الحالي نفسه من الاقتراحات
            ->where('id', '!=', $user->id)

            // 2. (التعديل الأهم) استبعاد المستخدمين الذين يتابعهم المستخدم الحالي بالفعل
            // هذا الاستعلام يعني: "أعطني المستخدمين الذين لا يملكون متابِعًا (follower) يكون هو المستخدم الحالي"
            ->whereDoesntHave('followers', function ($query) use ($user) {
                $query->where('follower_id', $user->id);
            })

            // 3. (التعديل الثاني) جلب 10 مستخدمين بشكل عشوائي
            // زدنا العدد قليلًا لضمان وجود تنوع أكبر في كل مرة
            ->inRandomOrder()
            ->limit(10)
            ->get(['id', 'name', 'avatar']); // نختار الحقول المطلوبة فقط لتحسين الأداء

        // الهاشتاجات الشائعة (لا تغيير هنا)
        $trendingHashtags = Hashtag::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get();

        // المنشورات الشائعة (لا تغيير هنا)
        $trendingPosts = Post::query()
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->limit(5)
            ->get();

        return response()->json([
            'suggested_users'   => $suggestedUsers,
            'trending_hashtags' => $trendingHashtags,
            'trending_posts'    => $trendingPosts,
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

        // الحصول على كل أشكال البحث الممكنة للكلمة العربية
        $searchVariations = $this->getArabicSearchVariations($searchTerm);

        // البحث في المستخدمين
        $users = User::query()
            ->where(function ($query) use ($searchVariations) {
                foreach ($searchVariations as $variation) {
                    $query->orWhere('name', 'LIKE', "%{$variation}%")
                        ->orWhere('username', 'LIKE', "%{$variation}%");
                }
            })
            ->where('id', '!=', auth()->guard('api')->user()->id)
            ->get();

        // البحث في الهاشتاجات
        $hashtags = Hashtag::query()
            ->where(function ($query) use ($searchVariations) {
                foreach ($searchVariations as $variation) {
                    $query->orWhere('name', 'LIKE', "%{$variation}%");
                }
            })
            ->withCount('posts')
            ->get();

        // البحث في المنشورات
        $posts = Post::query()
            ->where(function ($query) use ($searchVariations) {
                foreach ($searchVariations as $variation) {
                    $query->orWhere('content', 'LIKE', "%{$variation}%");
                }
            })
            ->withCount('likes', 'comments')
            ->with('user', 'hashtags', 'likes', 'comments')
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

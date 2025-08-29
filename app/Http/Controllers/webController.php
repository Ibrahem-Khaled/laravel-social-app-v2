<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\FeatureSection;
use App\Models\LiveStreaming;
use App\Models\Post;
use App\Models\SellCoins;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class webController extends Controller
{
    public function index()
    {
        $users = User::all();
        $latestLives = LiveStreaming::latest()->with('user')->take(8)->get();
        $coins = SellCoins::where('platform', 'web')->get();
        $faqs = FAQ::all();
        $featureSections = FeatureSection::with('items')->latest()->get();
        $settings = Setting::all()->keyBy('key');
        $latestPosts = Post::with('user')
            ->where('status', 'active')
            ->latest() // للترتيب حسب الأحدث
            ->take(3)  // لجلب 3 فقط
            ->get();


        return view('home', [
            'users' => $users,
            'latestLives' => $latestLives,
            'coins' => $coins,
            'faqs' => $faqs,
            'featureSections' => $featureSections,
            'latestPosts' => $latestPosts,
            'settings' => $settings,
            'heroImage' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            'testimonials' => [
                [
                    'name' => 'أحمد محمد',
                    'position' => 'مذيع بودكاست',
                    'avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
                    'quote' => 'التطبيق غير طريقة تواصلي مع جمهوري، جودة الصوت ممتازة والميزات رائعة.',
                    'rating' => 5
                ],
                // المزيد من التوصيات...
            ],
        ]);
    }

    public function subscribe(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:15',
        ]);

        $username = Str::slug($request->name) . '-' . Str::random(5);
        $user = User::where('username', $username)->first();

        while ($user) {
            $username = Str::slug($request->name) . '-' . Str::random(5);
            $user = User::where('username', $username)->first();
        }
        // Create the user
        $user = User::create([
            'username' => $username,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
        ]);

        return redirect()->back()->with('success', 'User added successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class webController extends Controller
{
    public function index()
    {
        return view('home', [
            'pageTitle' => 'تطبيق التواصل الصوتي والبث المباشر',
            'appName' => 'صوتي',
            'heroDescription' => 'منصة متكاملة للتواصل الصوتي والبث المباشر مع أصدقائك ومجتمعك. جودة صوت عالية، ميزات متقدمة، وتجربة مستخدم فريدة.',
            'heroImage' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            'userCount' => '10,000+',
            'reviewCount' => '1,200+',
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
            'features' => [
                [
                    'title' => 'جودة صوت عالية',
                    'description' => 'استمتع بجودة صوت عالية الدقة بدون تقطيع أو تشويش.',
                    'icon' => '<svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.728-2.728"/></svg>',
                    'icon_hover' => '<svg class="w-6 h-6 text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M8.245 4.365a1 1 0 00-1.438-.407 10.43 10.43 0 00-3.975 8.197 1 1 0 001.995.098 8.43 8.43 0 013.212-6.624 1 1 0 00.206-1.256zm3.344 1.36a1 1 0 00-1.359.36 8.43 8.43 0 00-1.718 5.055 1 1 0 001.994.058 6.43 6.43 0 011.313-3.875 1 1 0 00-.23-1.598zm5.002-1.911a1 1 0 00-1.04.23 6.43 6.43 0 01-2.052 1.56 1 1 0 00.814 1.827 8.43 8.43 0 002.7-2.05 1 1 0 00-.422-1.567z"/></svg>'
                ],
                // المزيد من الميزات...
            ],
            'steps' => [
                [
                    'step' => '1',
                    'title' => 'أنشئ حسابك',
                    'description' => 'سجل في التطبيق في أقل من دقيقة باستخدام بريدك الإلكتروني أو حسابك على وسائل التواصل.',
                    'image' => 'https://via.placeholder.com/300x200?text=Step+1'
                ],
                // المزيد من الخطوات...
            ],
            'demoFeatures' => [
                'جودة صوت عالية الدقة',
                'غرف صوتية متعددة',
                'بث مباشر للفعاليات',
                'تسجيل المحادثات',
                'واجهة سهلة الاستخدام'
            ],
            'demoVideo' => 'https://assets.mixkit.co/videos/preview/mixkit-man-talking-on-a-voice-chat-43285-large.mp4',
            'pricingPlans' => [
                [
                    'name' => 'الاساسي',
                    'description' => 'مثالي للأفراد والمجموعات الصغيرة',
                    'price' => 'ر.س 0',
                    'period' => 'شهر',
                    'featured' => false,
                    'features' => [
                        'غرف صوتية لمدة 4 ساعات',
                        'بحد أقصى 10 مشاركين',
                        'جودة صوت عادية',
                        '1 غرفة في الوقت الواحد'
                    ],
                    'cta_text' => 'ابدأ مجاناً',
                    'cta_link' => '#'
                ],
                // المزيد من الخطط...
            ],

              // بيانات وكيل الشحن
    'shipping_agent' => [
        'title' => 'كن وكيل شحن معنا',
        'description' => 'انضم إلى شبكة وكلاء الشحن لدينا وكن حلقة الوصل بين العملاء والبائعين.',
        'features' => [
            'عمولات تنافسية على كل شحنة',
            'منصة متكاملة لمتابعة الشحنات',
            'دعم فني متواصل'
        ],
        'image' => 'https://images.unsplash.com/photo-1607083206869-4c7672e72a8a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
    ],

    // بيانات آخر اللايفات
    'latestLives' => [
        [
            'id' => 1,
            'title' => 'عرض خاص على كنزات الشتاء',
            'description' => 'خصم يصل إلى 40% على تشكيلة كنزات الشتاء الجديدة.',
            'thumbnail' => 'https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            'user_name' => 'متجر الكنزات الفاخرة',
            'user_avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
            'category' => 'موضة',
            'viewers' => '1,245',
            'duration' => '2:45:12'
        ],
        // المزيد من اللايفات...
    ],

            'faqs' => [
                [
                    'question' => 'كيف يمكنني إنشاء غرفة صوتية؟',
                    'answer' => 'بعد تسجيل الدخول، اضغط على زر "إنشاء غرفة" في الصفحة الرئيسية، ثم حدد إعدادات الغرفة وانقر على "بدء الغرفة".'
                ],
                // المزيد من الأسئلة...
            ],
            'contactEmail' => 'info@example.com',
            'contactPhone' => '+966 12 345 6789',
            'contactAddress' => 'الرياض، المملكة العربية السعودية'
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

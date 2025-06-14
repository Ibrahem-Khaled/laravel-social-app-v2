<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .wave {
            animation: wave 8s linear infinite;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23333' fill-opacity='1' d='M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            background-repeat: no-repeat;
        }

        @keyframes wave {
            0% {
                background-position-x: 0;
            }

            100% {
                background-position-x: 1440px;
            }
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'tajawal': ['Tajawal', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            500: '#6366f1',
                            600: '#4f46e5',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="font-tajawal bg-gray-900 text-white overflow-x-hidden" x-data="app()">
    <!-- Header -->
    <header class="absolute w-full z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center animate-pulse">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                    <span class="mr-3 text-xl font-bold">{{ env('APP_NAME') }}</span>
                </div>
                <div class="hidden md:flex space-x-6 space-x-reverse">
                    <a href="#features" class="text-gray-300 hover:text-white transition">المميزات</a>
                    <a href="#how-it-works" class="text-gray-300 hover:text-white transition">كيف يعمل</a>
                    <a href="#pricing" class="text-gray-300 hover:text-white transition">الأسعار</a>
                    <a href="#contact" class="text-gray-300 hover:text-white transition">اتصل بنا</a>
                </div>
                <div>
                    <a href="{{ route('register') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-full font-medium transition transform hover:scale-105">
                        ابدأ الآن
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 md:pt-40 md:pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="animate__animated animate__fadeInRight animate__delay-1s">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        تواصل <span class="text-indigo-400">صوتي</span> بجودة عالية <span
                            class="text-indigo-400">وبث</span> مباشر
                    </h1>
                    <p class="mt-6 text-lg text-gray-300 max-w-lg">
                        {{ $heroDescription ?? 'منصة متكاملة للتواصل الصوتي والبث المباشر مع أصدقائك ومجتمعك. جودة صوت عالية، ميزات متقدمة، وتجربة مستخدم فريدة.' }}
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('register') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-full font-medium transition transform hover:scale-105 shadow-lg">
                            سجل مجاناً
                        </a>
                        <a href="#demo"
                            class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-3 rounded-full font-medium transition transform hover:scale-105 shadow-lg">
                            شاهد عرض توضيحي
                        </a>
                    </div>
                    <div class="mt-10 flex items-center space-x-4 space-x-reverse">
                        <div class="flex -space-x-2">
                            @foreach ($testimonials as $index => $testimonial)
                                @if ($index < 4)
                                    <img class="inline-block h-10 w-10 rounded-full ring-2 ring-gray-800"
                                        src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}">
                                @endif
                            @endforeach
                        </div>
                        <div>
                            <p class="text-gray-300 text-sm">
                                انضم إلى <span class="text-indigo-400 font-bold">{{ $userCount ?? '10,000+' }}</span>
                                مستخدم نشط
                            </p>
                            <div class="flex items-center mt-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor
                                <span class="text-gray-400 text-sm mr-1">4.9 ({{ $reviewCount ?? '1,200+' }}
                                    تقييم)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative animate__animated animate__fadeInLeft">
                    <div class="relative floating">
                        <img src="{{ $heroImage ?? 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}"
                            alt="Voice Communication" class="rounded-2xl shadow-2xl border-4 border-indigo-500/10">
                    </div>
                    <div
                        class="absolute -bottom-8 -left-8 w-32 h-32 bg-indigo-500/20 rounded-full filter blur-xl animate-pulse">
                    </div>
                    <div
                        class="absolute -top-8 -right-8 w-40 h-40 bg-purple-500/20 rounded-full filter blur-xl animate-pulse">
                    </div>
                </div>
            </div>
        </div>
        <div class="wave absolute bottom-0 left-0 w-full h-32 z-0"></div>
    </section>

    <!-- Shipping Agent Section -->
    <section class="py-16 bg-indigo-900/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="animate__animated animate__fadeInLeft">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">كن <span class="text-indigo-400">وكيل شحن</span>
                        معنا</h2>
                    <p class="text-gray-300 mb-6">
                        انضم إلى شبكة وكلاء الشحن لدينا وكن حلقة الوصل بين العملاء والبائعين. نوفر لك الأدوات والموارد
                        اللازمة لإدارة عمليات الشحن بسهولة.
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-indigo-500 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">عمولات تنافسية على كل شحنة</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-indigo-500 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">منصة متكاملة لمتابعة الشحنات</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-indigo-500 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">دعم فني متواصل</span>
                        </li>
                    </ul>
                    <a href="{{ route('shippingAgent') }}"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-full font-medium transition transform hover:scale-105">
                        سجل كوكيل شحن
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div class="relative animate__animated animate__fadeInRight">
                    <img src="https://images.unsplash.com/photo-1607083206869-4c7672e72a8a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                        alt="Shipping Agent" class="rounded-2xl shadow-2xl border-4 border-indigo-500/10">
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-indigo-500/20 rounded-full filter blur-xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold">مميزات <span class="text-indigo-400">فريدة</span> تجعلنا
                    متميزين</h2>
                <p class="mt-4 max-w-2xl mx-auto text-gray-400">
                    {{ $featuresDescription ?? 'نقدم مجموعة من المميزات المتقدمة التي تجعل تجربة التواصل الصوتي والبث المباشر أكثر سلاسة ومتعة.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($features as $feature)
                    <div class="bg-gray-800/50 hover:bg-gray-800 rounded-xl p-6 transition-all duration-300 transform hover:-translate-y-2 border border-gray-700/50 hover:border-indigo-500/30"
                        x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                        <div class="w-14 h-14 rounded-lg bg-indigo-500/10 flex items-center justify-center mb-4">
                            <div x-show="hover" class="animate__animated animate__fadeIn">
                                {!! $feature['icon_hover'] !!}
                            </div>
                            <div x-show="!hover" class="animate__animated animate__fadeIn">
                                {!! $feature['icon'] !!}
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-400">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-gray-800/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold">كيفية <span class="text-indigo-400">استخدام</span> التطبيق
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-gray-400">
                    ابدأ في ثلاث خطوات بسيطة فقط واستمتع بتجربة التواصل الصوتي والبث المباشر.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @foreach ($steps as $step)
                    <div class="relative group">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-200">
                        </div>
                        <div class="relative bg-gray-800 rounded-lg p-6 h-full">
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold mr-3">
                                    {{ $step['step'] }}</div>
                                <h3 class="text-xl font-bold">{{ $step['title'] }}</h3>
                            </div>
                            <p class="text-gray-400">{{ $step['description'] }}</p>
                            @if ($step['image'])
                                <div class="mt-6 rounded-lg overflow-hidden">
                                    <img src="{{ $step['image'] }}" alt="{{ $step['title'] }}"
                                        class="w-full h-auto rounded-lg border border-gray-700">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">جرب <span class="text-indigo-400">التطبيق</span>
                        الآن</h2>
                    <p class="text-gray-400 mb-8">
                        شاهد عرضًا توضيحيًا سريعًا لتجربة واجهة التطبيق وميزاته قبل الاشتراك.
                    </p>
                    <ul class="space-y-4">
                        @foreach ($demoFeatures as $feature)
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-indigo-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-8">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-full font-medium transition transform hover:scale-105">
                            ابدأ تجربتك المجانية
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative rounded-xl overflow-hidden shadow-2xl border-4 border-gray-800">
                        <div class="bg-gray-800 h-8 flex items-center px-3">
                            <div class="flex space-x-2 space-x-reverse">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                        </div>
                        <video class="w-full" autoplay loop muted playsinline>
                            <source
                                src="{{ $demoVideo ?? 'https://assets.mixkit.co/videos/preview/mixkit-man-talking-on-a-voice-chat-43285-large.mp4' }}"
                                type="video/mp4">
                        </video>
                    </div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-indigo-500/20 rounded-full filter blur-xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Lives Section -->
    <section class="py-20 bg-gray-800/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold">آخر <span class="text-indigo-400">البثوث المباشرة</span>
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-gray-400">
                    تابع آخر البثوث المباشرة من بائعي الكنزات والمتاجر الموثوقة.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($latestLives as $live)
                    <div
                        class="bg-gray-800/50 rounded-xl overflow-hidden border border-gray-700/50 hover:border-indigo-500/30 transition transform hover:-translate-y-2">
                        <div class="relative">
                            <img src="{{ $live['thumbnail'] }}" alt="{{ $live['title'] }}"
                                class="w-full h-48 object-cover">
                            <div
                                class="absolute top-2 left-2 bg-red-600 text-white px-2 py-1 rounded-md text-xs font-bold">
                                LIVE
                            </div>
                            <div class="absolute bottom-2 left-2 bg-black/70 text-white px-2 py-1 rounded-md text-xs">
                                {{ $live['viewers'] }} مشاهد
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <img class="w-10 h-10 rounded-full mr-3" src="{{ $live['user_avatar'] }}"
                                    alt="{{ $live['user_name'] }}">
                                <div>
                                    <h4 class="font-bold">{{ $live['user_name'] }}</h4>
                                    <p class="text-gray-400 text-sm">{{ $live['category'] }}</p>
                                </div>
                            </div>
                            <h3 class="text-lg font-bold mb-2">{{ $live['title'] }}</h3>
                            <p class="text-gray-400 text-sm mb-4">{{ Str::limit($live['description'], 100) }}</p>
                            <a href="#"
                                class="inline-flex items-center text-indigo-500 hover:text-indigo-400 transition">
                                انضم الآن
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="#"
                    class="inline-flex items-center px-6 py-3 border border-indigo-500 text-indigo-500 hover:bg-indigo-500 hover:text-white rounded-full font-medium transition">
                    عرض جميع البثوث المباشرة
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    @if (isset($testimonials) && count($testimonials) > 0)
        <section class="py-20 bg-gray-800/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold">آراء <span class="text-indigo-400">عملائنا</span></h2>
                    <p class="mt-4 max-w-2xl mx-auto text-gray-400">
                        ما يقوله مستخدمونا عن تجربتهم مع التطبيق.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($testimonials as $testimonial)
                        <div
                            class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-indigo-500/30 transition">
                            <div class="flex items-center mb-4">
                                <img class="w-12 h-12 rounded-full mr-4" src="{{ $testimonial['avatar'] }}"
                                    alt="{{ $testimonial['name'] }}">
                                <div>
                                    <h4 class="font-bold">{{ $testimonial['name'] }}</h4>
                                    <p class="text-gray-400 text-sm">{{ $testimonial['position'] }}</p>
                                </div>
                            </div>
                            <p class="text-gray-300 mb-4">"{{ $testimonial['quote'] }}"</p>
                            <div class="flex items-center">
                                @for ($i = 0; $i < $testimonial['rating']; $i++)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Pricing Section -->
    <section id="coins-pricing" class="py-20 bg-gradient-to-b from-gray-900 to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-white">
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-yellow-600">كنز</span>
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500">الكوينزات</span>
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-gray-300 text-lg">
                    اشتر كوينزات واحصل على مزايا حصرية في عالمنا الرقمي
                </p>
                <div class="mt-6 flex justify-center">
                    <div class="animate-bounce bg-yellow-500/20 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- الحزمة الأساسية -->
                <div class="relative group transform hover:-translate-y-2 transition duration-500">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl blur opacity-25 group-hover:opacity-50 transition duration-500">
                    </div>
                    <div
                        class="relative bg-gray-800 rounded-xl p-8 h-full border border-gray-700/50 hover:border-yellow-400/50 transition-all duration-300">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-white">الحزمة الأساسية</h3>
                                <p class="text-gray-400">ابدأ رحلتك مع الكوينزات</p>
                            </div>
                            <div class="bg-yellow-500/10 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mb-8">
                            <span class="text-5xl font-bold text-white">50</span>
                            <span class="text-2xl text-yellow-400">كوينز</span>
                            <div class="mt-2 text-gray-400">مقابل</div>
                            <div class="text-2xl font-bold text-white">25 ر.س</div>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-yellow-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">50 كوينز للبدء</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-yellow-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">مكافأة ترحيبية 5 كوينز</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-yellow-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">دعم فني 24/7</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="block w-full text-center px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white rounded-xl font-bold transition shadow-lg hover:shadow-blue-500/20">
                            اشتر الآن
                        </a>
                    </div>
                </div>

                <!-- الحزمة المميزة -->
                <div class="relative group transform hover:-translate-y-2 transition duration-500"
                    :class="{ 'md:-mt-4': true }">
                    <div
                        class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                        الأفضل قيمة
                    </div>
                    <div
                        class="relative bg-gray-800 rounded-xl p-8 h-full border-2 border-yellow-500/50 transition-all duration-300 shadow-lg shadow-yellow-500/10">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-white">الحزمة الذهبية</h3>
                                <p class="text-gray-400">أفضل عائد استثماري</p>
                            </div>
                            <div class="bg-yellow-500/20 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 1 1 0 001.415 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="mb-8">
                            <span class="text-5xl font-bold text-white">200</span>
                            <span class="text-2xl text-yellow-400">كوينز</span>
                            <div class="mt-2 text-gray-400">مقابل</div>
                            <div class="text-2xl font-bold text-white">80 ر.س</div>
                            <div class="mt-2 text-green-400 font-medium">وفر 20%</div>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-yellow-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">200 كوينز + 50 كوينز هدية</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-yellow-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">خصم 20% على المشتريات القادمة</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-yellow-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">دعم فني متميز</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-yellow-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">وصول مبكر للميزات الجديدة</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="block w-full text-center px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white rounded-xl font-bold transition shadow-lg hover:shadow-yellow-500/30">
                            اشتر الآن
                        </a>
                    </div>
                </div>

                <!-- الحزمة الاحترافية -->
                <div class="relative group transform hover:-translate-y-2 transition duration-500">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl blur opacity-25 group-hover:opacity-50 transition duration-500">
                    </div>
                    <div
                        class="relative bg-gray-800 rounded-xl p-8 h-full border border-gray-700/50 hover:border-purple-400/50 transition-all duration-300">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-white">الحزمة الاحترافية</h3>
                                <p class="text-gray-400">للمحترفين والهواة</p>
                            </div>
                            <div class="bg-purple-500/10 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="mb-8">
                            <span class="text-5xl font-bold text-white">500</span>
                            <span class="text-2xl text-purple-400">كوينز</span>
                            <div class="mt-2 text-gray-400">مقابل</div>
                            <div class="text-2xl font-bold text-white">175 ر.س</div>
                            <div class="mt-2 text-green-400 font-medium">وفر 30%</div>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-purple-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">500 كوينز + 150 كوينز هدية</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-purple-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">خصم 30% على المشتريات القادمة</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-purple-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">مدير حسابات شخصي</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-purple-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">مزايا حصرية للمحترفين</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-purple-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-300">دعم فني فوري</span>
                            </li>
                        </ul>
                        <a href="#"
                            class="block w-full text-center px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white rounded-xl font-bold transition shadow-lg hover:shadow-purple-500/20">
                            اشتر الآن
                        </a>
                    </div>
                </div>
            </div>

            <!-- خصومات الشركات -->
            <div class="mt-20 max-w-4xl mx-auto bg-gray-800/50 border border-gray-700 rounded-xl p-8 backdrop-blur-sm">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/3 mb-6 md:mb-0 flex justify-center">
                        <div class="bg-yellow-500/10 p-4 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-400"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="md:w-2/3 md:pl-8 text-center md:text-left">
                        <h3 class="text-2xl font-bold text-white mb-3">خصومات خاصة للشركات</h3>
                        <p class="text-gray-300 mb-4">هل تمثل شركة أو مجموعة؟ احصل على خصومات تصل إلى 50% عند شراء
                            كميات كبيرة من الكوينزات لفريقك أو عملائك.</p>
                        <a href="#"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-600 hover:to-gray-700 transition">
                            اتصل بنا
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-800/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold">الأسئلة <span class="text-indigo-400">الشائعة</span></h2>
                <p class="mt-4 max-w-2xl mx-auto text-gray-400">
                    أجوبة على أكثر الأسئلة شيوعًا حول التطبيق وخدماته.
                </p>
            </div>

            <div class="space-y-4">
                @foreach ($faqs as $faq)
                    <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }" class="border border-gray-700/50 rounded-lg overflow-hidden">
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center p-6 bg-gray-800/50 hover:bg-gray-800 transition">
                            <h3 class="text-lg font-medium text-right">{{ $faq['question'] }}</h3>
                            <svg class="w-6 h-6 text-indigo-500 transition-transform duration-200"
                                :class="{ 'transform rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="p-6 pt-0 text-gray-300">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('components.website.footer')
    <script>
        function app() {
            return {
                activeTab: 'all',
                scrollToTop() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }
        }

        // Scroll reveal animation
        document.addEventListener('DOMContentLoaded', function() {
            const sr = ScrollReveal({
                origin: 'bottom',
                distance: '60px',
                duration: 1000,
                delay: 200,
                reset: true
            });

            sr.reveal('.animate__animated', {
                interval: 200
            });

            // Add intersection observer for floating animation
            const floatingElements = document.querySelectorAll('.floating');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    } else {
                        entry.target.style.animationPlayState = 'paused';
                    }
                });
            }, {
                threshold: 0.1
            });

            floatingElements.forEach(el => observer.observe(el));
        });
    </script>
    <script src="https://unpkg.com/scrollreveal"></script>
</body>

</html>

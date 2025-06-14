<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        @keyframes gradient {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-30px) rotate(1deg);
            }

            66% {
                transform: translateY(-10px) rotate(-1deg);
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        @keyframes blob {

            0%,
            100% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        @keyframes glow {

            0%,
            100% {
                box-shadow: 0 0 5px #6366f1, 0 0 10px #6366f1, 0 0 15px #6366f1;
            }

            50% {
                box-shadow: 0 0 10px #8b5cf6, 0 0 20px #8b5cf6, 0 0 30px #8b5cf6;
            }
        }

        .gradient-bg {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #312e81, #1e1b4b);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .pulse-ring {
            animation: pulse-ring 2s infinite;
        }

        .blob {
            animation: blob 7s infinite;
        }

        .glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
        }

        .parallax {
            transform: translateZ(0);
            will-change: transform;
        }

        .neon-border {
            border: 2px solid transparent;
            background: linear-gradient(45deg, #6366f1, #8b5cf6) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
        }

        .card-3d {
            transform-style: preserve-3d;
            transition: transform 0.6s;
        }

        .card-3d:hover {
            transform: rotateY(5deg) rotateX(5deg);
        }

        .shimmer {
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.2) 50%, transparent 70%);
            background-size: 200% 200%;
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% -200%;
            }

            100% {
                background-position: 200% 200%;
            }
        }

        .magnetic {
            transition: transform 0.2s ease;
        }

        .split-text {
            overflow: hidden;
        }

        .split-text span {
            display: inline-block;
            opacity: 0;
            transform: translateY(100px);
            animation: slideUp 0.8s forwards;
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
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
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        },
                        dark: {
                            50: '#f8fafc',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    animation: {
                        'gradient': 'gradient 15s ease infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-ring': 'pulse-ring 2s infinite',
                        'blob': 'blob 7s infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'shimmer': 'shimmer 3s infinite',
                    }
                }
            }
        }
    </script>
</head>

<body class="font-tajawal bg-dark-900 text-white overflow-x-hidden gradient-bg" x-data="app()">
    <!-- Floating Particles Background -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-primary-500/10 rounded-full blob filter blur-3xl"></div>
        <div class="absolute top-3/4 right-1/4 w-80 h-80 bg-purple-500/10 rounded-full blob filter blur-3xl"
            style="animation-delay: -2s;"></div>
        <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-indigo-500/5 rounded-full blob filter blur-3xl"
            style="animation-delay: -4s;"></div>
    </div>

    <!-- Header -->
    <header class="fixed w-full z-50 glass">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center group">
                    <div class="relative">
                        <div class="absolute inset-0 w-12 h-12 rounded-full bg-primary-500 pulse-ring opacity-20"></div>
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center glow">
                            <img src="{{ $websiteData?->avatar_url }}" alt="{{ $websiteData->name }}"
                                class="w-8 h-8 rounded-full">
                        </div>
                    </div>
                    <span
                        class="mr-4 text-xl font-bold bg-gradient-to-r from-white to-primary-200 bg-clip-text text-transparent">
                        {{ $websiteData->name }}
                    </span>
                </div>

                <div class="hidden md:flex space-x-8 space-x-reverse">
                    <a href="#features"
                        class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 relative group">
                        المميزات
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#how-it-works"
                        class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 relative group">
                        كيف يعمل
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#pricing"
                        class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 relative group">
                        الأسعار
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#contact"
                        class="text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 relative group">
                        اتصل بنا
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>

                <div>
                    <a href="{{ route('register') }}"
                        class="relative px-8 py-3 rounded-full font-medium overflow-hidden group bg-gradient-to-r from-primary-600 to-purple-600 hover:from-primary-700 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg hover:shadow-2xl">
                        <span class="relative z-10">ابدأ الآن</span>
                        <div class="absolute inset-0 shimmer opacity-0 group-hover:opacity-100"></div>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 md:pt-40 md:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div class="split-text">
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-black leading-tight text-shadow">
                            <span style="animation-delay: 0.1s;">تواصل</span>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400"
                                style="animation-delay: 0.2s;">صوتي</span>
                            <br>
                            <span style="animation-delay: 0.3s;">بجودة</span>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400"
                                style="animation-delay: 0.4s;">عالية</span>
                            <br>
                            <span style="animation-delay: 0.5s;">و</span>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-indigo-400"
                                style="animation-delay: 0.6s;">بث</span>
                            <span style="animation-delay: 0.7s;">مباشر</span>
                        </h1>
                    </div>

                    <p class="text-xl text-gray-300 max-w-2xl leading-relaxed"
                        style="animation: slideUp 0.8s 0.8s both;">
                        {{ $websiteData->bio }}
                    </p>

                    <div class="flex flex-wrap gap-6" style="animation: slideUp 0.8s 1s both;">
                        <a href="{{ route('register') }}"
                            class="group relative px-10 py-4 rounded-full font-bold text-lg overflow-hidden bg-gradient-to-r from-primary-600 via-purple-600 to-indigo-600 hover:from-primary-700 hover:via-purple-700 hover:to-indigo-700 transition-all transform hover:scale-105 shadow-2xl hover:shadow-primary-500/25">
                            <span class="relative z-10">سجل مجاناً</span>
                            <div class="absolute inset-0 shimmer opacity-0 group-hover:opacity-100"></div>
                        </a>
                        <a href="#demo"
                            class="group glass px-10 py-4 rounded-full font-bold text-lg hover:bg-white/10 transition-all transform hover:scale-105 shadow-xl">
                            شاهد عرض توضيحي
                        </a>
                    </div>

                    <div class="flex items-center space-x-6 space-x-reverse" style="animation: slideUp 0.8s 1.2s both;">
                        <div class="flex -space-x-3">
                            @foreach ($testimonials as $index => $testimonial)
                                @if ($index < 4)
                                    <img class="inline-block h-12 w-12 rounded-full ring-4 ring-dark-900 hover:scale-110 transition-transform hover-lift"
                                        src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}">
                                @endif
                            @endforeach
                        </div>
                        <div>
                            <p class="text-gray-300">
                                انضم إلى <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400 font-bold text-xl">{{ $users->count() }}</span>
                                مستخدم نشط
                            </p>
                            <div class="flex items-center mt-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor
                                <span class="text-gray-400 mr-2">4.9 ({{ $reviewCount ?? '18+' }} تقييم)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative" style="animation: slideUp 0.8s 0.6s both;">
                    <div class="relative floating">
                        <div class="relative neon-border rounded-3xl overflow-hidden shadow-2xl">
                            <img src="{{ $heroImage ?? 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}"
                                alt="Voice Communication" class="w-full h-auto">
                            <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/20 to-transparent"></div>
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -top-16 -right-16 w-32 h-32 bg-primary-500/30 rounded-full filter blur-2xl floating"
                        style="animation-delay: -1s;"></div>
                    <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-purple-500/30 rounded-full filter blur-2xl floating"
                        style="animation-delay: -3s;"></div>
                    <div class="absolute top-1/2 -right-8 w-24 h-24 bg-indigo-500/40 rounded-full filter blur-xl floating"
                        style="animation-delay: -2s;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shipping Agent Section -->
    <section class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <div class="glass rounded-3xl p-8 card-3d hover-lift">
                        <h2 class="text-4xl md:text-5xl font-bold mb-6">
                            كن <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">وكيل
                                شحن</span> معنا
                        </h2>
                        <p class="text-gray-300 text-lg mb-8 leading-relaxed">
                            انضم إلى شبكة وكلاء الشحن لدينا وكن حلقة الوصل بين العملاء والبائعين. نوفر لك الأدوات
                            والموارد اللازمة لإدارة عمليات الشحن بسهولة.
                        </p>

                        <ul class="space-y-4 mb-10">
                            <li class="flex items-start group">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-lg">عمولات تنافسية على كل شحنة</span>
                            </li>
                            <li class="flex items-start group">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-lg">منصة متكاملة لمتابعة الشحنات</span>
                            </li>
                            <li class="flex items-start group">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-lg">دعم فني متواصل</span>
                            </li>
                        </ul>

                        <a href="{{ route('shippingAgent') }}"
                            class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-600 to-purple-600 hover:from-primary-700 hover:to-purple-700 rounded-full font-bold text-lg transition-all transform hover:scale-105 shadow-xl overflow-hidden">
                            <span class="relative z-10">سجل كوكيل شحن</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 mr-3 group-hover:translate-x-1 transition-transform"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="absolute inset-0 shimmer opacity-0 group-hover:opacity-100"></div>
                        </a>
                    </div>
                </div>

                <div class="order-1 lg:order-2 relative">
                    <div class="relative floating">
                        <div class="neon-border rounded-3xl overflow-hidden shadow-2xl">
                            <img src="https://images.unsplash.com/photo-1607083206869-4c7672e72a8a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                                alt="Shipping Agent" class="w-full h-auto">
                            <div class="absolute inset-0 bg-gradient-to-tl from-primary-500/20 to-transparent"></div>
                        </div>
                    </div>
                    <div
                        class="absolute -bottom-8 -right-8 w-32 h-32 bg-primary-500/30 rounded-full filter blur-2xl floating">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="glass rounded-3xl p-10 card-3d">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">
                        جرب <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">التطبيق</span>
                        الآن
                    </h2>
                    <p class="text-gray-300 text-lg mb-10 leading-relaxed">
                        شاهد عرضًا توضيحيًا سريعًا لتجربة واجهة التطبيق وميزاته قبل الاشتراك.
                    </p>

                    <ul class="space-y-6 mb-10">
                        @foreach ($demoFeatures as $feature)
                            <li class="flex items-start group">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center ml-4 group-hover:scale-110 transition-transform">
                                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-lg">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('register') }}"
                        class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-600 to-purple-600 hover:from-primary-700 hover:to-purple-700 rounded-full font-bold text-lg transition-all transform hover:scale-105 shadow-xl overflow-hidden">
                        <span class="relative z-10">ابدأ تجربتك المجانية</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 mr-3 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="absolute inset-0 shimmer opacity-0 group-hover:opacity-100"></div>
                    </a>
                </div>

                <div class="relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl neon-border">
                        <div class="glass h-12 flex items-center px-6">
                            <div class="flex space-x-3 space-x-reverse">
                                <div class="w-4 h-4 rounded-full bg-red-500 glow"></div>
                                <div class="w-4 h-4 rounded-full bg-yellow-500 glow"></div>
                                <div class="w-4 h-4 rounded-full bg-green-500 glow"></div>
                            </div>
                        </div>
                        <img src="{{ asset('assets/img/demo.png') }}" alt="Demo Image" class="w-full">
                    </div>
                    <div
                        class="absolute -bottom-8 -left-8 w-32 h-32 bg-purple-500/30 rounded-full filter blur-2xl floating">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Lives Section -->
    <section class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    آخر <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">البثوث
                        المباشرة</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    تابع آخر البثوث المباشرة.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($latestLives as $live)
                    <div class="glass rounded-2xl overflow-hidden hover-lift card-3d group cursor-pointer">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $live->thumbnail) }}" alt="{{ $live->title }}"
                                class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div
                                class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold glow">
                                مباشر
                            </div>
                            <div class="absolute bottom-4 left-4 glass px-3 py-1 rounded-full text-sm font-medium">
                                {{ $live->likes ?? 0 }} اعجاب
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <img class="w-12 h-12 rounded-full ml-4 ring-2 ring-primary-500/50"
                                    src="{{ $live->user->avatar_url }}" alt="{{ $live->user->name }}">
                                <div>
                                    <h4 class="font-bold text-lg">{{ $live->user->name }}</h4>
                                    <p class="text-primary-400 text-sm">{{ $live->description }}</p>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-3 group-hover:text-primary-400 transition-colors">
                                {{ $live->title }}</h3>
                            <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                                {{ Str::limit($live->description, 100) }}</p>
                            <a href="#"
                                class="inline-flex items-center text-primary-500 hover:text-primary-400 transition-all group-hover:translate-x-1 font-medium">
                                انضم الآن
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
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

            <div class="mt-16 text-center">
                <a href="#"
                    class="group inline-flex items-center px-8 py-4 glass rounded-full font-bold text-lg hover:bg-white/10 transition-all transform hover:scale-105 shadow-xl">
                    عرض جميع البثوث المباشرة
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 mr-3 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <section id="coins-pricing" class="py-16 bg-gradient-to-b from-gray-900 to-gray-800 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-20 left-10 w-32 h-32 bg-primary-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-40 h-40 bg-purple-500 rounded-full filter blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">
                        العملات الرقمية المتاحة
                    </span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    اختر العملة التي تريد شراءها واستفد من أفضل العروض الحصرية
                </p>
            </div>

            <!-- Coins grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($coins as $item)
                    <div class="relative group">
                        <!-- Coin card -->
                        <div
                            class="h-full bg-gray-800 bg-opacity-50 backdrop-blur-sm rounded-2xl overflow-hidden border border-gray-700 transition-all duration-300 group-hover:border-primary-500 group-hover:shadow-lg group-hover:shadow-primary-500/20">
                            <!-- Coin image with glow effect -->
                            <div class="p-8 text-center relative">
                                <div class="relative inline-block mb-6">
                                    <div
                                        class="absolute inset-0 w-24 h-24 bg-primary-500 rounded-full pulse-ring opacity-20">
                                    </div>
                                    <img src="{{ asset('storage/' . $item->icon) }}" alt="{{ $item->price }}"
                                        class="w-24 h-24 mx-auto glow rounded-full object-cover border-4 border-gray-700 group-hover:border-primary-500 transition-all duration-300">
                                </div>

                                <!-- Coin name -->
                                <h3 class="text-2xl font-bold text-white mb-2">{{ $item->price }} ر.س</h3>
                            </div>

                            <!-- Pricing and details -->
                            <div class="bg-gray-900 bg-opacity-50 p-6 border-t border-gray-700">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-gray-400">COINS:</span>
                                    <span class="text-xl font-bold text-white">
                                        {{ $item->amount }}
                                    </span>
                                </div>
                                <!-- Buy button -->
                                <button
                                    class="w-full bg-gradient-to-r from-primary-500 to-purple-600 hover:from-primary-600 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-primary-500/30 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    شراء {{ $item->symbol }}
                                </button>
                            </div>
                        </div>

                        <!-- Hover effect border -->
                        <div
                            class="absolute inset-0 border-2 border-transparent group-hover:border-primary-500 rounded-2xl pointer-events-none opacity-0 group-hover:opacity-100 transition-all duration-300">
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View all button -->
            <div class="text-center mt-12">
                <button
                    class="inline-flex items-center px-6 py-3 border border-gray-700 rounded-full text-lg font-medium text-white bg-gray-800 hover:bg-gray-700 hover:border-primary-500 transition-all duration-300">
                    عرض جميع العملات
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 transform rotate-180"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </section>


    <!-- FAQ Section -->
    <section class="py-24 relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    الأسئلة <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">الشائعة</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    أجوبة على أكثر الأسئلة شيوعًا حول التطبيق وخدماته.
                </p>
            </div>

            <div class="space-y-6">
                @foreach ($faqs as $faq)
                    <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }" class="glass rounded-2xl overflow-hidden hover-lift">
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center p-8 hover:bg-white/5 transition-all group">
                            <h3 class="text-xl font-bold text-right group-hover:text-primary-400 transition-colors">
                                {{ $faq['question'] }}</h3>
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white transition-transform duration-300"
                                    :class="{ 'transform rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div x-show="open" x-collapse class="px-8 pb-8">
                            <div class="text-gray-300 text-lg leading-relaxed border-t border-gray-700/30 pt-6">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('components.website.footer')

    <!-- Back to Top Button -->
    <button @click="scrollToTop()"
        class="fixed bottom-8 left-8 w-14 h-14 bg-gradient-to-br from-primary-600 to-purple-600 rounded-full flex items-center justify-center shadow-2xl hover:shadow-primary-500/25 transition-all transform hover:scale-110 z-50 glow group">
        <svg class="w-6 h-6 text-white group-hover:-translate-y-1 transition-transform" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

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

        // Enhanced animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Split text animation
            const splitTexts = document.querySelectorAll('.split-text span, [style*="animation-delay"]');
            splitTexts.forEach((span, index) => {
                span.style.animationDelay = `${index * 0.1}s`;
            });

            // Magnetic effect for buttons
            const magneticElements = document.querySelectorAll('.magnetic, .hover-lift');
            magneticElements.forEach(element => {
                element.addEventListener('mousemove', (e) => {
                    const rect = element.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;

                    element.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px)`;
                });

                element.addEventListener('mouseleave', () => {
                    element.style.transform = 'translate(0, 0)';
                });
            });

            // Parallax effect
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.parallax');

                parallaxElements.forEach(element => {
                    const speed = 0.5;
                    element.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('section > div').forEach(el => {
                observer.observe(el);
            });

            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Dynamic particle system
            function createParticle() {
                const particle = document.createElement('div');
                particle.className = 'fixed w-2 h-2 bg-primary-500/30 rounded-full pointer-events-none z-0';
                particle.style.left = Math.random() * window.innerWidth + 'px';
                particle.style.top = window.innerHeight + 'px';
                particle.style.animation = `float ${Math.random() * 10 + 5}s linear infinite`;

                document.body.appendChild(particle);

                setTimeout(() => {
                    particle.remove();
                }, 15000);
            }

            // Create particles periodically
            setInterval(createParticle, 3000);
        });

        // Theme switcher (if needed)
        function toggleTheme() {
            document.body.classList.toggle('light-theme');
        }

        // Performance optimization
        let ticking = false;

        function updateParallax() {
            if (!ticking) {
                requestAnimationFrame(() => {
                    // Parallax updates here
                    ticking = false;
                });
                ticking = true;
            }
        }

        window.addEventListener('scroll', updateParallax);
    </script>
</body>

</html>

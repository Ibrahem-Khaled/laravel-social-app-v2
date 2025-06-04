<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حول - الكاسر</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            direction: rtl;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-30px);
            }

            60% {
                transform: translateY(-15px);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(76, 201, 240, 0.5);
            }

            50% {
                box-shadow: 0 0 40px rgba(76, 201, 240, 0.8), 0 0 60px rgba(76, 201, 240, 0.6);
            }
        }

        @keyframes typewriter {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        @keyframes blink {
            50% {
                border-color: transparent;
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes wiggle {

            0%,
            7% {
                transform: rotateZ(0);
            }

            15% {
                transform: rotateZ(-15deg);
            }

            20% {
                transform: rotateZ(10deg);
            }

            25% {
                transform: rotateZ(-10deg);
            }

            30% {
                transform: rotateZ(6deg);
            }

            35% {
                transform: rotateZ(-4deg);
            }

            40%,
            100% {
                transform: rotateZ(0);
            }
        }

        @keyframes heartbeat {
            0% {
                transform: scale(1);
            }

            14% {
                transform: scale(1.3);
            }

            28% {
                transform: scale(1);
            }

            42% {
                transform: scale(1.3);
            }

            70% {
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 1s ease-out forwards;
        }

        .animate-slideInLeft {
            animation: slideInLeft 1s ease-out forwards;
        }

        .animate-slideInRight {
            animation: slideInRight 1s ease-out forwards;
        }

        .animate-bounce-custom {
            animation: bounce 2s infinite;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        .animate-typewriter {
            animation: typewriter 3s steps(40, end), blink 0.75s step-end infinite;
        }

        .animate-rotate {
            animation: rotate 10s linear infinite;
        }

        .animate-wiggle {
            animation: wiggle 1s ease-in-out;
        }

        .animate-heartbeat {
            animation: heartbeat 1.5s ease-in-out infinite;
        }

        .gradient-text {
            background: linear-gradient(45deg, #4CC9F0, #4CC9F0, #4CC9F0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: linear-gradient(45deg, #4CC9F0, #4CC9F0);
            border-radius: 50%;
            animation: float 4s ease-in-out infinite;
        }

        .typing::after {
            content: '|';
            color: #4CC9F0;
            font-weight: bold;
            animation: blink 1s infinite;
        }

        @media (max-width: 768px) {
            .hero-text {
                font-size: 2.5rem;
            }
        }

        /* RTL specific adjustments */
        .rtl-flip {
            transform: scaleX(-1);
        }
    </style>
</head>

<body class=" overflow-x-hidden" style="background-color: #333;">
    <!-- Floating Particles -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="particle" style="right: 10%; top: 20%; animation-delay: 0s;"></div>
        <div class="particle" style="left: 80%; top: 10%; animation-delay: 1s;"></div>
        <div class="particle" style="right: 60%; top: 70%; animation-delay: 2s;"></div>
        <div class="particle" style="left: 20%; top: 80%; animation-delay: 3s;"></div>
        <div class="particle" style="right: 90%; top: 60%; animation-delay: 4s;"></div>
    </div>

    <!-- Hero Section -->
    <section
        class="relative overflow-hidden from-blue-900 via-cyan-600 via-purple-600 to-pink-500 text-white py-20 md:py-32">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 right-10 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute bottom-20 left-10 w-24 h-24 bg-cyan-400/20 rounded-full animate-bounce-custom"></div>
            <div class="absolute top-1/2 right-1/4 w-16 h-16 bg-yellow-400/20 rounded-full animate-rotate"></div>
        </div>

        <div class="container mx-auto px-4 md:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <div class="lg:w-1/2 mb-12 lg:mb-0 opacity-0 animate-slideInRight">
                    <div class="mb-6">
                        <span
                            class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-6 py-2 text-sm font-semibold mb-4 animate-glow">
                            🎉 الآن مع أكثر من 50 مليون مستخدم نشط!
                        </span>
                    </div>
                    <h1 class="hero-text text-5xl md:text-7xl font-black mb-6 text-shadow">
                        مرحباً بك في <span class="gradient-text">الكاسر</span>
                    </h1>
                    <p class="text-xl md:text-2xl font-normal opacity-90 mb-8 typing">
                        المنصة الأولى لمشاركة الفيديوهات القصيرة والبث المباشر
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <button
                            class="bg-white text-cyan-600 font-bold px-8 py-4 rounded-full hover:scale-110 transition-all duration-300 animate-bounce-custom shadow-2xl">
                            🚀 انضم الآن - مجاناً!
                        </button>
                        <button
                            class="glass-effect text-white font-bold px-8 py-4 rounded-full hover:scale-110 transition-all duration-300">
                            📱 تحميل التطبيق
                        </button>
                    </div>
                </div>
                <div class="lg:w-1/2 flex justify-center lg:justify-start opacity-0 animate-slideInLeft"
                    style="animation-delay: 0.5s;">
                    <div class="relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-purple-400 rounded-3xl animate-glow">
                        </div>
                        <div
                            class="relative glass-effect rounded-3xl p-8 shadow-2xl transform hover:rotate-3 transition-transform duration-500">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="شعار الكاسر"
                                class="w-48 h-48 md:w-64 md:h-64 rounded-2xl animate-float">
                        </div>
                        <!-- Decorative Elements -->
                        <div class="absolute -top-4 -left-4 text-4xl animate-wiggle">⭐</div>
                        <div class="absolute -bottom-4 -right-4 text-4xl animate-bounce">🎵</div>
                        <div class="absolute top-1/2 -right-8 text-3xl animate-heartbeat">❤️</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Effect at Bottom -->
        <div class="absolute bottom-0 left-0 w-full">
            <svg viewBox="0 0 1440 320" class="w-full h-auto">
                <path fill="#f9fafb" fill-opacity="1"
                    d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,208C1248,224,1344,192,1392,176L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 relative">
        <div class="container mx-auto px-4 md:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 opacity-0 animate-fadeIn" style="animation-delay: 0.2s;">
                <div class="text-center group hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl md:text-5xl font-black gradient-text mb-2 animate-bounce-custom">+50م</div>
                    <p class="text-gray-600 font-semibold">مستخدم نشط</p>
                </div>
                <div class="text-center group hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl md:text-5xl font-black gradient-text mb-2 animate-bounce-custom"
                        style="animation-delay: 0.5s;">+2م</div>
                    <p class="text-gray-600 font-semibold">فيديو مشارك</p>
                </div>
                <div class="text-center group hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl md:text-5xl font-black gradient-text mb-2 animate-bounce-custom"
                        style="animation-delay: 1s;">+150</div>
                    <p class="text-gray-600 font-semibold">دولة</p>
                </div>
                <div class="text-center group hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl md:text-5xl font-black gradient-text mb-2 animate-bounce-custom"
                        style="animation-delay: 1.5s;">24/7</div>
                    <p class="text-gray-600 font-semibold">بث مباشر</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 from-blue-50 to-purple-50 relative overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute top-10 left-10 text-6xl opacity-20 animate-float">🎬</div>
        <div class="absolute bottom-10 right-10 text-6xl opacity-20 animate-wiggle">🎭</div>

        <div class="container mx-auto px-4 md:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16 opacity-0 animate-fadeIn" style="animation-delay: 0.3s;">
                    <h2 class="text-4xl md:text-6xl font-black gradient-text mb-8">حول الكاسر</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-cyan-500 to-purple-500 mx-auto rounded-full"></div>
                </div>

                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="opacity-0 animate-slideInRight" style="animation-delay: 0.5s;">
                        <div class="glass-effect rounded-3xl p-8 hover:scale-105 transition-all duration-500">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">🚀 مهمتنا</h3>
                            <p class="text-lg text-gray-600 leading-relaxed mb-6">
                                الكاسر تُحدث ثورة في طريقة تواصل الناس ومشاركة إبداعاتهم من خلال الفيديوهات القصيرة.
                                منصتنا تمكن المبدعين من التعبير عن أنفسهم وبناء مجتمعات والوصول إلى جماهير حول العالم.
                            </p>
                            <p class="text-lg text-gray-600 leading-relaxed">
                                مع ميزات الذكاء الاصطناعي المتطورة والبث المباشر السلس وأدوات التحرير المبتكرة،
                                نحن نبني مستقبل الترفيه الرقمي الذي يجمع الناس عبر الثقافات والقارات.
                            </p>
                        </div>
                    </div>

                    <div class="opacity-0 animate-slideInLeft" style="animation-delay: 0.7s;">
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="glass-effect rounded-2xl p-6 text-center hover:scale-110 transition-all duration-300 group">
                                <div class="text-4xl mb-3 group-hover:animate-bounce">🎨</div>
                                <h4 class="font-bold text-gray-800">أدوات إبداعية</h4>
                                <p class="text-sm text-gray-600 mt-2">مجموعة تحرير متقدمة</p>
                            </div>
                            <div
                                class="glass-effect rounded-2xl p-6 text-center hover:scale-110 transition-all duration-300 group">
                                <div class="text-4xl mb-3 group-hover:animate-wiggle">🤖</div>
                                <h4 class="font-bold text-gray-800">ذكاء اصطناعي</h4>
                                <p class="text-sm text-gray-600 mt-2">توصيات ذكية</p>
                            </div>
                            <div
                                class="glass-effect rounded-2xl p-6 text-center hover:scale-110 transition-all duration-300 group">
                                <div class="text-4xl mb-3 group-hover:animate-heartbeat">🌍</div>
                                <h4 class="font-bold text-gray-800">انتشار عالمي</h4>
                                <p class="text-sm text-gray-600 mt-2">مجتمع عالمي</p>
                            </div>
                            <div
                                class="glass-effect rounded-2xl p-6 text-center hover:scale-110 transition-all duration-300 group">
                                <div class="text-4xl mb-3 group-hover:animate-float">💎</div>
                                <h4 class="font-bold text-gray-800">جودة عالية</h4>
                                <p class="text-sm text-gray-600 mt-2">دعم فيديو 4K</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Videos Section -->
    <section class="py-20 relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-8 relative">
            <div class="text-center mb-16 opacity-0 animate-fadeIn" style="animation-delay: 0.4s;">
                <h2 class="text-4xl md:text-5xl font-black gradient-text mb-4">🔥 الفيديوهات الرائجة</h2>
                <p class="text-xl text-gray-600">اكتشف ما يجذب القلوب حول العالم</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <!-- Video Card 1 -->
                <div class="opacity-0 animate-fadeIn group" style="animation-delay: 0.6s;">
                    <div
                        class="bg-white rounded-3xl shadow-xl overflow-hidden hover:scale-105 hover:shadow-2xl hover:rotate-1 transition-all duration-500 glass-effect">
                        <div class="relative overflow-hidden">
                            <img src="https://via.placeholder.com/300x400/FF6B6B/FFFFFF?text=💃+معركة+رقص"
                                alt="فيديو رقص"
                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 right-4 flex items-center space-x-2">
                                <span
                                    class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-bold animate-heartbeat">❤️
                                    2.1م</span>
                                <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full font-bold">💬
                                    45ك</span>
                            </div>
                            <div class="absolute top-4 left-4 text-2xl animate-bounce">🔥</div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-gray-800 mb-2 text-lg">تحدي معركة الرقص الملحمي</h3>
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <img src="https://via.placeholder.com/40x40/4CC9F0/FFFFFF?text=س"
                                    class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-cyan-600 font-semibold text-sm">@ملكة_الرقص_سارة</p>
                                    <p class="text-gray-500 text-xs">2.3 مليون متابع</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Card 2 -->
                <div class="opacity-0 animate-fadeIn group" style="animation-delay: 0.8s;">
                    <div
                        class="bg-white rounded-3xl shadow-xl overflow-hidden hover:scale-105 hover:shadow-2xl hover:-rotate-1 transition-all duration-500 glass-effect">
                        <div class="relative overflow-hidden">
                            <img src="https://via.placeholder.com/300x400/4ECDC4/FFFFFF?text=😂+كوميديا+ذهبية"
                                alt="فيديو كوميدي"
                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 right-4 flex items-center space-x-2">
                                <span
                                    class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-bold animate-heartbeat">❤️
                                    890ك</span>
                                <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full font-bold">💬
                                    12ك</span>
                            </div>
                            <div class="absolute top-4 left-4 text-2xl animate-wiggle">😂</div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-gray-800 mb-2 text-lg">كوميديا الحياة اليومية المضحكة</h3>
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <img src="https://via.placeholder.com/40x40/F59E0B/FFFFFF?text=م"
                                    class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-cyan-600 font-semibold text-sm">@مايك_المضحك_الرسمي</p>
                                    <p class="text-gray-500 text-xs">1.8 مليون متابع</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Card 3 -->
                <div class="opacity-0 animate-fadeIn group" style="animation-delay: 1s;">
                    <div
                        class="bg-white rounded-3xl shadow-xl overflow-hidden hover:scale-105 hover:shadow-2xl hover:rotate-1 transition-all duration-500 glass-effect">
                        <div class="relative overflow-hidden">
                            <img src="https://via.placeholder.com/300x400/45B7D1/FFFFFF?text=👨‍🍳+شيف+ماهر"
                                alt="فيديو طبخ"
                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 right-4 flex items-center space-x-2">
                                <span
                                    class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-bold animate-heartbeat">❤️
                                    1.5م</span>
                                <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full font-bold">💬
                                    89ك</span>
                            </div>
                            <div class="absolute top-4 left-4 text-2xl animate-float">👨‍🍳</div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-gray-800 mb-2 text-lg">كلاس طبخ احترافي في 60 ثانية</h3>
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <img src="https://via.placeholder.com/40x40/EC4899/FFFFFF?text=أ"
                                    class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-cyan-600 font-semibold text-sm">@الشيف_أماندا_المحترفة</p>
                                    <p class="text-gray-500 text-xs">3.1 مليون متابع</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Card 4 -->
                <div class="opacity-0 animate-fadeIn group" style="animation-delay: 1.2s;">
                    <div
                        class="bg-white rounded-3xl shadow-xl overflow-hidden hover:scale-105 hover:shadow-2xl hover:-rotate-1 transition-all duration-500 glass-effect">
                        <div class="relative overflow-hidden">
                            <img src="https://via.placeholder.com/300x400/9333EA/FFFFFF?text=🎵+سحر+موسيقي"
                                alt="فيديو موسيقي"
                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 right-4 flex items-center space-x-2">
                                <span
                                    class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-bold animate-heartbeat">❤️
                                    3.2م</span>
                                <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full font-bold">💬
                                    156ك</span>
                            </div>
                            <div class="absolute top-4 left-4 text-2xl animate-bounce">🎵</div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-gray-800 mb-2 text-lg">تحدي كفر الأغنية الفيروسية</h3>
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <img src="https://via.placeholder.com/40x40/10B981/FFFFFF?text=ل"
                                    class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-cyan-600 font-semibold text-sm">@لونا_الصوتيات</p>
                                    <p class="text-gray-500 text-xs">4.7 مليون متابع</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Streaming Section -->
    <section class="py-20 from-blue-900 to-purple-900 text-white relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div class="absolute top-20 right-20 w-40 h-40 bg-white/5 rounded-full animate-float"></div>
            <div class="absolute bottom-20 left-20 w-32 h-32 bg-cyan-400/10 rounded-full animate-bounce-custom"></div>
            <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-yellow-400/10 rounded-full animate-rotate"></div>
        </div>

        <div class="container mx-auto px-4 md:px-8 relative">
            <div class="text-center mb-16 opacity-0 animate-fadeIn" style="animation-delay: 0.6s;">
                <h2 class="text-4xl md:text-5xl font-black mb-4 text-shadow">🔴 البث المباشر الآن</h2>
                <p class="text-xl opacity-90">انضم إلى آلاف المشاهدين يتابعون المحتوى المباشر الآن!</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Live Stream 1 -->
                <div class="opacity-0 animate-slideInRight" style="animation-delay: 0.8s;">
                    <div class="glass-effect rounded-3xl p-8 hover:scale-105 transition-all duration-500 group">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4 space-x-reverse">
                                <div class="relative">
                                    <img src="https://via.placeholder.com/80x80/F39C12/FFFFFF?text=🎤"
                                        alt="مستخدم مباشر"
                                        class="w-16 h-16
                                         rounded-full border-4 border-cyan-400 group-hover:animate-bounce">
                                    <div
                                        class="absolute bottom-0 right-0 w-5 h-5 bg-red-500 rounded-full animate-heartbeat">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-xl">@المغني_المحترف</h3>
                                    <p class="text-sm opacity-80">2.4 مليون متابع</p>
                                </div>
                            </div>
                        </div>
                        <div class="relative rounded-2xl overflow-hidden mb-4">
                            <img src="https://via.placeholder.com/400x300/4CC9F0/FFFFFF?text=بث+مباشر+🎵"
                                alt="بث مباشر"
                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div
                                class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                                🔴 مباشر الآن
                            </div>
                            <div class="absolute bottom-4 right-4 flex items-center space-x-2">
                                <span
                                    class="bg-white/30 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-bold">👥
                                    24.5ك</span>
                            </div>
                        </div>
                        <p class="text-lg font-semibold mb-2">حفل موسيقي مباشر - أغاني جديدة!</p>
                        <button
                            class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 rounded-full transition-all duration-300 group-hover:animate-wiggle">
                            انضم الآن
                        </button>
                    </div>
                </div>

                <!-- Live Stream 2 -->
                <div class="opacity-0 animate-slideInRight" style="animation-delay: 1s;">
                    <div class="glass-effect rounded-3xl p-8 hover:scale-105 transition-all duration-500 group">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4 space-x-reverse">
                                <div class="relative">
                                    <img src="https://via.placeholder.com/80x80/EC4899/FFFFFF?text=👩‍🍳"
                                        alt="مستخدم مباشر"
                                        class="w-16 h-16 rounded-full border-4 border-purple-400 group-hover:animate-bounce">
                                    <div
                                        class="absolute bottom-0 right-0 w-5 h-5 bg-red-500 rounded-full animate-heartbeat">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-xl">@شيف_سارة</h3>
                                    <p class="text-sm opacity-80">1.8 مليون متابع</p>
                                </div>
                            </div>
                        </div>
                        <div class="relative rounded-2xl overflow-hidden mb-4">
                            <img src="https://via.placeholder.com/400x300/F72585/FFFFFF?text=طبخ+حي+👩‍🍳"
                                alt="بث مباشر"
                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div
                                class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                                🔴 مباشر الآن
                            </div>
                            <div class="absolute bottom-4 right-4 flex items-center space-x-2">
                                <span
                                    class="bg-white/30 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-bold">👥
                                    18.2ك</span>
                            </div>
                        </div>
                        <p class="text-lg font-semibold mb-2">طبخ عشاء سريع ولذيذ في 30 دقيقة</p>
                        <button
                            class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 rounded-full transition-all duration-300 group-hover:animate-wiggle">
                            انضم الآن
                        </button>
                    </div>
                </div>

                <!-- Live Stream 3 -->
                <div class="opacity-0 animate-slideInRight" style="animation-delay: 1.2s;">
                    <div class="glass-effect rounded-3xl p-8 hover:scale-105 transition-all duration-500 group">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4 space-x-reverse">
                                <div class="relative">
                                    <img src="https://via.placeholder.com/80x80/10B981/FFFFFF?text=🎮"
                                        alt="مستخدم مباشر"
                                        class="w-16 h-16 rounded-full border-4 border-green-400 group-hover:animate-bounce">
                                    <div
                                        class="absolute bottom-0 right-0 w-5 h-5 bg-red-500 rounded-full animate-heartbeat">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-xl">@بطل_الألعاب</h3>
                                    <p class="text-sm opacity-80">3.7 مليون متابع</p>
                                </div>
                            </div>
                        </div>
                        <div class="relative rounded-2xl overflow-hidden mb-4">
                            <img src="https://via.placeholder.com/400x300/7209B7/FFFFFF?text=جيمنج+🎮" alt="بث مباشر"
                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div
                                class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                                🔴 مباشر الآن
                            </div>
                            <div class="absolute bottom-4 right-4 flex items-center space-x-2">
                                <span
                                    class="bg-white/30 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-bold">👥
                                    42.1ك</span>
                            </div>
                        </div>
                        <p class="text-lg font-semibold mb-2">بطولة جديدة في فورتنايت مع المشاهدين!</p>
                        <button
                            class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-full transition-all duration-300 group-hover:animate-wiggle">
                            انضم الآن
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-8">
            <div class="text-center mb-16 opacity-0 animate-fadeIn" style="animation-delay: 0.4s;">
                <h2 class="text-4xl md:text-5xl font-black gradient-text mb-4">✨ مميزات تيكزي</h2>
                <p class="text-xl text-gray-600">اكتشف ما يجعل تيكزي مختلفة عن غيرها</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Feature 1 -->
                <div class="opacity-0 animate-slideInLeft" style="animation-delay: 0.6s;">
                    <div class="glass-effect rounded-3xl p-8 h-full hover:scale-105 transition-all duration-500 group">
                        <div class="text-6xl mb-6 gradient-text animate-float">🎭</div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">أدوات تأثيرات متقدمة</h3>
                        <p class="text-gray-600 leading-relaxed">
                            استخدم أحدث أدوات المؤثرات البصرية والمرشحات الذكية التي تعمل بالذكاء الاصطناعي لجعل
                            فيديوهاتك أكثر احترافية وجاذبية.
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="opacity-0 animate-slideInLeft" style="animation-delay: 0.8s;">
                    <div class="glass-effect rounded-3xl p-8 h-full hover:scale-105 transition-all duration-500 group">
                        <div class="text-6xl mb-6 gradient-text animate-bounce">🎵</div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">مكتبة موسيقى ضخمة</h3>
                        <p class="text-gray-600 leading-relaxed">
                            اختر من بين آلاف الأغاني والمؤثرات الصوتية المرخصة لإضافة البعد الموسيقي المثالي لمقاطعك
                            بدون مشاكل حقوق ملكية.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="opacity-0 animate-slideInLeft" style="animation-delay: 1s;">
                    <div class="glass-effect rounded-3xl p-8 h-full hover:scale-105 transition-all duration-500 group">
                        <div class="text-6xl mb-6 gradient-text animate-wiggle">💎</div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">جودة 4K فائقة</h3>
                        <p class="text-gray-600 leading-relaxed">
                            استمتع بدعم كامل للفيديوهات بدقة 4K مع تقنيات ضغط متطورة تحافظ على الجودة مع تقليل استهلاك
                            البيانات.
                        </p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="opacity-0 animate-slideInRight" style="animation-delay: 0.6s;">
                    <div class="glass-effect rounded-3xl p-8 h-full hover:scale-105 transition-all duration-500 group">
                        <div class="text-6xl mb-6 gradient-text animate-heartbeat">🤖</div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">ذكاء اصطناعي شخصي</h3>
                        <p class="text-gray-600 leading-relaxed">
                            نظام توصيات ذكي يتعلم من تفضيلاتك ليقدم لك المحتوى الأكثر ملاءمة لك ولاهتماماتك.
                        </p>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="opacity-0 animate-slideInRight" style="animation-delay: 0.8s;">
                    <div class="glass-effect rounded-3xl p-8 h-full hover:scale-105 transition-all duration-500 group">
                        <div class="text-6xl mb-6 gradient-text animate-rotate">🌍</div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">ترجمة تلقائية</h3>
                        <p class="text-gray-600 leading-relaxed">
                            ترجمة تلقائية متعددة اللغات للتعليقات والنصوص مع دعم لأكثر من 100 لغة لتجاوز الحواجز
                            اللغوية.
                        </p>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="opacity-0 animate-slideInRight" style="animation-delay: 1s;">
                    <div class="glass-effect rounded-3xl p-8 h-full hover:scale-105 transition-all duration-500 group">
                        <div class="text-6xl mb-6 gradient-text animate-glow">💰</div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">نظام أرباح متكامل</h3>
                        <p class="text-gray-600 leading-relaxed">
                            برنامج شراكة يسمح للمبدعين بجني الأرباح من محتواهم عبر الإعلانات والهدايا والمزيد من
                            المصادر.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20  from-cyan-50 to-purple-50 relative overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute top-10 right-10 text-6xl opacity-20 animate-float">💬</div>
        <div class="absolute bottom-10 left-10 text-6xl opacity-20 animate-wiggle">⭐</div>

        <div class="container mx-auto px-4 md:px-8">
            <div class="text-center mb-16 opacity-0 animate-fadeIn" style="animation-delay: 0.4s;">
                <h2 class="text-4xl md:text-5xl font-black gradient-text mb-4">📢 آراء المستخدمين</h2>
                <p class="text-xl text-gray-600">ما يقوله المبدعون عن منصتنا</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Testimonial 1 -->
                <div class="opacity-0 animate-slideInLeft" style="animation-delay: 0.6s;">
                    <div class="bg-white rounded-3xl p-8 shadow-lg hover:scale-105 transition-all duration-500 h-full">
                        <div class="flex items-center mb-6">
                            <img src="https://via.placeholder.com/80x80/4CC9F0/FFFFFF?text=س" alt="مستخدم"
                                class="w-16 h-16 rounded-full border-4 border-cyan-400">
                            <div class="mr-4">
                                <h4 class="font-bold text-gray-800">سارة أحمد</h4>
                                <p class="text-sm text-gray-500">مبدعة محتوى - 1.2M متابع</p>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            "تيكزي غيرت حياتي! من خلال المنصة استطعت بناء مجتمع كامل من المعجبين وتحقيق دخل ممتاز من
                            شغفي بمشاركة الفيديوهات. الأدوات الإبداعية رائعة وسهلة الاستخدام."
                        </p>
                        <div class="flex space-x-2">
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="opacity-0 animate-slideInLeft" style="animation-delay: 0.8s;">
                    <div class="bg-white rounded-3xl p-8 shadow-lg hover:scale-105 transition-all duration-500 h-full">
                        <div class="flex items-center mb-6">
                            <img src="https://via.placeholder.com/80x80/F72585/FFFFFF?text=م" alt="مستخدم"
                                class="w-16 h-16 rounded-full border-4 border-pink-400">
                            <div class="mr-4">
                                <h4 class="font-bold text-gray-800">محمد خالد</h4>
                                <p class="text-sm text-gray-500">صانع أفلام - 850K متابع</p>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            "أفضل منصة للفيديوهات القصيرة من حيث الجودة والأداء. نظام التوصيات الذكي ساعد فيديوهاتي في
                            الوصول للجمهور المناسب وزيادة مشاهداتي بشكل كبير."
                        </p>
                        <div class="flex space-x-2">
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="opacity-0 animate-slideInLeft" style="animation-delay: 1s;">
                    <div class="bg-white rounded-3xl p-8 shadow-lg hover:scale-105 transition-all duration-500 h-full">
                        <div class="flex items-center mb-6">
                            <img src="https://via.placeholder.com/80x80/7209B7/FFFFFF?text=ل" alt="مستخدم"
                                class="w-16 h-16 rounded-full border-4 border-purple-400">
                            <div class="mr-4">
                                <h4 class="font-bold text-gray-800">لينا فاروق</h4>
                                <p class="text-sm text-gray-500">مغنية - 2.4M متابع</p>
                            </div>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            "البث المباشر على تيكزي سلس وبدون مشاكل تقنية. التفاعل مع المعجبين رائع من خلال الهدايا
                            والرسائل. حققت شهرة واسعة بفضل هذه المنصة الرائعة!"
                        </p>
                        <div class="flex space-x-2">
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <span class="text-yellow-400 text-xl">⭐</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20  from-cyan-600 to-purple-600 text-white relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-40 h-40 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute bottom-20 right-20 w-32 h-32 bg-cyan-400/20 rounded-full animate-bounce-custom"></div>
            <div class="absolute top-1/2 left-1/3 w-20 h-20 bg-yellow-400/20 rounded-full animate-rotate"></div>
        </div>

        <div class="container mx-auto px-4 md:px-8 relative">
            <div class="max-w-4xl mx-auto text-center opacity-0 animate-fadeIn" style="animation-delay: 0.6s;">
                <h2 class="text-4xl md:text-5xl font-black mb-8 text-shadow">هل أنت مستعد لبدء رحلتك الإبداعية؟</h2>
                <p class="text-xl opacity-90 mb-10">
                    انضم إلى مجتمع الملايين من المبدعين حول العالم وابدأ مشاركة إبداعاتك اليوم!
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <button
                        class="bg-white text-cyan-600 font-bold px-10 py-5 rounded-full hover:scale-110 transition-all duration-300 animate-bounce-custom shadow-2xl text-lg">
                        🚀 سجل الآن - مجاناً!
                    </button>
                    <button
                        class="glass-effect text-white font-bold px-10 py-5 rounded-full hover:scale-110 transition-all duration-300 text-lg">
                        📱 اكتشف المزيد
                    </button>
                </div>
                <div class="mt-10 flex justify-center space-x-6">
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/40x40/FFFFFF/4CC9F0?text=👍"
                            class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="text-sm opacity-80">+50 مليون مستخدم</p>
                            <p class="text-xs opacity-60">يثقون بنا</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/40x40/FFFFFF/F72585?text=⭐"
                            class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="text-sm opacity-80">4.9/5 تقييم</p>
                            <p class="text-xs opacity-60">في متاجر التطبيقات</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-20 pb-10 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-500 via-purple-500 to-pink-500">
            </div>
            <div class="absolute top-20 right-20 w-20 h-20 bg-white/5 rounded-full animate-float"></div>
            <div class="absolute bottom-20 left-20 w-16 h-16 bg-cyan-400/10 rounded-full animate-bounce-custom"></div>
        </div>

        <div class="container mx-auto px-4 md:px-8 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Logo and Info -->
                <div class="opacity-0 animate-slideInRight" style="animation-delay: 0.6s;">
                    <div class="flex items-center mb-6">
                        <img src="https://via.placeholder.com/50x50/4CC9F0/FFFFFF?text=ت" alt="تيكزي"
                            class="w-12 h-12 rounded-lg mr-4">
                        <h3 class="text-2xl font-black gradient-text">تيكزي</h3>
                    </div>
                    <p class="text-gray-400 mb-6">
                        منصة الفيديوهات القصيرة والبث المباشر الرائدة في العالم العربي. نساعد المبدعين على مشاركة
                        إبداعاتهم وبناء مجتمعاتهم.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center hover:bg-cyan-600 transition-all duration-300">
                            <span class="text-xl">📱</span>
                        </a>
                        <a href="#"
                            class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-all duration-300">
                            <span class="text-xl">💬</span>
                        </a>
                        <a href="#"
                            class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center hover:bg-pink-600 transition-all duration-300">
                            <span class="text-xl">📸</span>
                        </a>
                        <a href="#"
                            class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-300">
                            <span class="text-xl">▶️</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="opacity-0 animate-slideInRight" style="animation-delay: 0.8s;">
                    <h4 class="text-xl font-bold mb-6">روابط سريعة</h4>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-gray-400 hover:text-cyan-400 transition-colors duration-300">الصفحة
                                الرئيسية</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-cyan-400 transition-colors duration-300">استكشف
                                الفيديوهات</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-cyan-400 transition-colors duration-300">البث
                                المباشر</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-cyan-400 transition-colors duration-300">المبدعون</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-cyan-400 transition-colors duration-300">الاشتراكات</a>
                        </li>
                    </ul>
                </div>

                <!-- Company -->
                <div class="opacity-0 animate-slideInRight" style="animation-delay: 1s;">
                    <h4 class="text-xl font-bold mb-6">الشركة</h4>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-gray-400 hover:text-cyan-400 transition-colors duration-300">عن تيكزي</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-cyan-400 transition-colors duration-300">الوظائف</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-cyan-400 transition-colors duration-300">الشروط
                                والأحكام</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-cyan-400 transition-colors duration-300">سياسة
                                الخصوصية</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-cyan-400 transition-colors duration-300">اتصل بنا</a>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="opacity-0 animate-slideInRight" style="animation-delay: 1.2s;">
                    <h4 class="text-xl font-bold mb-6">النشرة البريدية</h4>
                    <p class="text-gray-400 mb-4">
                        اشترك في نشرتنا البريدية لتصلك آخر التحديثات والعروض الحصرية.
                    </p>
                    <form class="flex">
                        <input type="email" placeholder="بريدك الإلكتروني"
                            class="bg-gray-800 text-white px-4 py-3 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 w-full">
                        <button type="submit"
                            class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-l-lg transition-colors duration-300">
                            اشترك
                        </button>
                    </form>
                    <div class="mt-6">
                        <h5 class="font-semibold mb-3">حمل التطبيق الآن</h5>
                        <div class="flex space-x-3">
                            <a href="#"
                                class="bg-gray-800 hover:bg-gray-700 rounded-lg p-2 flex items-center transition-colors duration-300">
                                <span class="text-2xl mr-2">📲</span>
                                <div>
                                    <p class="text-xs text-gray-400">حمله من</p>
                                    <p class="font-bold">متجر جوجل</p>
                                </div>
                            </a>
                            <a href="#"
                                class="bg-gray-800 hover:bg-gray-700 rounded-lg p-2 flex items-center transition-colors duration-300">
                                <span class="text-2xl mr-2">📱</span>
                                <div>
                                    <p class="text-xs text-gray-400">حمله من</p>
                                    <p class="font-bold">آب ستور</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center opacity-0 animate-fadeIn"
                style="animation-delay: 1.4s;">
                <p class="text-gray-500 text-sm mb-4 md:mb-0">
                    © 2023 تيكزي. جميع الحقوق محفوظة.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-500 hover:text-cyan-400 transition-colors duration-300">سياسة
                        الخصوصية</a>
                    <a href="#" class="text-gray-500 hover:text-cyan-400 transition-colors duration-300">الشروط
                        والأحكام</a>
                    <a href="#" class="text-gray-500 hover:text-cyan-400 transition-colors duration-300">إعدادات
                        ملفات التعريف</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop"
        class="fixed bottom-8 left-8 w-14 h-14 bg-cyan-600 text-white rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all duration-300 hover:bg-cyan-700">
        <span class="text-2xl">↑</span>
    </button>

    <script>
        // Animation trigger on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('[class*="animate-"]');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            animateElements.forEach(element => {
                observer.observe(element);
            });

            // Back to top button
            const backToTopButton = document.getElementById('backToTop');

            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('opacity-0', 'invisible');
                    backToTopButton.classList.add('opacity-100', 'visible');
                } else {
                    backToTopButton.classList.remove('opacity-100', 'visible');
                    backToTopButton.classList.add('opacity-0', 'invisible');
                }
            });

            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Typing animation
            const typingElement = document.querySelector('.typing');
            if (typingElement) {
                setTimeout(() => {
                    typingElement.style.animation = 'none';
                    setTimeout(() => {
                        typingElement.style.animation = '';
                    }, 10);
                }, 3000);
            }
        });
    </script>
</body>

</html>

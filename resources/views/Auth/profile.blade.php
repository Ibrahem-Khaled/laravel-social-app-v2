<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - أحمد محمد</title>
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

        @keyframes shimmer {
            0% {
                background-position: -200% -200%;
            }

            100% {
                background-position: 200% 200%;
            }
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes countUp {
            from {
                opacity: 0;
                transform: scale(0.5);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes heartBeat {
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

        .split-text span {
            display: inline-block;
            opacity: 0;
            transform: translateY(100px);
            animation: slideUp 0.8s forwards;
        }

        .count-up {
            animation: countUp 1s ease-out forwards;
        }

        .heart-beat {
            animation: heartBeat 1.5s ease-out infinite;
        }

        .profile-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .status-online {
            background: linear-gradient(45deg, #00ff88, #00cc6a);
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.5);
        }

        .achievement-glow {
            filter: drop-shadow(0 0 8px rgba(251, 191, 36, 0.8));
        }

        .story-ring {
            background: linear-gradient(45deg, #ff6b6b, #ffa500, #ff1493, #8a2be2);
            background-size: 300% 300%;
            animation: gradient 3s ease infinite;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'tajawal': ['Tajawal', 'sans-serif']
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
                            900: '#312e81'
                        },
                        dark: {
                            50: '#f8fafc',
                            800: '#1e293b',
                            900: '#0f172a'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="font-tajawal bg-dark-900 text-white overflow-x-hidden gradient-bg" x-data="profileApp()">
    <!-- Floating Particles Background -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-primary-500/10 rounded-full blob filter blur-3xl"></div>
        <div class="absolute top-3/4 right-1/4 w-80 h-80 bg-purple-500/10 rounded-full blob filter blur-3xl"
            style="animation-delay: -2s;"></div>
        <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-indigo-500/5 rounded-full blob filter blur-3xl"
            style="animation-delay: -4s;"></div>
    </div>

    <!-- Navigation Bar -->
    @include('components.website.nav-bar')

    <!-- Profile Header Section -->
    <section class="pt-24 pb-8 relative">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Cover Photo -->
            <div class="relative rounded-3xl overflow-hidden mb-8 h-64 md:h-80">
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&h=400&fit=crop"
                    alt="Cover Photo" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <button class="absolute top-4 left-4 glass px-4 py-2 rounded-full hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    تغيير الغلاف
                </button>
            </div>

            <!-- Profile Info -->
            <div class="relative -mt-20 mb-8">
                <div
                    class="flex flex-col md:flex-row items-center md:items-end space-y-6 md:space-y-0 md:space-x-8 md:space-x-reverse">
                    <!-- Profile Picture -->
                    <div class="relative group">
                        <div class="absolute inset-0 rounded-full pulse-ring bg-primary-500/30"></div>
                        <div class="story-ring p-1 rounded-full">
                            <div class="relative w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden glass">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&crop=face"
                                    alt="Profile Picture" class="w-full h-full object-cover">
                                <div
                                    class="absolute bottom-2 right-2 w-6 h-6 status-online rounded-full border-2 border-white">
                                </div>
                            </div>
                        </div>
                        <button
                            class="absolute bottom-2 left-2 w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform glow">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Profile Details -->
                    <div class="flex-1 text-center md:text-right space-y-4">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold mb-2 text-shadow">
                                أحمد محمد العلي
                                <svg class="w-6 h-6 inline mr-2 text-blue-500 achievement-glow" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </h1>
                            <p class="text-gray-400 text-lg mb-2">@ahmed_dev</p>
                            <div class="flex items-center justify-center md:justify-start space-x-2 space-x-reverse">
                                <span class="glass px-3 py-1 rounded-full text-sm">🎯 مطور تطبيقات</span>
                                <span class="glass px-3 py-1 rounded-full text-sm">🌟 خبير UI/UX</span>
                                <span class="glass px-3 py-1 rounded-full text-sm">💻 مبرمج فول ستاك</span>
                            </div>
                        </div>

                        <p class="text-gray-300 max-w-md mx-auto md:mx-0 leading-relaxed">
                            مطور تطبيقات شغوف بالتكنولوجيا والابتكار. أحب إنشاء تجارب مستخدم مذهلة وحلول تقنية متطورة.
                            📍 الرياض، السعودية 🌍
                        </p>

                        <div class="flex items-center justify-center md:justify-start space-x-4 space-x-reverse">
                            <button
                                class="group flex items-center space-x-2 space-x-reverse bg-gradient-to-r from-primary-600 to-purple-600 hover:from-primary-700 hover:to-purple-700 px-6 py-3 rounded-full font-bold transition-all transform hover:scale-105 shadow-xl">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span>متابعة</span>
                            </button>
                            <button class="glass px-6 py-3 rounded-full font-bold hover:bg-white/10 transition-all">
                                رسالة
                            </button>
                            <button class="glass p-3 rounded-full hover:bg-white/10 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="pb-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="glass rounded-2xl p-6 text-center hover-lift card-3d">
                    <div
                        class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400 count-up">
                        10
                    </div>
                    <div class="text-gray-400 mt-2">منشور</div>
                </div>
                <div class="glass rounded-2xl p-6 text-center hover-lift card-3d">
                    <div
                        class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-400 count-up">
                        10
                    </div>
                    <div class="text-gray-400 mt-2">متابع</div>
                </div>
                <div class="glass rounded-2xl p-6 text-center hover-lift card-3d">
                    <div
                        class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-red-400 count-up">
                        10
                    </div>
                    <div class="text-gray-400 mt-2">متابَع</div>
                </div>
                <div class="glass rounded-2xl p-6 text-center hover-lift card-3d">
                    <div
                        class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-purple-400 count-up">
                        10
                    </div>
                    <div class="text-gray-400 mt-2">إعجاب</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements Section -->
    <section class="pb-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-8">
                <h2 class="text-2xl font-bold mb-6 text-center">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-400">🏆
                        الإنجازات</span>
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center group cursor-pointer">
                        <div
                            class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center achievement-glow group-hover:scale-110 transition-transform">
                            <span class="text-2xl">👑</span>
                        </div>
                        <div class="text-sm font-semibold text-yellow-400">مستخدم مميز</div>
                        <div class="text-xs text-gray-400">منذ 2021</div>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div
                            class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center achievement-glow group-hover:scale-110 transition-transform">
                            <span class="text-2xl">🚀</span>
                        </div>
                        <div class="text-sm font-semibold text-blue-400">رائد أعمال</div>
                        <div class="text-xs text-gray-400">5 مشاريع</div>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div
                            class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center achievement-glow group-hover:scale-110 transition-transform">
                            <span class="text-2xl">💎</span>
                        </div>
                        <div class="text-sm font-semibold text-green-400">خبير تقني</div>
                        <div class="text-xs text-gray-400">100+ حل</div>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div
                            class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-pink-400 to-red-500 rounded-full flex items-center justify-center achievement-glow group-hover:scale-110 transition-transform">
                            <span class="text-2xl">❤️</span>
                        </div>
                        <div class="text-sm font-semibold text-pink-400">محبوب</div>
                        <div class="text-xs text-gray-400">50K+ إعجاب</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stories & Highlights -->
    <section class="pb-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-8">
                <h2 class="text-2xl font-bold mb-6">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-purple-400">📸
                        القصص المميزة</span>
                </h2>
                <div class="flex space-x-4 space-x-reverse overflow-x-auto pb-4">
                    <div class="flex-shrink-0 text-center cursor-pointer group">
                        <div class="story-ring p-1 rounded-full w-20 h-20 group-hover:scale-110 transition-transform">
                            <div class="w-full h-full rounded-full overflow-hidden glass">
                                <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=100&h=100&fit=crop"
                                    alt="Story" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="text-xs mt-2 text-gray-400">البرمجة</div>
                    </div>
                    <div class="flex-shrink-0 text-center cursor-pointer group">
                        <div class="story-ring p-1 rounded-full w-20 h-20 group-hover:scale-110 transition-transform">
                            <div class="w-full h-full rounded-full overflow-hidden glass">
                                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=100&h=100&fit=crop"
                                    alt="Story" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="text-xs mt-2 text-gray-400">العمل</div>
                    </div>
                    <div class="flex-shrink-0 text-center cursor-pointer group">
                        <div class="story-ring p-1 rounded-full w-20 h-20 group-hover:scale-110 transition-transform">
                            <div class="w-full h-full rounded-full overflow-hidden glass">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=100&h=100&fit=crop"
                                    alt="Story" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="text-xs mt-2 text-gray-400">السفر</div>
                    </div>
                    <div class="flex-shrink-0 text-center cursor-pointer group">
                        <div class="story-ring p-1 rounded-full w-20 h-20 group-hover:scale-110 transition-transform">
                            <div class="w-full h-full rounded-full overflow-hidden glass">
                                <img src="https://images.unsplash.com/photo-1551963831-b3b1ca40c98e?w=100&h=100&fit=crop"
                                    alt="Story" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="text-xs mt-2 text-gray-400">الطعام</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Tabs -->
    <section class="pb-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl overflow-hidden">
                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-700/30">
                    <button @click="activeTab = 'posts'" class="
flex-1 py-4 px-6 text-center font-medium"
                        :class="{ 'text-primary-400 border-b-2 border-primary-400': activeTab === 'posts', 'text-gray-400 hover:text-white': activeTab !== 'posts' }">
                        المنشورات
                    </button>
                    <button @click="activeTab = 'projects'" class="flex-1 py-4 px-6 text-center font-medium"
                        :class="{ 'text-primary-400 border-b-2 border-primary-400': activeTab === 'projects', 'text-gray-400 hover:text-white': activeTab !== 'projects' }">
                        المشاريع
                    </button>
                    <button @click="activeTab = 'saved'" class="flex-1 py-4 px-6 text-center font-medium"
                        :class="{ 'text-primary-400 border-b-2 border-primary-400': activeTab === 'saved', 'text-gray-400 hover:text-white': activeTab !== 'saved' }">
                        المحفوظات
                    </button>
                    <button @click="activeTab = 'about'" class="flex-1 py-4 px-6 text-center font-medium"
                        :class="{ 'text-primary-400 border-b-2 border-primary-400': activeTab === 'about', 'text-gray-400 hover:text-white': activeTab !== 'about' }">
                        عني
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Posts Tab -->
                    <div x-show="activeTab === 'posts'" class="space-y-6">
                        <div class="glass rounded-2xl p-6 hover-lift transition-all">
                            <div class="flex items-start space-x-4 space-x-reverse mb-4">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop&crop=face"
                                    alt="User" class="w-10 h-10 rounded-full">
                                <div>
                                    <h3 class="font-bold">أحمد محمد</h3>
                                    <p class="text-gray-400 text-sm">منذ 3 ساعات</p>
                                </div>
                            </div>
                            <p class="mb-4">شارك اليوم في مؤتمر المطورين العرب وألقيت محاضرة عن أحدث تقنيات الويب.
                                كانت تجربة رائعة!</p>
                            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&h=300&fit=crop"
                                alt="Post" class="w-full rounded-xl mb-4">
                            <div class="flex items-center justify-between text-gray-400">
                                <div class="flex space-x-4 space-x-reverse">
                                    <button class="flex items-center hover:text-primary-400">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                        245
                                    </button>
                                    <button class="flex items-center hover:text-primary-400">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        32
                                    </button>
                                </div>
                                <button class="hover:text-primary-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="glass rounded-2xl p-6 hover-lift transition-all">
                            <div class="flex items-start space-x-4 space-x-reverse mb-4">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop&crop=face"
                                    alt="User" class="w-10 h-10 rounded-full">
                                <div>
                                    <h3 class="font-bold">أحمد محمد</h3>
                                    <p class="text-gray-400 text-sm">منذ يومين</p>
                                </div>
                            </div>
                            <p class="mb-4">أطلقت اليوم نسخة جديدة من تطبيقي للتعلم الذاتي مع العديد من الميزات
                                الجديدة. جربوه وأخبروني برأيكم!</p>
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=300&fit=crop"
                                alt="Post" class="w-full rounded-xl mb-4">
                            <div class="flex items-center justify-between text-gray-400">
                                <div class="flex space-x-4 space-x-reverse">
                                    <button class="flex items-center hover:text-primary-400">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                        512
                                    </button>
                                    <button class="flex items-center hover:text-primary-400">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        87
                                    </button>
                                </div>
                                <button class="hover:text-primary-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Projects Tab -->
                    <div x-show="activeTab === 'projects'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="glass rounded-2xl overflow-hidden hover-lift transition-all">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=300&fit=crop"
                                alt="Project" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="font-bold text-lg mb-2">منصة التعلم الذاتي</h3>
                                <p class="text-gray-400 mb-4">منصة تعليمية متكاملة لتعلم البرمجة وتطوير الويب</p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="text-xs px-2 py-1 rounded-full glass">JavaScript</span>
                                    <span class="text-xs px-2 py-1 rounded-full glass">React</span>
                                    <span class="text-xs px-2 py-1 rounded-full glass">Node.js</span>
                                </div>
                                <button class="w-full glass py-2 rounded-lg hover:bg-white/10 transition-all">
                                    عرض المشروع
                                </button>
                            </div>
                        </div>
                        <div class="glass rounded-2xl overflow-hidden hover-lift transition-all">
                            <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=600&h=300&fit=crop"
                                alt="Project" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="font-bold text-lg mb-2">تطبيق المهام</h3>
                                <p class="text-gray-400 mb-4">تطبيق لإدارة المهام الشخصية والعملية</p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="text-xs px-2 py-1 rounded-full glass">Flutter</span>
                                    <span class="text-xs px-2 py-1 rounded-full glass">Firebase</span>
                                    <span class="text-xs px-2 py-1 rounded-full glass">Dart</span>
                                </div>
                                <button class="w-full glass py-2 rounded-lg hover:bg-white/10 transition-all">
                                    عرض المشروع
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Saved Tab -->
                    <div x-show="activeTab === 'saved'" class="space-y-6">
                        <div class="glass rounded-2xl p-6 hover-lift transition-all">
                            <div class="flex items-start space-x-4 space-x-reverse mb-4">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=50&h=50&fit=crop&crop=face"
                                    alt="User" class="w-10 h-10 rounded-full">
                                <div>
                                    <h3 class="font-bold">سارة أحمد</h3>
                                    <p class="text-gray-400 text-sm">منذ أسبوع</p>
                                </div>
                            </div>
                            <p class="mb-4">دليل شامل لتعلم React.js من الصفر حتى الاحتراف مع مشاريع عملية</p>
                            <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=600&h=300&fit=crop"
                                alt="Post" class="w-full rounded-xl mb-4">
                            <div class="flex items-center justify-between text-gray-400">
                                <button class="text-primary-400 flex items-center">
                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                    </svg>
                                    محفوظ
                                </button>
                                <button class="hover:text-primary-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- About Tab -->
                    <div x-show="activeTab === 'about'" class="space-y-6">
                        <div class="glass rounded-2xl p-6">
                            <h3 class="font-bold text-lg mb-4">نبذة عني</h3>
                            <p class="mb-4">أنا مطور تطبيقات ويب وموبايل بخبرة تزيد عن 5 سنوات في مجال البرمجة
                                والتطوير. أحب بناء حلول تقنية مبتكرة تساعد الناس في حياتهم اليومية.</p>
                            <p>حاصل على شهادة البكالوريوس في علوم الحاسب من جامعة الملك سعود، ومهتم بتطوير الذات ومساعدة
                                الآخرين في تعلم البرمجة.</p>
                        </div>

                        <div class="glass rounded-2xl p-6">
                            <h3 class="font-bold text-lg mb-4">المهارات</h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium">JavaScript</span>
                                        <span class="text-sm text-gray-400">95%</span>
                                    </div>
                                    <div class="w-full bg-gray-700 rounded-full h-2">
                                        <div class="bg-primary-500 h-2 rounded-full" style="width: 95%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium">React</span>
                                        <span class="text-sm text-gray-400">90%</span>
                                    </div>
                                    <div class="w-full bg-gray-700 rounded-full h-2">
                                        <div class="bg-primary-500 h-2 rounded-full" style="width: 90%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium">Node.js</span>
                                        <span class="text-sm text-gray-400">85%</span>
                                    </div>
                                    <div class="w-full bg-gray-700 rounded-full h-2">
                                        <div class="bg-primary-500 h-2 rounded-full" style="width: 85%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="glass rounded-2xl p-6">
                            <h3 class="font-bold text-lg mb-4">التعليم</h3>
                            <div class="space-y-4">
                                <div class="flex space-x-4 space-x-reverse">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-12 h-12 rounded-full bg-primary-500/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-primary-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-bold">بكالوريوس علوم الحاسب</h4>
                                        <p class="text-gray-400">جامعة الملك سعود</p>
                                        <p class="text-sm text-gray-500">2015 - 2019</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('components.website.footer')

    <script>
        function profileApp() {
            return {
                showMenu: false,
                activeTab: 'posts',
                stats: {
                    posts: 128,
                    followers: 5432,
                    following: 287,
                    likes: 10245
                },
                formatNumber(num) {
                    return new Intl.NumberFormat('ar-SA').format(num);
                },
                init() {
                    // Animate elements on scroll
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                                observer.unobserve(entry.target);
                            }
                        });
                    }, {
                        threshold: 0.1
                    });

                    document.querySelectorAll('.count-up').forEach(el => observer.observe(el));
                    document.querySelectorAll('.hover-lift').forEach(el => observer.observe(el));
                }
            }
        }
    </script>
</body>

</html>

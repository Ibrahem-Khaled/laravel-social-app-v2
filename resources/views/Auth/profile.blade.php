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

        @keyframes profilePulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes textGlow {

            0%,
            100% {
                text-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
            }

            50% {
                text-shadow: 0 0 20px rgba(139, 92, 246, 0.8), 0 0 30px rgba(139, 92, 246, 0.8);
            }
        }

        @keyframes borderRotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .gradient-bg {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #312e81, #1e1b4b);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
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

        .glass-dark {
            background: rgba(0, 0, 0, 0.2);
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

        .profile-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .status-online {
            background: linear-gradient(45deg, #00ff88, #00cc6a);
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.5);
            animation: profilePulse 2s ease-in-out infinite;
        }

        .achievement-glow {
            filter: drop-shadow(0 0 8px rgba(251, 191, 36, 0.8));
        }

        .profile-image {
            animation: profilePulse 3s ease-in-out infinite;
        }

        .text-glow {
            animation: textGlow 2s ease-in-out infinite;
        }

        .rotating-border {
            position: relative;
            border-radius: 50%;
            overflow: hidden;
        }

        .rotating-border::before {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ffeaa7, #dda0dd);
            border-radius: 50%;
            animation: borderRotate 3s linear infinite;
            z-index: -1;
        }

        .fade-in-up {
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .stats-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-10px) scale(1.05);
            background: linear-gradient(145deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
        }

        .bio-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.15);
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

        function profileApp() {
            return {
                followers: 0,
                following: 0,
                posts: 0,
                init() {
                    this.animateNumbers();
                },
                animateNumbers() {
                    this.animateValue('followers', {{ $user->followers->count() }} , 2000);
                    this.animateValue('following', {{ $user->followings->count() }} , 1500);
                    this.animateValue('posts', {{ $user->posts->count() }} , 1800);
                },
                animateValue(property, target, duration) {
                    const start = Date.now();
                    const animate = () => {
                        const elapsed = Date.now() - start;
                        const progress = Math.min(elapsed / duration, 1);
                        this[property] = Math.floor(target * progress);
                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        }
                    };
                    animate();
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
        <div class="absolute top-10 right-10 w-32 h-32 bg-pink-500/10 rounded-full blob filter blur-2xl"
            style="animation-delay: -1s;"></div>
        <div class="absolute bottom-10 left-10 w-48 h-48 bg-cyan-500/10 rounded-full blob filter blur-2xl"
            style="animation-delay: -3s;"></div>
    </div>

    <!-- Navigation Bar -->
    @include('components.website.nav-bar')

    <!-- Main Profile Container -->
    <div class="relative z-10 min-h-screen pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- Profile Header -->
            <div class="glass rounded-3xl p-8 mb-8 hover-lift fade-in-up">
                <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">

                    <!-- Profile Image with Rotating Border -->
                    <div class="relative">
                        <div class="rotating-border w-40 h-40">
                            <img src="{{ $user->user_avatar }}" alt="{{ $user->name }}"
                                class="w-full h-full object-cover rounded-full profile-image">
                        </div>
                        <!-- Online Status -->
                        <div class="absolute bottom-2 right-2 w-8 h-8 status-online rounded-full border-4 border-white">
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <div class="flex-1 text-center lg:text-right">
                        <div class="mb-4">
                            <h1 class="text-4xl lg:text-5xl font-bold text-glow mb-2">{{ $user->name }}</h1>
                            <p class="text-xl text-primary-300 mb-2">@ {{ $user->username }}</p>
                            @if ($user->current_level !== null)
                                <div class="relative inline-block group mt-2">
                                    <div
                                        class="absolute -inset-0.5 bg-gradient-to-r from-{{ $user->current_level->color }}-500 to-{{ $user->current_level->color }}-300 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-tilt">
                                    </div>
                                    <div
                                        class="relative px-4 py-2 bg-{{ $user->current_level->color }} rounded-lg leading-none flex items-center">
                                        <span class="text-{{ $user->current_level->color }}-200 mr-2">✨</span>
                                        <span class="font-bold text-white">المستوى
                                            {{ $user->current_level->level_number }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Bio -->
                        @if ($user->bio !== null)
                            <div class="bio-card rounded-2xl p-6 mb-6">
                                <p class="text-lg leading-relaxed text-gray-300 mb-4">
                                    {{ $user->bio }}
                                </p>
                            </div>
                        @endif

                        <!-- Follow Button -->
                        <div class="flex gap-4 justify-center lg:justify-end">
                            <button
                                class="bg-gradient-to-r from-primary-500 to-purple-600 hover:from-primary-600 hover:to-purple-700 px-8 py-3 rounded-full font-bold text-white transition-all duration-300 hover:scale-105 glow">
                                متابعة
                            </button>
                            <button
                                class="glass hover:bg-white/10 px-8 py-3 rounded-full font-bold transition-all duration-300 hover:scale-105">
                                رسالة
                            </button>
                            <button
                                class="glass hover:bg-white/10 px-6 py-3 rounded-full transition-all duration-300 hover:scale-105">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Posts -->
                <div class="stats-card rounded-2xl p-6 text-center fade-in-up" style="animation-delay: 0.1s;">
                    <div class="text-3xl mb-2">📝</div>
                    <div class="text-3xl font-bold text-primary-400 mb-2" x-text="posts.toLocaleString()"></div>
                    <div class="text-sm text-gray-400">المنشورات</div>
                </div>

                <!-- Followers -->
                <div class="stats-card rounded-2xl p-6 text-center fade-in-up" style="animation-delay: 0.2s;">
                    <div class="text-3xl mb-2">👥</div>
                    <div class="text-3xl font-bold text-purple-400 mb-2" x-text="followers.toLocaleString()">
                        {{ $user->followers->count() }}
                    </div>
                    <div class="text-sm text-gray-400">المتابعون</div>
                </div>

                <!-- Following -->
                <div class="stats-card rounded-2xl p-6 text-center fade-in-up" style="animation-delay: 0.3s;">
                    <div class="text-3xl mb-2">➕</div>
                    <div class="text-3xl font-bold text-green-400 mb-2" x-text="following.toLocaleString()">
                        {{ $user->followings->count() }}
                    </div>
                    <div class="text-sm text-gray-400">يتابع</div>
                </div>

                <!-- Likes -->
                <div class="stats-card rounded-2xl p-6 text-center fade-in-up" style="animation-delay: 0.4s;">
                    <div class="text-3xl mb-2 heart-beat">❤️</div>
                    <div class="text-3xl font-bold text-red-400 mb-2">
                        {{ $user->likedPosts->count() }}
                    </div>
                    <div class="text-sm text-gray-400">الإعجابات</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('components.website.footer')
</body>

</html>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - {{ $user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .gradient-bg {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #312e81, #1e1b4b);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .profile-pulse {
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
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

        .count-up {
            animation: countUp 1s ease-out forwards;
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
                activeTab: 'videos',
                followers: 0,
                following: 0,
                posts: 0,
                coins: 0,
                init() {
                    this.animateNumbers();
                },
                animateNumbers() {
                    this.animateValue('followers', {{ $user->followers->count() }}, 2000);
                    this.animateValue('following', {{ $user->followings->count() }}, 1500);
                    this.animateValue('posts', {{ $user->posts->count() }}, 1800);
                    this.animateValue('coins', {{ $user->coins }}, 2200);
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
    <!-- Navigation Bar -->
    @include('components.website.nav-bar')

    <!-- Main Profile Container -->
    <div class="relative z-10 min-h-screen pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- Profile Header -->
            <div
                class="bg-white/5 backdrop-blur-lg rounded-3xl p-8 mb-8 transition-all duration-300 hover:shadow-xl hover:shadow-primary-500/10">
                <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">

                    <!-- Profile Image -->
                    <div class="relative">
                        <div
                            class="w-40 h-40 rounded-full overflow-hidden border-4 border-primary-500/30 profile-pulse">
                            <img src="{{ $user->user_avatar }}" alt="{{ $user->name }}"
                                class="w-full h-full object-cover">
                        </div>
                        <!-- Online Status -->
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white">
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <div class="flex-1 text-center lg:text-right">
                        <div class="mb-4">
                            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-2 flex items-center">
                                {{ $user->name }}
                                @if ($user->is_verified)
                                    <img src="https://cdn-icons-png.flaticon.com/128/15050/15050690.png" alt="موثق"
                                        class="w-10 h-10">
                                @endif

                            </h1>
                            <p class="text-xl text-primary-300 mb-2">{{ '@' . $user->username }}</p>

                            <!-- Level and Coins -->
                            <div class="flex justify-center lg:justify-start items-center gap-4 mt-4">
                                @if ($user->current_level !== null)
                                    <div class="px-4 py-2 rounded-lg flex items-center"
                                        style="background-color: {{ $user->current_level->color }};">
                                        <span class="mr-2" style="color: {{ $user->current_level->color }};">✨</span>
                                        <span class="font-bold text-white">
                                            المستوى {{ $user->current_level->level_number }}
                                        </span>
                                    </div>
                                @endif
                                <div class="px-4 py-2 bg-yellow-600 rounded-lg flex items-center">
                                    <img src="https://cdn-icons-png.flaticon.com/128/9382/9382189.png" alt="Coin"
                                        class="w-6 h-6 ml-2">
                                    <span class="font-bold text-white"
                                        x-text="coins.toLocaleString()">{{ $user->coins }}</span>
                                    <span class="text-yellow-200 mr-1">عملة</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bio -->
                        @if ($user->bio)
                            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 mb-6">
                                <p class="text-lg leading-relaxed text-gray-300 mb-4">
                                    {{ $user->bio }}
                                </p>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex gap-4 justify-center lg:justify-end">
                            <button
                                class="bg-gradient-to-r from-primary-500 to-purple-600 hover:from-primary-600 hover:to-purple-700 px-8 py-3 rounded-full font-bold text-white transition-all duration-300 hover:scale-105">
                                متابعة
                            </button>
                            <button
                                class="bg-white/10 hover:bg-white/20 px-8 py-3 rounded-full font-bold transition-all duration-300 hover:scale-105">
                                رسالة
                            </button>
                            <a href="{{ route('profile.edit') }}"
                                class="bg-white/10 hover:bg-white/20 px-8 py-3 rounded-full font-bold transition-all duration-300 hover:scale-105">
                                تعديل الملف الشخصي
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Posts -->
                <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 text-center fade-in-up"
                    style="animation-delay: 0.1s;">
                    <div class="text-3xl mb-2">📝</div>
                    <div class="text-3xl font-bold text-primary-400 mb-2 count-up" x-text="posts.toLocaleString()">
                    </div>
                    <div class="text-sm text-gray-400">المنشورات</div>
                </div>

                <!-- Followers -->
                <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 text-center fade-in-up"
                    style="animation-delay: 0.2s;">
                    <div class="text-3xl mb-2">👥</div>
                    <div class="text-3xl font-bold text-purple-400 mb-2 count-up" x-text="followers.toLocaleString()">
                    </div>
                    <div class="text-sm text-gray-400">المتابعون</div>
                </div>

                <!-- Following -->
                <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 text-center fade-in-up"
                    style="animation-delay: 0.3s;">
                    <div class="text-3xl mb-2">➕</div>
                    <div class="text-3xl font-bold text-green-400 mb-2 count-up" x-text="following.toLocaleString()">
                    </div>
                    <div class="text-sm text-gray-400">يتابع</div>
                </div>

                <!-- Likes -->
                <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 text-center fade-in-up"
                    style="animation-delay: 0.4s;">
                    <div class="text-3xl mb-2">❤️</div>
                    <div class="text-3xl font-bold text-red-400 mb-2 count-up">{{ $user->likedPosts->count() }}</div>
                    <div class="text-sm text-gray-400">الإعجابات</div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-white/10 mb-8">
                <nav class="flex space-x-8 space-x-reverse">
                    <button @click="activeTab = 'videos'" class="py-4 px-1 border-b-2 font-medium text-sm"
                        :class="activeTab === 'videos' ? 'border-primary-500 text-primary-400' :
                            'border-transparent text-gray-400 hover:text-white'">
                        الفيديوهات
                    </button>
                    <button @click="activeTab = 'likes'" class="py-4 px-1 border-b-2 font-medium text-sm"
                        :class="activeTab === 'likes' ? 'border-primary-500 text-primary-400' :
                            'border-transparent text-gray-400 hover:text-white'">
                        الإعجابات
                    </button>
                    <button @click="activeTab = 'saved'" class="py-4 px-1 border-b-2 font-medium text-sm"
                        :class="activeTab === 'saved' ? 'border-primary-500 text-primary-400' :
                            'border-transparent text-gray-400 hover:text-white'">
                        المحفوظات
                    </button>
                    <button @click="activeTab = 'achievements'" class="py-4 px-1 border-b-2 font-medium text-sm"
                        :class="activeTab === 'achievements' ? 'border-primary-500 text-primary-400' :
                            'border-transparent text-gray-400 hover:text-white'">
                        الإنجازات
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="mb-12">
                <!-- Videos Tab -->
                <div x-show="activeTab === 'videos'" x-transition>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ([] as $video)
                            <div
                                class="bg-white/5 rounded-xl overflow-hidden hover:shadow-lg hover:shadow-primary-500/10 transition-all duration-300">
                                <div class="relative pt-[56.25%]">
                                    <img src="{{ $video->thumbnail }}" alt="{{ $video->title }}"
                                        class="absolute top-0 left-0 w-full h-full object-cover">
                                    <div class="absolute bottom-2 left-2 bg-black/70 px-2 py-1 rounded text-sm">
                                        {{ $video->duration }}
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2">{{ $video->title }}</h3>
                                    <div class="flex justify-between text-sm text-gray-400">
                                        <span>{{ $video->views }} مشاهدات</span>
                                        <span>{{ $video->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Likes Tab -->
                <div x-show="activeTab === 'likes'" x-transition>
                    <div class="text-center py-12">
                        <div class="text-5xl mb-4">❤️</div>
                        <h3 class="text-xl font-bold mb-2">الإعجابات</h3>
                        <p class="text-gray-400">سيظهر هنا كل المحتوى الذي أعجبك</p>
                    </div>
                </div>

                <!-- Saved Tab -->
                <div x-show="activeTab === 'saved'" x-transition>
                    <div class="text-center py-12">
                        <div class="text-5xl mb-4">📁</div>
                        <h3 class="text-xl font-bold mb-2">المحفوظات</h3>
                        <p class="text-gray-400">سيظهر هنا كل المحتوى الذي حفظته</p>
                    </div>
                </div>

                <!-- Achievements Tab -->
                <div x-show="activeTab === 'achievements'" x-transition>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ([] as $achievement)
                            <div
                                class="bg-white/5 rounded-xl p-6 text-center hover:shadow-lg hover:shadow-{{ $achievement->color }}-500/10 transition-all duration-300">
                                <div class="text-5xl mb-4">{{ $achievement->icon }}</div>
                                <h3 class="font-bold text-lg mb-2">{{ $achievement->title }}</h3>
                                <p class="text-gray-400 mb-4">{{ $achievement->description }}</p>
                                <div class="text-sm text-{{ $achievement->color }}-400">
                                    تم إنجازه في {{ $achievement->pivot->created_at->format('Y-m-d') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('components.website.footer')
</body>

</html>

<header class="fixed w-full z-50 glass" x-data="header">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo Section -->
            <div class="flex items-center group">
                <div class="relative">
                    <div class="absolute inset-0 w-12 h-12 rounded-full bg-primary-500 pulse-ring opacity-20"></div>
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center glow">
                        <img src="{{ asset('storage/' . $websiteData?->avatar) }}" alt="{{ $websiteData?->name }}"
                            class="w-8 h-8 rounded-full">
                    </div>
                </div>
                <span
                    class="mr-4 text-xl font-bold bg-gradient-to-r from-white to-primary-200 bg-clip-text text-transparent">
                    {{ $websiteData->name }}
                </span>
            </div>

            <!-- Desktop Navigation -->
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

            <!-- User Section -->
            @if (Auth::check())
                <div class="hidden md:flex items-center space-x-4 space-x-reverse" x-data="{ open: false }">
                    <!-- User Dropdown Trigger -->
                    <button @click="open = !open"
                        class="flex items-center space-x-2 space-x-reverse focus:outline-none">
                        <div class="relative">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                                alt="{{ Auth::user()->name }}"
                                class="w-10 h-10 rounded-full border-2 border-primary-500 hover:border-purple-400 transition-all">
                            <div
                                class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-gray-800">
                            </div>
                        </div>
                        <span class="text-gray-300">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-32 mr-4 w-56 origin-top-right glass rounded-xl shadow-lg z-50">
                        <div class="py-2 px-4 space-y-2">
                            <!-- User Info -->
                            <div class="flex items-center space-x-3 space-x-reverse py-2 border-b border-gray-700/30">
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                                    alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-medium text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                                </div>
                            </div>

                            <!-- Dropdown Links -->
                            <a href="{{ route('profile') }}"
                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-all">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                الملف الشخصي
                            </a>
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('home.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-all">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                        </path>
                                    </svg>
                                    لوحة التحكم
                                </a>
                            @endif
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-all">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                الإعدادات
                            </a>
                            <div class="border-t border-gray-700/30 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-lg transition-all">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div>
                    <a href="{{ route('login') }}"
                        class="relative px-8 py-3 rounded-full font-medium overflow-hidden group bg-gradient-to-r from-primary-600 to-purple-600 hover:from-primary-700 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg hover:shadow-2xl">
                        <span class="relative z-10">ابدأ الآن</span>
                        <div class="absolute inset-0 shimmer opacity-0 group-hover:opacity-100"></div>
                    </a>
                </div>
            @endif

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="glass p-2 rounded-lg hover:bg-white/10 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="md:hidden mt-4 glass rounded-xl p-4 space-y-4">
            <a href="#features"
                class="block px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-all">
                المميزات
            </a>
            <a href="#how-it-works"
                class="block px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-all">
                كيف يعمل
            </a>
            <a href="#pricing"
                class="block px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-all">
                الأسعار
            </a>
            <a href="#contact"
                class="block px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-all">
                اتصل بنا
            </a>

            @if (Auth::check())
                <div class="pt-4 border-t border-gray-700/30">
                    <a href="{{ route('profile') }}"
                        class="block px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-all">
                        الملف الشخصي
                    </a>
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('home.dashboard') }}"
                            class="block px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white rounded-lg transition-all">
                            لوحة التحكم
                        </a>
                    @endif

                    <a href="{{ route('logout') }}"
                        class="w-full text-left px-4 py-2 text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-lg transition-all">
                        تسجيل الخروج
                    </a>

                </div>
            @else
                <a href="{{ route('login') }}"
                    class="block w-full text-center px-4 py-2 bg-gradient-to-r from-primary-600 to-purple-600 text-white rounded-lg transition-all hover:from-primary-700 hover:to-purple-700">
                    تسجيل الدخول
                </a>
            @endif
        </div>
    </nav>
</header>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('header', () => ({
            mobileMenuOpen: false
        }))
    });
</script>

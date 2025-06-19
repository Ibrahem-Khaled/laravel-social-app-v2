<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الملف الشخصي - {{ $user->name }}</title>
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

        .avatar-upload {
            position: relative;
            display: inline-block;
        }

        .avatar-upload:hover .avatar-edit {
            opacity: 1;
        }

        .avatar-edit {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .social-input-container {
            transition: all 0.3s ease;
        }

        .social-input-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
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

        function editProfileApp() {
            return {
                activeTab: 'basic',
                socialLinks: @json($user->social_links ?? []),
                newSocialPlatform: '',
                newSocialUrl: '',
                showAvatarOptions: false,
                avatarOptions: [{
                        name: 'رفع صورة',
                        icon: '📤',
                        value: 'upload'
                    },
                    {
                        name: 'تغيير الألوان',
                        icon: '🎨',
                        value: 'colors'
                    },
                    {
                        name: 'إزالة الصورة',
                        icon: '🗑️',
                        value: 'remove'
                    }
                ],
                avatarPreview: '{{ $user->avatar }}',
                gender: '{{ $user->gender ?? 'male' }}',
                language: '{{ $user->language ?? 'ar' }}',
                birthDate: '{{ $user->birth_date ? $user->birth_date->format('Y-m-d') : '' }}',

                init() {
                    // Initialize any required data
                },

                addSocialLink() {
                    if (this.newSocialPlatform && this.newSocialUrl) {
                        this.socialLinks.push({
                            platform: this.newSocialPlatform,
                            url: this.newSocialUrl
                        });
                        this.newSocialPlatform = '';
                        this.newSocialUrl = '';
                    }
                },

                removeSocialLink(index) {
                    this.socialLinks.splice(index, 1);
                },

                handleAvatarAction(action) {
                    if (action === 'upload') {
                        document.getElementById('avatar-upload').click();
                    } else if (action === 'remove') {
                        this.avatarPreview = '';
                        document.getElementById('avatar-remove').value = '1';
                    }
                    this.showAvatarOptions = false;
                },

                previewAvatar(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.avatarPreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                submitForm() {
                    // You can add any pre-submit logic here
                    document.getElementById('profile-form').submit();
                }
            }
        }
    </script>
</head>

<body class="font-tajawal bg-dark-900 text-white overflow-x-hidden gradient-bg" x-data="editProfileApp()">
    <!-- Navigation Bar -->
    @include('components.website.nav-bar')

    <!-- Main Profile Container -->
    <div class="relative z-10 min-h-screen pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="file" id="avatar-upload" name="avatar" class="hidden" @change="previewAvatar">
                <input type="hidden" id="avatar-remove" name="remove_avatar" value="0">

                <!-- Profile Header -->
                <div
                    class="bg-white/5 backdrop-blur-lg rounded-3xl p-8 mb-8 transition-all duration-300 hover:shadow-xl hover:shadow-primary-500/10">
                    <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">

                        <!-- Profile Image -->
                        <div class="relative">
                            <div class="avatar-upload">
                                <div
                                    class="w-40 h-40 rounded-full overflow-hidden border-4 border-primary-500/30 profile-pulse">
                                    <img x-bind:src="avatarPreview ||
                                        'https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random'"
                                        alt="{{ $user->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="avatar-edit" @click="showAvatarOptions = !showAvatarOptions">
                                    <span class="text-white text-xl">✏️</span>
                                </div>
                            </div>

                            <!-- Avatar Options Dropdown -->
                            <div x-show="showAvatarOptions" @click.outside="showAvatarOptions = false"
                                class="absolute z-10 mt-2 w-48 bg-white/20 backdrop-blur-lg rounded-lg shadow-lg overflow-hidden">
                                <template x-for="option in avatarOptions" :key="option.value">
                                    <div @click="handleAvatarAction(option.value)"
                                        class="px-4 py-3 hover:bg-white/10 cursor-pointer flex items-center gap-2">
                                        <span x-text="option.icon"></span>
                                        <span x-text="option.name"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Profile Info -->
                        <div class="flex-1 text-center lg:text-right">
                            <div class="mb-6">
                                <h1 class="text-4xl lg:text-5xl font-bold text-white mb-6">تعديل الملف الشخصي</h1>

                                <!-- Level and Coins -->
                                <div class="flex justify-center lg:justify-start items-center gap-4 mb-6">
                                    @if ($user->current_level !== null)
                                        <div class="px-4 py-2 rounded-lg flex items-center"
                                            style="background-color: {{ $user->current_level->color }};">
                                            <span class="mr-2">✨</span>
                                            <span class="font-bold text-white">
                                                المستوى {{ $user->current_level->level_number }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="px-4 py-2 bg-yellow-600 rounded-lg flex items-center">
                                        <img src="https://cdn-icons-png.flaticon.com/128/9382/9382189.png"
                                            alt="Coin" class="w-6 h-6 ml-2">
                                        <span class="font-bold text-white">{{ $user->coins }}</span>
                                        <span class="text-yellow-200 mr-1">عملة</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-4 justify-center lg:justify-end">
                                <button type="button" @click="submitForm()"
                                    class="bg-gradient-to-r from-primary-500 to-purple-600 hover:from-primary-600 hover:to-purple-700 px-8 py-3 rounded-full font-bold text-white transition-all duration-300 hover:scale-105">
                                    حفظ التغييرات
                                </button>
                                <a href="{{ route('profile') }}"
                                    class="bg-white/10 hover:bg-white/20 px-8 py-3 rounded-full font-bold transition-all duration-300 hover:scale-105">
                                    إلغاء
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-b border-white/10 mb-8">
                    <nav class="flex space-x-8 space-x-reverse">
                        <button type="button" @click="activeTab = 'basic'"
                            class="py-4 px-1 border-b-2 font-medium text-sm"
                            :class="activeTab === 'basic' ? 'border-primary-500 text-primary-400' :
                                'border-transparent text-gray-400 hover:text-white'">
                            المعلومات الأساسية
                        </button>
                        <button type="button" @click="activeTab = 'social'"
                            class="py-4 px-1 border-b-2 font-medium text-sm"
                            :class="activeTab === 'social' ? 'border-primary-500 text-primary-400' :
                                'border-transparent text-gray-400 hover:text-white'">
                            الروابط الاجتماعية
                        </button>
                        <button type="button" @click="activeTab = 'security'"
                            class="py-4 px-1 border-b-2 font-medium text-sm"
                            :class="activeTab === 'security' ? 'border-primary-500 text-primary-400' :
                                'border-transparent text-gray-400 hover:text-white'">
                            الأمان
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="mb-12">
                    <!-- Basic Info Tab -->
                    <div x-show="activeTab === 'basic'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 fade-in-up">
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">الاسم
                                الكامل</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                        </div>

                        <!-- Email -->
                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 fade-in-up">
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">البريد
                                الإلكتروني</label>
                            <input type="email" id="email" name="email"
                                disabled
                                value="{{ old('email', $user->email) }}"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                        </div>

                        <!-- Phone -->
                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 fade-in-up">
                            <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">رقم
                                الهاتف</label>
                            <input type="tel" id="phone" name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                        </div>

                        <!-- Bio -->
                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 md:col-span-2 fade-in-up">
                            <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">السيرة
                                الذاتية</label>
                            <textarea id="bio" name="bio" rows="3"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <!-- Gender & Language -->
                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 fade-in-up">
                            <label class="block text-sm font-medium text-gray-300 mb-2">الجنس</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="male" x-model="gender"
                                        class="form-radio h-5 w-5 text-primary-500">
                                    <span class="mr-2">ذكر</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="female" x-model="gender"
                                        class="form-radio h-5 w-5 text-primary-500">
                                    <span class="mr-2">أنثى</span>
                                </label>
                            </div>
                        </div>

                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 fade-in-up">
                            <label for="language" class="block text-sm font-medium text-gray-300 mb-2">اللغة
                                المفضلة</label>
                            <select id="language" name="language" x-model="language"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                <option value="ar">العربية</option>
                                <option value="en">English</option>
                            </select>
                        </div>

                        <!-- Birth Date -->
                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 fade-in-up">
                            <label for="birth_date" class="block text-sm font-medium text-gray-300 mb-2">تاريخ
                                الميلاد</label>
                            <input type="date" id="birth_date" name="birth_date" x-model="birth_date"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                        </div>

                        <!-- Address & Country -->
                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 fade-in-up">
                            <label for="address" class="block text-sm font-medium text-gray-300 mb-2">العنوان</label>
                            <input type="text" id="address" name="address"
                                value="{{ old('address', $user->address) }}"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                        </div>

                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 fade-in-up">
                            <label for="country" class="block text-sm font-medium text-gray-300 mb-2">البلد</label>
                            <input type="text" id="country" name="country"
                                value="{{ old('country', $user->country) }}"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                        </div>

                        <!-- Website -->
                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 md:col-span-2 fade-in-up">
                            <label for="website" class="block text-sm font-medium text-gray-300 mb-2">الموقع
                                الإلكتروني</label>
                            <input type="url" id="website" name="website"
                                value="{{ old('website', $user->website) }}"
                                class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                placeholder="https://example.com">
                        </div>
                    </div>

                    <!-- Social Links Tab -->
                    <div x-show="activeTab === 'social'" x-transition>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 md:col-span-2 fade-in-up">
                                <h3 class="text-lg font-bold mb-4">إضافة رابط اجتماعي جديد</h3>
                                <div class="flex flex-col md:flex-row gap-4">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-300 mb-2">المنصة</label>
                                        <select x-model="newSocialPlatform"
                                            class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                            <option value="">اختر المنصة</option>
                                            <option value="facebook">Facebook</option>
                                            <option value="twitter">Twitter</option>
                                            <option value="instagram">Instagram</option>
                                            <option value="linkedin">LinkedIn</option>
                                            <option value="youtube">YouTube</option>
                                            <option value="tiktok">TikTok</option>
                                            <option value="snapchat">Snapchat</option>
                                            <option value="whatsapp">WhatsApp</option>
                                            <option value="telegram">Telegram</option>
                                            <option value="other">أخرى</option>
                                        </select>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-300 mb-2">رابط الحساب</label>
                                        <input type="url" x-model="newSocialUrl"
                                            class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                            placeholder="https://">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" @click="addSocialLink()"
                                            class="bg-primary-500 hover:bg-primary-600 px-6 py-3 rounded-lg font-bold transition-all duration-300">
                                            إضافة
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Current Social Links -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <template x-for="(link, index) in socialLinks" :key="index">
                                <div
                                    class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 social-input-container fade-in-up">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-sm font-medium text-gray-300 capitalize"
                                            x-text="link.platform"></span>
                                        <button type="button" @click="removeSocialLink(index)"
                                            class="text-red-400 hover:text-red-300">
                                            ✕
                                        </button>
                                    </div>
                                    <input type="hidden" x-bind:name="'social_links[' + index + '][platform]'"
                                        x-bind:value="link.platform">
                                    <input type="url" x-bind:name="'social_links[' + index + '][url]'"
                                        x-bind:value="link.url"
                                        class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div x-show="activeTab === 'security'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password Update -->
                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 md:col-span-2 fade-in-up">
                            <h3 class="text-lg font-bold mb-4">تغيير كلمة المرور</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password"
                                        class="block text-sm font-medium text-gray-300 mb-2">كلمة المرور
                                        الحالية</label>
                                    <input type="password" id="current_password" name="current_password"
                                        class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="password"
                                            class="block text-sm font-medium text-gray-300 mb-2">كلمة المرور
                                            الجديدة</label>
                                        <input type="password" id="password" name="password"
                                            class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                    </div>
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-300 mb-2">تأكيد كلمة
                                            المرور</label>
                                        <input type="password" id="password_confirmation"
                                            name="password_confirmation"
                                            class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Deletion -->
                        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-6 md:col-span-2 fade-in-up">
                            <h3 class="text-lg font-bold mb-4 text-red-400">حذف الحساب</h3>
                            <p class="text-gray-400 mb-4">بمجرد حذف حسابك ، سيتم فقدان جميع موارده وبياناته إلى الأبد.
                                قبل حذف حسابك ، يرجى تنزيل أي بيانات أو معلومات ترغب في الاحتفاظ بها.</p>
                            <button type="button" @click="confirmDelete = true"
                                class="bg-red-500/20 hover:bg-red-500/30 border border-red-500 text-red-400 px-6 py-3 rounded-lg font-bold transition-all duration-300">
                                حذف الحساب
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="confirmDelete"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 max-w-md w-full mx-4 border border-white/20">
            <h3 class="text-2xl font-bold mb-4 text-red-400">تأكيد حذف الحساب</h3>
            <p class="text-gray-300 mb-6">هل أنت متأكد أنك تريد حذف حسابك؟ لا يمكن التراجع عن هذا الإجراء.</p>
            <div class="flex justify-end gap-4">
                <button @click="confirmDelete = false"
                    class="bg-white/10 hover:bg-white/20 px-6 py-2 rounded-lg font-bold transition-all duration-300">
                    إلغاء
                </button>
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 px-6 py-2 rounded-lg font-bold transition-all duration-300">
                        نعم، احذف الحساب
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('components.website.footer')
</body>

</html>

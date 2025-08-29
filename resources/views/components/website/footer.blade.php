<footer id="contact" class="bg-gray-900 pt-20 pb-10 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

            <div>
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold">{{ $websiteData->name ?? 'اسم الموقع' }}</span>
                </div>
                <p class="text-gray-400 mb-4">
                    منصة متكاملة للتواصل الصوتي والبث المباشر مع أصدقائك ومجتمعك.
                </p>
                <div class="social-icons flex space-x-4">
                    @if (!empty($settings['facebook_url']->value))
                        <a href="{{ $settings['facebook_url']->value }}" target="_blank"
                            class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if (!empty($settings['twitter_url']->value))
                        <a href="{{ $settings['twitter_url']->value }}" target="_blank"
                            class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if (!empty($settings['instagram_url']->value))
                        <a href="{{ $settings['instagram_url']->value }}" target="_blank"
                            class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if (!empty($settings['linkedin_url']->value))
                        <a href="{{ $settings['linkedin_url']->value }}" target="_blank"
                            class="text-gray-400 hover:text-white transition"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                    @if (!empty($settings['youtube_url']->value))
                        <a href="{{ $settings['youtube_url']->value }}" target="_blank"
                            class="text-gray-400 hover:text-white transition"><i class="fab fa-youtube"></i></a>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">روابط سريعة</h3>
                <ul class="space-y-2">
                    <li><a href="#features" class="text-gray-400 hover:text-white transition">المميزات</a></li>
                    <li><a href="#how-it-works" class="text-gray-400 hover:text-white transition">كيف يعمل</a></li>
                    <li><a href="#pricing" class="text-gray-400 hover:text-white transition">الأسعار</a></li>
                    <li><a href="#demo" class="text-gray-400 hover:text-white transition">عرض توضيحي</a></li>
                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">تسجيل
                            الدخول</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">الشركة</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white transition">عن الشركة</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">الوظائف</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">المدونة</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">الشروط والأحكام</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">سياسة الخصوصية</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">اتصل بنا</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mt-1 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-gray-400">{{ $websiteData->email ?? 'email@example.com' }}</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mt-1 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-gray-400">{{ $websiteData->phone ?? '0123456789' }}</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mt-1 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-gray-400">{{ $websiteData->address ?? 'المملكة العربية السعودية' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12">
            <div
                class="bg-gray-800 rounded-xl shadow-lg p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8">

                <div class="text-center md:text-right">
                    <h3 class="text-3xl font-bold text-white mb-2">
                        انضم لمجتمعنا وحمّل التطبيق الآن!
                    </h3>
                    <p class="text-gray-400 mb-6 max-w-lg">
                        تجربة تواصل صوتي فريدة بانتظارك. دردش، استمع، وشارك لحظاتك مباشرةً من جوالك.
                    </p>
                    <div class="flex justify-center md:justify-start gap-4">
                        @if (!empty($settings['ios_app_url']->value))
                            <a href="{{ $settings['ios_app_url']->value }}" target="_blank"
                                class="bg-gray-900 hover:bg-black text-white py-2 px-4 rounded-lg flex items-center transition duration-300">
                                <i class="fab fa-apple text-2xl ml-3"></i>
                                <div>
                                    <span class="text-xs block">Available on the</span>
                                    <span class="text-base font-semibold">App Store</span>
                                </div>
                            </a>
                        @endif
                        @if (!empty($settings['android_app_url']->value))
                            <a href="{{ $settings['android_app_url']->value }}" target="_blank"
                                class="bg-gray-900 hover:bg-black text-white py-2 px-4 rounded-lg flex items-center transition duration-300">
                                <i class="fab fa-google-play text-2xl ml-3"></i>
                                <div>
                                    <span class="text-xs block">GET IT ON</span>
                                    <span class="text-base font-semibold">Google Play</span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <div class="bg-white p-3 rounded-lg shadow-md">
                        {{-- This will generate a QR code for your website's main URL. You can change it to a specific app link. --}}
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ url('/') }}"
                            alt="QR Code" class="w-36 h-36">
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <p class="text-gray-500 text-sm">
                    <i class="fas fa-users ml-1"></i>
                    عدد الزوار: {{ $settings['visitor_counter']->value ?? '0' }}
                </p>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">© {{ date('Y') }} {{ $websiteData->name ?? 'اسم الموقع' }}. جميع
                الحقوق محفوظة.</p>
            <div class="flex space-x-6 space-x-reverse mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-white transition text-sm">الشروط والأحكام</a>
                <a href="#" class="text-gray-400 hover:text-white transition text-sm">سياسة الخصوصية</a>
                <a href="#" class="text-gray-400 hover:text-white transition text-sm">ملفات تعريف الارتباط</a>
            </div>
        </div>
    </div>
</footer>

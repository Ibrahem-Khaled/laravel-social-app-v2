  <!-- Footer -->
  <footer id="contact" class="bg-gray-900 pt-20 pb-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
              <div>
                  <div class="flex items-center mb-4">
                      <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                              viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                          </svg>
                      </div>
                      <span class="mr-3 text-xl font-bold">{{ $websiteData->name }}</span>
                  </div>
                  <p class="text-gray-400 mb-4">
                      منصة متكاملة للتواصل الصوتي والبث المباشر مع أصدقائك ومجتمعك.
                  </p>
                  <div class="flex space-x-4 space-x-reverse">
                      @php
                          $socialLinks = json_decode($websiteData->social_links ?? '{}', true);
                      @endphp

                      @if (isset($socialLinks['facebook']))
                          <a href="{{ $socialLinks['facebook'] }}" target="_blank"
                              class="text-gray-400 hover:text-white transition">
                              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                  <path
                                      d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z">
                                  </path>
                              </svg>
                          </a>
                      @endif

                      @if (isset($socialLinks['twitter']))
                          <a href="{{ $socialLinks['twitter'] }}" target="_blank"
                              class="text-gray-400 hover:text-white transition">
                              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                  <path
                                      d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                                  </path>
                              </svg>
                          </a>
                      @endif

                      @if (isset($socialLinks['instagram']))
                          <a href="{{ $socialLinks['instagram'] }}" target="_blank"
                              class="text-gray-400 hover:text-white transition">
                              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                  <path
                                      d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z">
                                  </path>
                              </svg>
                          </a>
                      @endif

                      @if (isset($socialLinks['snapchat']))
                          <a href="{{ $socialLinks['snapchat'] }}" target="_blank"
                              class="text-gray-400 hover:text-white transition">
                              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                  <path
                                      d="M12 0C5.373 0 0 5.373 0 12a11.996 11.996 0 0016.13 11.357c.3-.054.394-.427.157-.621a6.466 6.466 0 01-2.119-2.947c-.137-.35-.574-.467-.885-.237a7.997 7.997 0 01-2.87 1.32c-1.06.277-2.188-.48-2.365-1.59a1.602 1.602 0 00-.704-1.036c-.418-.262-.604-.794-.476-1.276a6.36 6.36 0 01.554-1.426c.206-.374-.044-.842-.478-.842H4.7a.483.483 0 01-.48-.54c.256-2.44 1.9-5.697 4.893-7.195C10.81 4.07 13.755 4.087 16 5.857c2.068 1.624 3.346 4.55 3.45 6.943.01.236-.202.427-.44.4h-1.294c-.494 0-.73.607-.416.973.363.425.625.902.77 1.42.166.598-.061 1.266-.552 1.588a1.49 1.49 0 00-.682.932c-.18.977-.93 1.72-1.886 1.56a8.23 8.23 0 01-2.838-1.345c-.309-.23-.738-.114-.878.236a6.576 6.576 0 01-2.183 2.926c-.238.194-.145.566.153.62A12 12 0 1024 12c0-6.627-5.373-12-12-12z">
                                  </path>
                              </svg>
                          </a>
                      @endif

                      @if (isset($socialLinks['whatsapp']))
                          <a href="{{ $socialLinks['whatsapp'] }}" target="_blank"
                              class="text-gray-400 hover:text-white transition">
                              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 448 512">
                                  <path
                                      d="M380.9 97.1C339-18.2 239.3-33.8 166.1 13.5 120.3 42.8 93.4 89.2 93.4 140.5c0 31.6 9.1 62.1 26.3 88.6L76.1 413.3l185.8-43.7c23.7 8.4 49.2 12.8 75 12.8 117.4 0 213-95.6 213-213C550.9 201.5 473.4 106.5 380.9 97.1zm-16.5 278c-22.4 10.1-48.1 16-74.3 16-20.6 0-41.1-3.4-60.5-10L137 423.3l30.1-99.1c-27.2-33.3-42.3-75-42.3-118.6 0-90.9 74-164.9 164.9-164.9s164.9 74 164.9 164.9c.1 90.8-74 164.8-164.9 164.8zM201.4 175.6c-2.7-6.3-5.2-6.4-7.6-6.5-2-.1-4.3-.1-6.6-.1s-6.1.9-9.3 4.3c-3.2 3.3-12.2 12-12.2 29.2s12.5 33.9 14.2 36.3c1.8 2.4 24.1 38.5 59.2 52.5 8.2 3.2 14.6 5.1 19.6 6.5 8.2 2.3 15.6 2 21.4 1.3 6.5-.8 20-8.2 22.8-16.1 2.8-7.9 2.8-14.7 2-16.1-.8-1.3-3-2-6.3-3.5s-20-9.9-23-11c-3-.9-5.1-1.3-7.2 1.3s-8.3 11.2-10.2 13.5c-1.9 2.3-3.7 2.5-6.9.9-3.3-1.6-13.9-5.1-26.4-16.3-9.7-8.7-16.2-19.4-18.1-22.6-1.9-3.3-.2-5 1.5-6.6 1.6-1.6 3.6-4.2 5.5-6.3 1.8-2.1 2.4-3.3 3.6-5.5 1.2-2.3.6-4.4-.4-6.1-1.1-1.7-10.1-25-13.4-32.5z">
                                  </path>
                              </svg>
                          </a>
                      @endif


                      <!-- يمكنك إضافة المزيد من الشبكات هنا -->
                  </div>
              </div>
              <div>
                  <h3 class="text-lg font-bold mb-4">روابط سريعة</h3>
                  <ul class="space-y-2">
                      <li><a href="#features" class="text-gray-400 hover:text-white transition">المميزات</a></li>
                      <li><a href="#how-it-works" class="text-gray-400 hover:text-white transition">كيف يعمل</a>
                      </li>
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
                      <li><a href="#" class="text-gray-400 hover:text-white transition">الشروط والأحكام</a>
                      </li>
                      <li><a href="#" class="text-gray-400 hover:text-white transition">سياسة الخصوصية</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h3 class="text-lg font-bold mb-4">اتصل بنا</h3>
                  <ul class="space-y-2">
                      <li class="flex items-start">
                          <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24"
                              stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                          </svg>
                          <span class="text-gray-400">{{ $websiteData->email }}</span>
                      </li>
                      <li class="flex items-start">
                          <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24"
                              stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                          </svg>
                          <span class="text-gray-400">{{ $websiteData->phone ?? '0123456789' }}</span>
                      </li>
                      <li class="flex items-start">
                          <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24"
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
          <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
              <p class="text-gray-400">© {{ date('Y') }} {{ $websiteData->name }}. جميع الحقوق محفوظة.</p>
              <div class="flex space-x-6 space-x-reverse mt-4 md:mt-0">
                  <a href="#" class="text-gray-400 hover:text-white transition">الشروط والأحكام</a>
                  <a href="#" class="text-gray-400 hover:text-white transition">سياسة الخصوصية</a>
                  <a href="#" class="text-gray-400 hover:text-white transition">ملفات تعريف الارتباط</a>
              </div>
          </div>
      </div>
  </footer>

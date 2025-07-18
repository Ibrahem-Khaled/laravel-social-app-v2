<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--  مهم جداً: إضافة توكن الحماية الخاص بلارافيل -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تأكيد حذف الحساب - تواصل</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24, #ff3838);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: rgba(255, 107, 107, 0.3);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 0.6; }
        }

        .shake:hover {
            animation: shake 0.5s infinite;
        }

        @keyframes shake {
            0% { transform: translate(1px, 1px) rotate(0deg); }
            10% { transform: translate(-1px, -2px) rotate(-1deg); }
            20% { transform: translate(-3px, 0px) rotate(1deg); }
            30% { transform: translate(3px, 2px) rotate(0deg); }
            40% { transform: translate(1px, -1px) rotate(1deg); }
            50% { transform: translate(-1px, 2px) rotate(-1deg); }
            60% { transform: translate(-3px, 1px) rotate(0deg); }
            70% { transform: translate(3px, 1px) rotate(-1deg); }
            80% { transform: translate(-1px, -1px) rotate(1deg); }
            90% { transform: translate(1px, 2px) rotate(0deg); }
            100% { transform: translate(1px, -2px) rotate(-1deg); }
        }

        .modal {
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .pulse-warning {
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0%, 100% { box-shadow: 0 0 20px rgba(255, 107, 107, 0.4); }
            50% { box-shadow: 0 0 40px rgba(255, 107, 107, 0.8); }
        }

        .app-logo {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .typing-effect {
            border-right: 2px solid #667eea;
            animation: typing 3s steps(30) infinite;
        }

        @keyframes typing {
            0%, 100% { border-color: transparent; }
            50% { border-color: #667eea; }
        }
    </style>
</head>

<body class="gradient-bg min-h-screen relative">

    <!-- Floating particles background -->
    <div class="floating-particles">
        <div class="particle" style="left: 10%; top: 20%; width: 4px; height: 4px; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; top: 80%; width: 6px; height: 6px; animation-delay: 1s;"></div>
        <div class="particle" style="left: 60%; top: 30%; width: 3px; height: 3px; animation-delay: 2s;"></div>
        <div class="particle" style="left: 80%; top: 70%; width: 5px; height: 5px; animation-delay: 3s;"></div>
        <div class="particle" style="left: 30%; top: 10%; width: 4px; height: 4px; animation-delay: 4s;"></div>
        <div class="particle" style="left: 70%; top: 90%; width: 6px; height: 6px; animation-delay: 0.5s;"></div>
    </div>

    <!-- App Header -->
    <div class="container mx-auto p-4 max-w-2xl pt-8">
        <div class="glass-effect rounded-3xl p-6 mb-6 text-center shadow-2xl">
            <!-- App Logo -->
            <div class="flex items-center justify-center mb-4">
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 p-4 rounded-2xl shadow-lg transform hover:rotate-12 transition-transform duration-300">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="mr-4">
                    <h1 class="app-logo text-3xl font-black mb-1">تواصل</h1>
                    <p class="text-gray-600 text-sm typing-effect">منصة التواصل الاجتماعي الذكية</p>
                </div>
            </div>

            <!-- App Info -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-4 mb-4">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-blue-600">50K+</div>
                        <div class="text-xs text-gray-600">مستخدم نشط</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">2M+</div>
                        <div class="text-xs text-gray-600">رسالة يومية</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-600">99.9%</div>
                        <div class="text-xs text-gray-600">وقت التشغيل</div>
                    </div>
                </div>
            </div>

            <p class="text-gray-700 text-sm">
                <span class="font-semibold">تواصل</span> - المكان الآمن للتواصل مع الأصدقاء والعائلة، مع تقنيات حماية متقدمة وتجربة مستخدم استثنائية.
            </p>
        </div>

        <!-- Main deletion form -->
        <div class="glass-effect rounded-3xl shadow-2xl p-8 text-center pulse-warning relative overflow-hidden">

            <!-- Warning decoration -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-400 via-red-500 to-red-600"></div>

            <div class="flex justify-center mb-6">
                <div class="bg-red-100 p-4 rounded-full">
                    <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-black bg-gradient-to-r from-red-600 to-red-800 bg-clip-text text-transparent mb-6">
                انتبه: أنت على وشك حذف حسابك!
            </h1>

            <div class="bg-gradient-to-r from-orange-50 to-red-50 border-2 border-red-200 rounded-2xl p-6 mb-8">
                <p class="text-lg text-gray-800 mb-4 font-semibold">
                    هذه الخطوة **نهائية** ولا يمكن التراجع عنها. بمجرد الضغط على زر الحذف، ستفقد:
                </p>

                <div class="grid md:grid-cols-2 gap-4 text-right">
                    <div class="bg-white rounded-xl p-4 shadow-sm">
                        <div class="flex items-center mb-2">
                            <span class="text-2xl ml-3">👤</span>
                            <span class="font-bold text-red-700">البيانات الشخصية</span>
                        </div>
                        <p class="text-sm text-gray-600">الاسم، الصورة، المعلومات الشخصية</p>
                    </div>

                    <div class="bg-white rounded-xl p-4 shadow-sm">
                        <div class="flex items-center mb-2">
                            <span class="text-2xl ml-3">💬</span>
                            <span class="font-bold text-red-700">المحادثات والرسائل</span>
                        </div>
                        <p class="text-sm text-gray-600">جميع الرسائل والمحادثات السابقة</p>
                    </div>

                    <div class="bg-white rounded-xl p-4 shadow-sm">
                        <div class="flex items-center mb-2">
                            <span class="text-2xl ml-3">🎯</span>
                            <span class="font-bold text-red-700">النقاط والإنجازات</span>
                        </div>
                        <p class="text-sm text-gray-600">كل النقاط والمستويات التي حققتها</p>
                    </div>

                    <div class="bg-white rounded-xl p-4 shadow-sm">
                        <div class="flex items-center mb-2">
                            <span class="text-2xl ml-3">🔗</span>
                            <span class="font-bold text-red-700">الروابط والصداقات</span>
                        </div>
                        <p class="text-sm text-gray-600">شبكة الأصدقاء والمتابعين</p>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label for="confirmation" class="block text-xl font-bold text-gray-800 mb-4">
                    لتأكيد فهمك للعواقب، اكتب الجملة التالية:
                </label>
                <div class="bg-gradient-to-r from-blue-100 to-purple-100 rounded-xl p-4 mb-4">
                    <p id="phraseToType" class="text-lg font-mono text-blue-800 font-bold select-all">
                        أنا موافق على حذف حسابي نهائياً
                    </p>
                </div>
                <input type="text" id="confirmationInput"
                    class="w-full p-4 border-3 border-gray-300 rounded-xl text-center text-lg font-semibold focus:border-red-500 focus:ring-4 focus:ring-red-200 transition-all duration-300"
                    placeholder="اكتب الجملة هنا بدقة...">
            </div>

            <button id="deleteButton"
                class="w-full p-6 bg-gradient-to-r from-red-600 to-red-800 text-white text-xl font-black rounded-2xl shadow-2xl transform hover:scale-105 transition-all duration-300 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed disabled:scale-100 shake relative overflow-hidden"
                disabled>
                <span class="relative z-10">🗑️ امسح كل شيء واحذف الحساب للأبد</span>
                <div class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-900 transform scale-x-0 hover:scale-x-100 transition-transform duration-300 origin-left"></div>
            </button>
        </div>

        <div class="text-center mt-8">
            <div class="glass-effect rounded-2xl p-4 inline-block">
                <p class="text-gray-700 flex items-center justify-center">
                    <span class="text-2xl ml-2">💡</span>
                    إذا غيرت رأيك، يمكنك ببساطة إغلاق هذه الصفحة. لن يحدث أي شيء.
                </p>
            </div>
        </div>
    </div>

    <!-- Final confirmation modal -->
    <div id="finalConfirmationModal"
        class="modal fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none">
        <div class="glass-effect rounded-3xl shadow-2xl p-8 max-w-md text-center transform scale-90 transition-all duration-300 border-4 border-red-500">

            <div class="bg-red-100 rounded-full p-4 inline-block mb-6">
                <svg class="w-12 h-12 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>

            <h2 class="text-3xl font-black text-red-700 mb-4">التحذير الأخير!</h2>
            <p class="text-lg text-gray-800 mb-2">
                هذا هو آخر فرصة للتراجع
            </p>
            <p class="text-sm text-red-600 font-semibold mb-8">
                بعد هذه الخطوة لا يوجد رجوع أبداً 🚫
            </p>

            <div class="flex justify-center gap-4">
                <button id="cancelDelete"
                    class="py-4 px-8 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg transform hover:scale-105">
                    <span class="flex items-center">
                        <span class="text-lg ml-2">✅</span>
                        لا، أريد الاحتفاظ بحسابي
                    </span>
                </button>
                <button id="confirmDelete"
                    class="py-4 px-8 bg-gradient-to-r from-red-600 to-red-800 text-white font-bold rounded-xl hover:from-red-700 hover:to-red-900 transition-all duration-300 shadow-lg transform hover:scale-105">
                    <span class="flex items-center">
                        <span class="text-lg ml-2">🗑️</span>
                        نعم، احذف نهائياً
                    </span>
                </button>
            </div>
        </div>
    </div>

    <script>
        const phraseToType = document.getElementById('phraseToType').textContent.trim();
        const confirmationInput = document.getElementById('confirmationInput');
        const deleteButton = document.getElementById('deleteButton');
        const finalConfirmationModal = document.getElementById('finalConfirmationModal');
        const modalContent = finalConfirmationModal.querySelector('div');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');

        // تفعيل زر الحذف عند كتابة الجملة الصحيحة
        confirmationInput.addEventListener('input', () => {
            const isMatching = confirmationInput.value.trim() === phraseToType;
            deleteButton.disabled = !isMatching;

            if (isMatching) {
                confirmationInput.classList.add('border-green-500', 'bg-green-50');
                confirmationInput.classList.remove('border-red-500', 'bg-red-50');
            } else if (confirmationInput.value.trim() !== '') {
                confirmationInput.classList.add('border-red-500', 'bg-red-50');
                confirmationInput.classList.remove('border-green-500', 'bg-green-50');
            } else {
                confirmationInput.classList.remove('border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50');
            }
        });

        // عرض النافذة المنبثقة للتأكيد النهائي
        deleteButton.addEventListener('click', () => {
            if (!deleteButton.disabled) {
                finalConfirmationModal.classList.remove('opacity-0', 'pointer-events-none');
                modalContent.classList.remove('scale-90');
                modalContent.classList.add('scale-100');
            }
        });

        // إغلاق النافذة المنبثقة
        function closeModal() {
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-90');
            setTimeout(() => {
                finalConfirmationModal.classList.add('opacity-0', 'pointer-events-none');
            }, 200);
        }

        cancelDelete.addEventListener('click', closeModal);

        // تنفيذ حذف الحساب مع Laravel
        confirmDelete.addEventListener('click', () => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const originalButtonText = confirmDelete.innerHTML;

            // عرض حالة التحميل
            confirmDelete.disabled = true;
            confirmDelete.innerHTML = `
                <div class="flex items-center justify-center">
                    <svg class="animate-spin h-5 w-5 text-white ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    جاري الحذف...
                </div>
            `;

            // إرسال طلب الحذف إلى راوت لارافيل
            fetch("{{ route('profile.destroy') }}", {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('فشل حذف الحساب. يرجى المحاولة مرة أخرى.');
                })
                .then(data => {
                    // عرض رسالة النجاح مع تأثيرات بصرية
                    document.body.innerHTML = `
                    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-green-400 to-blue-500 text-center p-4 relative overflow-hidden">

                        <!-- Celebratory particles -->
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="absolute animate-bounce" style="left: 10%; top: 20%; animation-delay: 0s;">✨</div>
                            <div class="absolute animate-bounce" style="left: 80%; top: 30%; animation-delay: 0.5s;">🎉</div>
                            <div class="absolute animate-bounce" style="left: 20%; top: 70%; animation-delay: 1s;">⭐</div>
                            <div class="absolute animate-bounce" style="left: 70%; top: 80%; animation-delay: 1.5s;">🌟</div>
                        </div>

                        <div class="bg-white bg-opacity-95 backdrop-blur-lg rounded-3xl p-12 shadow-2xl max-w-2xl relative z-10">
                            <div class="text-6xl mb-6">✅</div>
                            <h1 class="text-4xl md:text-5xl font-black text-green-600 mb-6">تم حذف حسابك بنجاح</h1>
                            <div class="bg-gradient-to-r from-blue-50 to-green-50 rounded-2xl p-6 mb-6">
                                <h2 class="text-2xl font-bold text-gray-800 mb-4">شكراً لك على الوقت الذي قضيته معنا</h2>
                                <p class="text-lg text-gray-700 mb-4">لقد تم حذف جميع بياناتك بأمان وفقاً لسياسة الخصوصية</p>
                                <div class="flex items-center justify-center text-sm text-gray-600">
                                    <span class="text-lg ml-2">🔒</span>
                                    تم التخلص من البيانات بشكل آمن ونهائي
                                </div>
                            </div>
                            <p class="text-xl text-gray-700 mb-6">نأسف لرحيلك ونأمل أن نراك مرة أخرى في المستقبل</p>
                            <div class="text-6xl mb-4">👋</div>
                            <p class="text-lg text-gray-600">أبواب <strong class="text-blue-600">تواصل</strong> مفتوحة لك دائماً</p>
                        </div>
                    </div>
                `;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('حدث خطأ أثناء محاولة حذف الحساب. يرجى المحاولة لاحقاً.');
                    confirmDelete.disabled = false;
                    confirmDelete.innerHTML = originalButtonText;
                    closeModal();
                });
        });

        // إضافة تأثيرات بصرية للخلفية
        function createParticle() {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.width = (Math.random() * 6 + 2) + 'px';
            particle.style.height = particle.style.width;
            particle.style.animationDelay = Math.random() * 6 + 's';
            document.querySelector('.floating-particles').appendChild(particle);

            setTimeout(() => {
                particle.remove();
            }, 6000);
        }

        // إنشاء جسيمات متحركة كل ثانيتين
        setInterval(createParticle, 2000);
    </script>

</body>

</html>

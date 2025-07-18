<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--  مهم جداً: إضافة توكن الحماية الخاص بلارافيل -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تأكيد حذف الحساب</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        .shake:hover {
            animation: shake 0.5s;
            animation-iteration-count: infinite;
        }

        @keyframes shake {
            0% {
                transform: translate(1px, 1px) rotate(0deg);
            }

            10% {
                transform: translate(-1px, -2px) rotate(-1deg);
            }

            20% {
                transform: translate(-3px, 0px) rotate(1deg);
            }

            30% {
                transform: translate(3px, 2px) rotate(0deg);
            }

            40% {
                transform: translate(1px, -1px) rotate(1deg);
            }

            50% {
                transform: translate(-1px, 2px) rotate(-1deg);
            }

            60% {
                transform: translate(-3px, 1px) rotate(0deg);
            }

            70% {
                transform: translate(3px, 1px) rotate(-1deg);
            }

            80% {
                transform: translate(-1px, -1px) rotate(1deg);
            }

            90% {
                transform: translate(1px, 2px) rotate(0deg);
            }

            100% {
                transform: translate(1px, -2px) rotate(-1deg);
            }
        }

        .modal {
            transition: opacity 0.25s ease;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-4 md:p-8 max-w-2xl mt-10">

        <div class="bg-white border-4 border-red-500 rounded-2xl shadow-2xl p-6 md:p-10 text-center">

            <div class="flex justify-center mb-4">
                <svg class="w-24 h-24 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>

            <h1 class="text-3xl md:text-5xl font-black text-red-700 mb-4">
                انتبه: أنت على وشك حذف حسابك!
            </h1>

            <p class="text-lg text-gray-700 mb-6">
                هذه الخطوة **نهائية** ولا يمكن التراجع عنها. لو ضغطت على زر الحذف، كل شيء سيختفي للأبد.
            </p>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-right mb-8">
                <h2 class="text-xl font-bold text-red-800 mb-3">ستفقد كل هذه الأشياء بشكل دائم:</h2>
                <ul class="space-y-3">
                    <li class="flex items-center"><span class="text-red-500 ml-3">❌</span><span>كل بياناتك الشخصية
                            (الاسم، الصورة، ...إلخ).</span></li>
                    <li class="flex items-center"><span class="text-red-500 ml-3">❌</span><span>كل المحادثات والرسائل
                            والمنشورات.</span></li>
                    <li class="flex items-center"><span class="text-red-500 ml-3">❌</span><span>أي اشتراكات أو نقاط أو
                            عملات لديك.</span></li>
                    <li class="flex items-center"><span class="text-red-500 ml-3">❌</span><span>أي تقدم في الألعاب أو
                            المراحل التي وصلتها.</span></li>
                </ul>
            </div>

            <div class="mb-8">
                <label for="confirmation" class="block text-lg font-bold text-gray-800 mb-2">لتأكيد أنك تفهم، اكتب
                    الجملة التالية في المربع:</label>
                <p id="phraseToType" class="text-lg font-mono bg-gray-200 text-blue-700 p-2 rounded-md mb-3 select-all">
                    أنا موافق على حذف حسابي نهائياً</p>
                <input type="text" id="confirmationInput"
                    class="w-full p-3 border-2 border-gray-300 rounded-lg text-center text-lg focus:border-red-500 focus:ring-red-500"
                    placeholder="اكتب الجملة هنا...">
            </div>

            <button id="deleteButton"
                class="w-full p-5 bg-red-700 text-white text-2xl font-black rounded-xl shadow-lg transform hover:scale-105 transition-transform duration-300 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:scale-100 shake"
                disabled>
                امسح كل شيء واحذف الحساب للأبد
            </button>
        </div>

        <p class="text-center text-gray-500 mt-6">
            إذا غيرت رأيك، يمكنك ببساطة إغلاق هذه الصفحة. لن يحدث أي شيء.
        </p>
    </div>

    <div id="finalConfirmationModal"
        class="modal fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none">
        <div
            class="bg-white rounded-2xl shadow-2xl p-8 max-w-md text-center transform scale-95 transition-transform duration-300">
            <h2 class="text-3xl font-black text-red-700 mb-4">متأكد بجد؟</h2>
            <p class="text-lg text-gray-800 mb-8">
                هذا هو التحذير الأخير. بعد هذه الخطوة لا يوجد رجوع.
            </p>
            <div class="flex justify-center gap-4">
                <button id="cancelDelete"
                    class="py-3 px-8 bg-gray-300 text-gray-800 font-bold rounded-lg hover:bg-gray-400 transition-colors">
                    لا، تراجع!
                </button>
                <button id="confirmDelete"
                    class="py-3 px-8 bg-red-600 text-white font-bold rounded-lg hover:bg-red-800 transition-colors">
                    نعم، احذف الآن
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

        confirmationInput.addEventListener('input', () => {
            deleteButton.disabled = confirmationInput.value.trim() !== phraseToType;
        });

        deleteButton.addEventListener('click', () => {
            if (!deleteButton.disabled) {
                finalConfirmationModal.classList.remove('opacity-0', 'pointer-events-none');
                modalContent.classList.remove('scale-95');
            }
        });

        function closeModal() {
            modalContent.classList.add('scale-95');
            finalConfirmationModal.classList.add('opacity-0', 'pointer-events-none');
        }

        cancelDelete.addEventListener('click', closeModal);

        // ---  ✨ التعديل الأساسي هنا ✨ ---
        confirmDelete.addEventListener('click', () => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const originalButtonText = confirmDelete.innerHTML;

            // عرض حالة التحميل للمستخدم
            confirmDelete.disabled = true;
            confirmDelete.innerHTML =
                `<svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

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
                        return response.json(); // أو .text() إذا كان الرد نصياً
                    }
                    // إذا فشل الطلب، اعرض الخطأ
                    throw new Error('فشل حذف الحساب. يرجى المحاولة مرة أخرى.');
                })
                .then(data => {
                    // في حالة النجاح، اعرض رسالة للمستخدم
                    document.body.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-screen bg-gray-100 text-center p-4">
                        <h1 class="text-4xl font-black text-green-600 mb-4">تم حذف حسابك بنجاح</h1>
                        <p class="text-lg text-gray-700">نأسف لرحيلك. نأمل أن نراك مرة أخرى في المستقبل.</p>
                    </div>
                `;
                })
                .catch(error => {
                    console.error('Error:', error);
                    // في حالة حدوث خطأ، أرجع الزر لحالته الطبيعية وأغلق النافذة
                    alert('حدث خطأ أثناء محاولة حذف الحساب. يرجى المحاولة لاحقاً.');
                    confirmDelete.disabled = false;
                    confirmDelete.innerHTML = originalButtonText;
                    closeModal();
                });
        });
    </script>

</body>

</html>

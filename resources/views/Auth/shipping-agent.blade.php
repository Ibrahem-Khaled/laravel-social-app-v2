<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل وكيل الشحن</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            direction: rtl;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .form-container {
            padding: 40px;
        }

        .form-section {
            margin-bottom: 40px;
            padding: 30px;
            background: linear-gradient(145deg, #f8f9ff, #e8ecf7);
            border-radius: 20px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 20px 20px 0 0;
        }

        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }

        .section-title {
            font-size: 1.5rem;
            color: #2d3748;
            margin-bottom: 25px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
            display: inline-block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .form-group {
            position: relative;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .form-control:hover {
            border-color: #cbd5e0;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
        }

        .required {
            color: #e53e3e;
        }

        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 2px dashed #cbd5e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(145deg, #f7fafc, #edf2f7);
            min-height: 80px;
        }

        .file-upload-label:hover {
            border-color: #667eea;
            background: linear-gradient(145deg, #edf2f7, #e2e8f0);
        }

        .radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .radio-item {
            position: relative;
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: white;
        }

        .radio-item:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .radio-item input[type="radio"] {
            margin-left: 10px;
            accent-color: #667eea;
        }

        .radio-item input[type="radio"]:checked+span {
            color: #667eea;
            font-weight: 600;
        }

        .map-container {
            height: 300px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: linear-gradient(45deg, #f0f2f5, #e8ecf0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #718096;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .map-container:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .date-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 150px;
            gap: 15px;
            align-items: end;
        }

        .calendar-type {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 30px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 16px;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .form-container {
                padding: 20px;
            }

            .form-section {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .radio-group {
                flex-direction: column;
            }

            .date-container {
                grid-template-columns: 1fr;
            }
        }

        .tooltip {
            position: relative;
            display: inline-block;
            margin-right: 5px;
            color: #667eea;
            cursor: help;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #2d3748;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>تسجيل وكيل الشحن</h1>
            <p>املأ البيانات المطلوبة لإتمام عملية التسجيل</p>
        </div>

        <div class="form-container">
            <form id="registrationForm">
                <!-- نوع الكيان -->
                <div class="form-section">
                    <h3 class="section-title">نوع الكيان</h3>
                    <div class="form-group">
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="individual" name="entityType" value="individual" required>
                                <span>فردي</span>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="company" name="entityType" value="company" required>
                                <span>شركة</span>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="establishment" name="entityType" value="establishment"
                                    required>
                                <span>مؤسسة</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بيانات الأفراد -->
                <div class="form-section" id="individualSection">
                    <h3 class="section-title">البيانات الشخصية</h3>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="fullName">الاسم الثلاثي <span class="required">*</span></label>
                            <input type="text" id="fullName" name="fullName" class="form-control"
                                placeholder="أدخل الاسم الثلاثي كاملاً" required>
                        </div>

                        <div class="form-group">
                            <label for="nationalId">رقم الهوية الوطنية <span class="required">*</span></label>
                            <input type="text" id="nationalId" name="nationalId" class="form-control"
                                placeholder="أدخل رقم الهوية الوطنية" required>
                        </div>

                        <div class="form-group">
                            <label for="birthDate">تاريخ الميلاد <span class="required">*</span></label>
                            <input type="date" id="birthDate" name="birthDate" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="idFront">صورة الهوية من الأمام <span class="required">*</span></label>
                            <div class="file-upload">
                                <input type="file" id="idFront" name="idFront" accept="image/*" required>
                                <div class="file-upload-label">
                                    <span>📷 اضغط لرفع صورة الهوية من الأمام</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="idBack">صورة الهوية من الخلف <span class="required">*</span></label>
                            <div class="file-upload">
                                <input type="file" id="idBack" name="idBack" accept="image/*" required>
                                <div class="file-upload-label">
                                    <span>📷 اضغط لرفع صورة الهوية من الخلف</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="personalPhoto">صورة شخصية أو صورة من الاستديو <span
                                    class="required">*</span></label>
                            <div class="file-upload">
                                <input type="file" id="personalPhoto" name="personalPhoto" accept="image/*" required>
                                <div class="file-upload-label">
                                    <span>📸 اضغط لرفع الصورة الشخصية</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>الجنس <span class="required">*</span></label>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" id="male" name="gender" value="male" required>
                                    <span>ذكر</span>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="female" name="gender" value="female" required>
                                    <span>أنثى</span>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="noDisclosure" name="gender" value="noDisclosure"
                                        required>
                                    <span>عدم الإفصاح</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بيانات الشركة/المؤسسة -->
                <div class="form-section" id="companySection" style="display: none;">
                    <h3 class="section-title">بيانات الشركة/المؤسسة</h3>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="companyName">اسم الشركة/المؤسسة كما هو مكتوب بالسجل <span
                                    class="required">*</span></label>
                            <input type="text" id="companyName" name="companyName" class="form-control"
                                placeholder="أدخل اسم الشركة/المؤسسة">
                        </div>

                        <div class="form-group">
                            <label for="activityType">نوع النشاط <span class="required">*</span></label>
                            <input type="text" id="activityType" name="activityType" class="form-control"
                                placeholder="أدخل نوع النشاط">
                        </div>

                        <div class="form-group">
                            <label for="commercialRegister">رقم السجل التجاري <span class="required">*</span></label>
                            <input type="text" id="commercialRegister" name="commercialRegister"
                                class="form-control" placeholder="أدخل رقم السجل التجاري">
                        </div>

                        <div class="form-group">
                            <label for="registerSource">مصدر السجل <span class="required">*</span></label>
                            <input type="text" id="registerSource" name="registerSource" class="form-control"
                                placeholder="أدخل مصدر السجل">
                        </div>

                        <div class="form-group full-width">
                            <label>تاريخ انتهاء السجل <span class="required">*</span></label>
                            <div class="date-container">
                                <div>
                                    <label for="expiryDay">اليوم</label>
                                    <select id="expiryDay" name="expiryDay" class="form-control">
                                        <option value="">اختر اليوم</option>
                                        <script>
                                            for (let i = 1; i <= 31; i++) {
                                                document.write(`<option value="${i}">${i}</option>`);
                                            }
                                        </script>
                                    </select>
                                </div>
                                <div>
                                    <label for="expiryMonth">الشهر</label>
                                    <select id="expiryMonth" name="expiryMonth" class="form-control">
                                        <option value="">اختر الشهر</option>
                                        <option value="1">يناير</option>
                                        <option value="2">فبراير</option>
                                        <option value="3">مارس</option>
                                        <option value="4">أبريل</option>
                                        <option value="5">مايو</option>
                                        <option value="6">يونيو</option>
                                        <option value="7">يوليو</option>
                                        <option value="8">أغسطس</option>
                                        <option value="9">سبتمبر</option>
                                        <option value="10">أكتوبر</option>
                                        <option value="11">نوفمبر</option>
                                        <option value="12">ديسمبر</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="expiryYear">السنة</label>
                                    <input type="number" id="expiryYear" name="expiryYear" class="form-control"
                                        placeholder="السنة" min="2024" max="2050">
                                </div>
                                <div class="calendar-type">
                                    <label>نوع التقويم</label>
                                    <div>
                                        <label><input type="radio" name="calendarType" value="hijri"> هجري</label>
                                        <label><input type="radio" name="calendarType" value="gregorian" checked>
                                            ميلادي</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="registrantCapacity">صفة من قام بالتسجيل <span
                                    class="required">*</span></label>
                            <input type="text" id="registrantCapacity" name="registrantCapacity"
                                class="form-control" placeholder="مثال: المدير العام، المالك، الوكيل المفوض">
                            <small style="color: #718096; margin-top: 5px; display: block;">في حالة التسجيل من قبل
                                المدير يجب أن يكون مذكور بالسجل أو إرفاق وكالة</small>
                        </div>
                    </div>
                </div>

                <!-- بيانات العنوان -->
                <div class="form-section">
                    <h3 class="section-title">بيانات العنوان</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="country">الدولة <span class="required">*</span></label>
                            <select id="country" name="country" class="form-control" required>
                                <option value="">اختر الدولة</option>
                                <option value="saudi">المملكة العربية السعودية</option>
                                <option value="uae">الإمارات العربية المتحدة</option>
                                <option value="kuwait">الكويت</option>
                                <option value="qatar">قطر</option>
                                <option value="bahrain">البحرين</option>
                                <option value="oman">عمان</option>
                                <option value="egypt">مصر</option>
                                <option value="jordan">الأردن</option>
                                <option value="lebanon">لبنان</option>
                                <option value="syria">سوريا</option>
                                <option value="iraq">العراق</option>
                                <option value="yemen">اليمن</option>
                                <option value="other">أخرى</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="city">المدينة <span class="required">*</span></label>
                            <input type="text" id="city" name="city" class="form-control"
                                placeholder="أدخل اسم المدينة" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="address">العنوان التفصيلي <span class="required">*</span></label>
                            <textarea id="address" name="address" class="form-control" rows="3"
                                placeholder="أدخل العنوان التفصيلي (الحي، الشارع، رقم المبنى، إلخ)" required></textarea>
                        </div>

                        <div class="form-group full-width">
                            <label>تحديد الموقع على الخريطة
                                <span class="tooltip">ℹ️
                                    <span class="tooltiptext">اضغط على الخريطة لتحديد موقعك بدقة</span>
                                </span>
                            </label>
                            <div class="map-container" onclick="selectLocation()">
                                <span>🗺️ اضغط هنا لتحديد الموقع على الخريطة</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone">رقم الهاتف <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" class="form-control"
                                placeholder="أدخل رقم الهاتف مع رمز الدولة" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    إرسال طلب التسجيل
                </button>
            </form>
        </div>
    </div>

    <script>
        // التحكم في إظهار/إخفاء الأقسام حسب نوع الكيان
        const entityTypeRadios = document.querySelectorAll('input[name="entityType"]');
        const individualSection = document.getElementById('individualSection');
        const companySection = document.getElementById('companySection');

        entityTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'individual') {
                    individualSection.style.display = 'block';
                    companySection.style.display = 'none';

                    // جعل حقول الفرد مطلوبة
                    individualSection.querySelectorAll('[required]').forEach(field => field.required =
                        true);
                    companySection.querySelectorAll('[required]').forEach(field => field.required = false);
                } else {
                    individualSection.style.display = 'none';
                    companySection.style.display = 'block';

                    // جعل حقول الشركة مطلوبة
                    companySection.querySelectorAll('[required]').forEach(field => field.required = true);
                    individualSection.querySelectorAll('[required]').forEach(field => field.required =
                        false);
                }
            });
        });

        // تحديث نص رفع الملفات
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const label = this.nextElementSibling;
                if (this.files.length > 0) {
                    label.innerHTML = `✅ تم اختيار الملف: ${this.files[0].name}`;
                    label.style.color = '#28a745';
                    label.style.borderColor = '#28a745';
                }
            });
        });

        // تحديد الموقع على الخريطة
        function selectLocation() {
            const mapContainer = document.querySelector('.map-container');
            mapContainer.innerHTML = '📍 تم تحديد الموقع بنجاح';
            mapContainer.style.backgroundColor = '#d4edda';
            mapContainer.style.borderColor = '#28a745';
            mapContainer.style.color = '#155724';
        }

        // معالجة إرسال النموذج
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // إظهار رسالة نجاح
            const submitBtn = document.querySelector('.submit-btn');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '⏳ جاري الإرسال...';
            submitBtn.disabled = true;

            setTimeout(() => {
                submitBtn.innerHTML = '✅ تم إرسال الطلب بنجاح!';
                submitBtn.style.background = 'linear-gradient(135deg, #28a745, #20c997)';

                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    submitBtn.style.background =
                        'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                }, 3000);
            }, 2000);
        });

        // تحسين تفاعل الحقول
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // تحسين المظهر المتحرك للأزرار الراديو
        document.querySelectorAll('.radio-item').forEach(item => {
            item.addEventListener('click', function() {
                // إزالة التحديد من العناصر الأخرى في نفس المجموعة
                const groupName = this.querySelector('input').name;
                document.querySelectorAll(`input[name="${groupName}"]`).forEach(radio => {
                    radio.closest('.radio-item').style.background = 'white';
                    radio.closest('.radio-item').style.borderColor = '#e2e8f0';
                });

                // تحديد العنصر الحالي
                this.style.background = 'rgba(102, 126, 234, 0.1)';
                this.style.borderColor = '#667eea';
            });
        });
    </script>
</body>

</html>

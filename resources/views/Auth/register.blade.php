<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $websiteData->name }}</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('components.seo')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --success-color: #48bb78;
            --error-color: #f56565;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            overflow-x: hidden;
            position: relative;
        }

        /* خلفية متحركة ثلاثية الأبعاد */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
            background-size: 600% 600%;
            animation: gradientFlow 20s ease infinite;
        }

        .mesh-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            animation: meshMove 30s ease-in-out infinite;
        }

        @keyframes gradientFlow {

            0%,
            100% {
                background-position: 0% 50%;
            }

            33% {
                background-position: 100% 0%;
            }

            66% {
                background-position: 0% 100%;
            }
        }

        @keyframes meshMove {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            50% {
                transform: translate(-20px, -20px) rotate(180deg);
            }
        }

        /* حاوي رئيسي */
        .main-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        /* بطاقة التسجيل الرئيسية */
        .register-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(30px);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 25px 45px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            max-width: 1400px;
            width: 100%;
            overflow: hidden;
            position: relative;
            animation: cardEntry 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes cardEntry {
            0% {
                opacity: 0;
                transform: scale(0.8) translateY(50px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .card-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 700px;
        }

        /* قسم النموذج */
        .form-section {
            padding: 4rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--primary-gradient);
        }

        .brand-section {
            text-align: center;
            margin-bottom: 3rem;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            animation: logoFloat 3s ease-in-out infinite;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        @keyframes logoFloat {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .brand-logo i {
            font-size: 2rem;
            color: white;
        }

        .form-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        /* مجموعات الإدخال */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group.full-width {
            grid-column: 1 / -1;
        }

        .form-input {
            width: 100%;
            padding: 1.2rem 1.5rem 1.2rem 3.5rem;
            border: 2px solid rgba(102, 126, 234, 0.1);
            border-radius: 16px;
            font-size: 1rem;
            font-family: 'Cairo', sans-serif;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-input:focus+.input-icon {
            color: #667eea;
            transform: translateY(-50%) scale(1.1);
        }

        .input-icon {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        /* زر التسجيل */
        .submit-btn {
            width: 100%;
            padding: 1.3rem;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* رابط تسجيل الدخول */
        .login-link {
            text-align: center;
            padding: 1.5rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 16px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .login-link p {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            padding: 0.8rem 2rem;
            border: 2px solid #667eea;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        /* القسم الجانبي */
        .hero-section {
            background: var(--primary-gradient);
            color: white;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-bg-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: floatShape 15s infinite ease-in-out;
        }

        .floating-shape:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            left: 70%;
            animation-delay: 5s;
        }

        .floating-shape:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 80%;
            left: 20%;
            animation-delay: 10s;
        }

        @keyframes floatShape {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(30px, -30px) rotate(120deg);
            }

            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, #f0f8ff);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: textShine 3s ease-in-out infinite;
        }

        @keyframes textShine {

            0%,
            100% {
                filter: brightness(1);
            }

            50% {
                filter: brightness(1.2);
            }
        }

        .hero-subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 3rem;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem;
            width: 100%;
            margin-top: 3rem;
        }

        .feature-item {
            text-align: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            animation: iconBounce 2s infinite;
        }

        .feature-item:nth-child(2) .feature-icon {
            animation-delay: 0.3s;
        }

        .feature-item:nth-child(3) .feature-icon {
            animation-delay: 0.6s;
        }

        @keyframes iconBounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        .feature-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .feature-desc {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* تنبيهات */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid;
            animation: alertSlide 0.5s ease;
        }

        .alert-danger {
            background: rgba(245, 101, 101, 0.1);
            border-color: rgba(245, 101, 101, 0.3);
            color: var(--error-color);
        }

        @keyframes alertSlide {
            0% {
                opacity: 0;
                transform: translateX(30px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* تأثيرات الماوس */
        .cursor-glow {
            position: fixed;
            width: 20px;
            height: 20px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.6), transparent);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.1s ease;
        }

        /* الاستجابة للشاشات الصغيرة */
        @media (max-width: 1024px) {
            .card-content {
                grid-template-columns: 1fr;
            }

            .hero-section {
                order: -1;
                min-height: 400px;
            }

            .form-section {
                padding: 3rem 2rem;
            }
        }

        @media (max-width: 768px) {
            .main-wrapper {
                padding: 1rem;
            }

            .register-card {
                border-radius: 20px;
            }

            .form-section {
                padding: 2rem 1.5rem;
            }

            .hero-section {
                padding: 2rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .hero-title {
                font-size: 2.2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .form-title {
                font-size: 1.8rem;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }
        }

        /* تحسينات إضافية */
        .social-proof {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }

        .social-proof-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="animated-bg"></div>
    <div class="mesh-overlay"></div>
    <div class="cursor-glow" id="cursorGlow"></div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="main-wrapper">
        <div class="register-card">
            <div class="card-content">
                <!-- قسم النموذج -->
                <div class="form-section">
                    <div class="brand-section">
                        <div class="brand-logo">
                            <i class="fas fa-users"></i>
                        </div>
                        <h1 class="form-title">انضم إلينا اليوم</h1>
                        <p class="form-subtitle">أنشئ حسابك واستمتع بتجربة تواصل فريدة</p>
                    </div>

                    @include('components.alerts')

                    <form method="POST" action="{{ route('customRegister') }}" id="registerForm">
                        @csrf

                        <div class="form-grid">
                            <div class="input-group">
                                <input type="text" name="name" class="form-input" placeholder="الاسم الكامل"
                                    required>
                                <i class="fas fa-user input-icon"></i>
                            </div>

                            <div class="input-group">
                                <input type="text" name="username" class="form-input" placeholder="اسم المستخدم"
                                    required>
                                <i class="fas fa-at input-icon"></i>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="input-group">
                                <input type="email" name="email" class="form-input" placeholder="البريد الإلكتروني"
                                    required>
                                <i class="fas fa-envelope input-icon"></i>
                            </div>

                            <div class="input-group">
                                <input type="tel" name="phone" class="form-input" placeholder="رقم الهاتف"
                                    required>
                                <i class="fas fa-phone input-icon"></i>
                            </div>
                        </div>

                        <div class="input-group full-width">
                            <input type="text" name="address" class="form-input" placeholder="العنوان" required>
                            <i class="fas fa-map-marker-alt input-icon"></i>
                        </div>

                        <div class="form-grid">
                            <div class="input-group">
                                <input type="password" name="password" class="form-input" placeholder="كلمة المرور"
                                    required>
                                <i class="fas fa-lock input-icon"></i>
                            </div>

                            <div class="input-group">
                                <input type="password" name="password_confirmation" class="form-input"
                                    placeholder="تأكيد كلمة المرور" required>
                                <i class="fas fa-shield-alt input-icon"></i>
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-user-plus" style="margin-left: 10px;"></i>
                            إنشاء حساب جديد
                        </button>

                        <div class="login-link">
                            <p>لديك حساب بالفعل؟</p>
                            <a href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i>
                                تسجيل الدخول
                            </a>
                        </div>
                    </form>
                </div>

                <!-- القسم الجانبي -->
                <div class="hero-section">
                    <div class="hero-bg-elements">
                        <div class="floating-shape"></div>
                        <div class="floating-shape"></div>
                        <div class="floating-shape"></div>
                    </div>

                    <div class="hero-content">
                        <h2 class="hero-title">مرحباً بك في مجتمعنا</h2>
                        <p class="hero-subtitle">انضم إلى آلاف المستخدمين واستمتع بتجربة تواصل اجتماعي متطورة وآمنة</p>

                        <div class="features-grid">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="feature-title">أمان عالي</div>
                                <div class="feature-desc">حماية متقدمة لبياناتك</div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div class="feature-title">سرعة فائقة</div>
                                <div class="feature-desc">أداء محسن ومتطور</div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="feature-title">سهولة الاستخدام</div>
                                <div class="feature-desc">تجربة مستخدم مميزة</div>
                            </div>
                        </div>

                        <div class="social-proof">
                            <div class="social-proof-item">
                                <i class="fas fa-users"></i>
                                <span>{{ App\Models\User::count() }}+ مستخدم</span>
                            </div>
                            <div class="social-proof-item">
                                <i class="fas fa-star"></i>
                                <span>4.9 تقييم</span>
                            </div>
                            <div class="social-proof-item">
                                <i class="fas fa-globe"></i>
                                <span>100+ دولة</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // تتبع المؤشر مع تأثير التوهج
        const cursorGlow = document.getElementById('cursorGlow');
        let mouseX = 0,
            mouseY = 0;
        let glowX = 0,
            glowY = 0;

        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        function animateGlow() {
            glowX += (mouseX - glowX) * 0.1;
            glowY += (mouseY - glowY) * 0.1;

            cursorGlow.style.left = glowX - 10 + 'px';
            cursorGlow.style.top = glowY - 10 + 'px';

            requestAnimationFrame(animateGlow);
        }
        animateGlow();

        // تأثيرات التفاعل مع الحقول
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.zIndex = '10';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
                this.parentElement.style.zIndex = '1';
            });

            // تأثير الكتابة
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.style.background = 'rgba(102, 126, 234, 0.05)';
                } else {
                    this.style.background = 'rgba(255, 255, 255, 0.8)';
                }
            });
        });

        // تأثير إرسال النموذج
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.style.display = 'flex';

            // إزالة التحميل بعد 3 ثوان (يمكن تعديل هذا حسب استجابة الخادم)
            setTimeout(() => {
                loadingOverlay.style.display = 'none';
            }, 3000);
        });

        // تأثيرات الحركة عند التمرير
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const shapes = document.querySelectorAll('.floating-shape');

            shapes.forEach((shape, index) => {
                const speed = 0.5 + (index * 0.2);
                shape.style.transform = `translateY(${scrolled * speed}px) rotate(${scrolled * 0.1}deg)`;
            });
        });

        // تأثير النقر على الأزرار
        document.querySelectorAll('button, .login-link a').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.position = 'absolute';
                ripple.style.background = 'rgba(255, 255, 255, 0.5)';
                ripple.style.borderRadius = '50%';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.pointerEvents = 'none';

                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // إضافة تأثير الريبل
        const rippleStyle = document.createElement('style');
        rippleStyle.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(rippleStyle);

        // تحقق من صحة البيانات المدخلة
        function validateForm() {
            const inputs = document.querySelectorAll('.form-input[required]');
            let isValid = true;

            inputs.forEach(input => {
                const value = input.value.trim();
                const inputGroup = input.parentElement;

                // إزالة الرسائل السابقة
                const existingError = inputGroup.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }

                // التحقق من الحقول الفارغة
                if (!value) {
                    showInputError(input, 'هذا الحقل مطلوب');
                    isValid = false;
                } else {
                    // التحقق من البريد الإلكتروني
                    if (input.type === 'email' && !isValidEmail(value)) {
                        showInputError(input, 'البريد الإلكتروني غير صحيح');
                        isValid = false;
                    }

                    // التحقق من كلمة المرور
                    if (input.name === 'password' && value.length < 8) {
                        showInputError(input, 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل');
                        isValid = false;
                    }

                    // التحقق من تأكيد كلمة المرور
                    if (input.name === 'password_confirmation') {
                        const password = document.querySelector('input[name="password"]').value;
                        if (value !== password) {
                            showInputError(input, 'كلمة المرور غير متطابقة');
                            isValid = false;
                        }
                    }

                    // التحقق من رقم الهاتف
                    if (input.name === 'phone' && !isValidPhone(value)) {
                        showInputError(input, 'رقم الهاتف غير صحيح');
                        isValid = false;
                    }
                }
            });

            return isValid;
        }

        function showInputError(input, message) {
            const inputGroup = input.parentElement;
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            errorDiv.style.cssText = `
                color: #f56565;
                font-size: 0.875rem;
                margin-top: 0.5rem;
                animation: errorSlide 0.3s ease;
            `;

            input.style.borderColor = '#f56565';
            input.style.background = 'rgba(245, 101, 101, 0.05)';

            inputGroup.appendChild(errorDiv);

            // إزالة التأثير عند التصحيح
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.style.borderColor = 'rgba(102, 126, 234, 0.1)';
                    this.style.background = 'rgba(255, 255, 255, 0.8)';
                    const error = inputGroup.querySelector('.error-message');
                    if (error) error.remove();
                }
            }, {
                once: true
            });
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function isValidPhone(phone) {
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]+$/;
            return phoneRegex.test(phone) && phone.replace(/\D/g, '').length >= 10;
        }

        // تحسين تجربة إرسال النموذج
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                // إظهار رسالة خطأ عامة
                showNotification('يرجى التحقق من البيانات المدخلة', 'error');
                return;
            }

            // إظهار شاشة التحميل
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.style.display = 'flex';

            // محاكاة إرسال البيانات
            setTimeout(() => {
                this.submit(); // إرسال النموذج فعلياً
            }, 1000);
        });

        // نظام الإشعارات
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; color: inherit; font-size: 1.2rem; cursor: pointer;">×</button>
            `;

            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'error' ? 'rgba(245, 101, 101, 0.9)' : 'rgba(72, 187, 120, 0.9)'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                backdrop-filter: blur(10px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                z-index: 10001;
                display: flex;
                align-items: center;
                gap: 1rem;
                animation: notificationSlide 0.5s ease;
                max-width: 400px;
            `;

            document.body.appendChild(notification);

            // إزالة الإشعار تلقائياً
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.animation = 'notificationSlideOut 0.5s ease forwards';
                    setTimeout(() => notification.remove(), 500);
                }
            }, 5000);
        }

        // إضافة أنماط الإشعارات والأخطاء
        const additionalStyles = document.createElement('style');
        additionalStyles.textContent = `
            @keyframes errorSlide {
                0% { opacity: 0; transform: translateY(-10px); }
                100% { opacity: 1; transform: translateY(0); }
            }

            @keyframes notificationSlide {
                0% { opacity: 0; transform: translateX(100%); }
                100% { opacity: 1; transform: translateX(0); }
            }

            @keyframes notificationSlideOut {
                0% { opacity: 1; transform: translateX(0); }
                100% { opacity: 0; transform: translateX(100%); }
            }

            .error-message {
                animation: errorSlide 0.3s ease;
            }

            /* تحسينات إضافية للشاشات الصغيرة */
            @media (max-width: 640px) {
                .notification {
                    right: 10px !important;
                    left: 10px !important;
                    max-width: none !important;
                }
            }

            /* تأثيرات تحميل متقدمة */
            .submit-btn.loading {
                pointer-events: none;
                opacity: 0.8;
            }

            .submit-btn.loading::after {
                content: '';
                position: absolute;
                width: 20px;
                height: 20px;
                border: 2px solid transparent;
                border-top: 2px solid white;
                border-radius: 50%;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                animation: spin 1s linear infinite;
            }

            /* تحسين التأثيرات البصرية */
            .form-input:valid {
                border-color: rgba(72, 187, 120, 0.3);
            }

            .form-input:invalid:not(:placeholder-shown) {
                border-color: rgba(245, 101, 101, 0.3);
            }

            /* تأثيرات الهوفر المحسنة */
            .feature-item:hover {
                transform: translateY(-10px) scale(1.05);
                box-shadow: 0 20px 40px rgba(255, 255, 255, 0.1);
            }

            .brand-logo:hover {
                transform: scale(1.1) rotate(15deg);
                box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
            }

            /* تحسينات الأداء */
            * {
                will-change: auto;
            }

            .floating-shape {
                will-change: transform;
            }

            .form-input:focus {
                will-change: transform, box-shadow;
            }
        `;
        document.head.appendChild(additionalStyles);

        // تأثير التحميل التدريجي للعناصر
        function initScrollAnimations() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // مراقبة العناصر القابلة للتحريك
            document.querySelectorAll('.feature-item, .input-group').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        }

        // تهيئة الصفحة بعد التحميل
        document.addEventListener('DOMContentLoaded', function() {
            initScrollAnimations();

            // تأثير الترحيب
            setTimeout(() => {
                showNotification('مرحباً بك! املأ البيانات لإنشاء حسابك', 'info');
            }, 1500);
        });

        // تحسين الأداء - تأجيل التأثيرات غير المهمة
        requestIdleCallback(() => {
            // إضافة المزيد من التأثيرات البصرية
            const extraEffects = document.createElement('style');
            extraEffects.textContent = `
                .register-card::before {
                    content: '';
                    position: absolute;
                    top: -2px;
                    left: -2px;
                    right: -2px;
                    bottom: -2px;
                    background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c);
                    background-size: 400% 400%;
                    z-index: -1;
                    border-radius: 32px;
                    animation: gradientFlow 20s ease infinite;
                    opacity: 0.3;
                }
            `;
            document.head.appendChild(extraEffects);
        });
    </script>
</body>

</html>

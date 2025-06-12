<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('components.seo')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            text-align: right;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow-x: hidden;
        }

        .animated-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            background: #fff;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            background: #fff;
            top: 70%;
            left: 80%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            background: #fff;
            top: 40%;
            left: 70%;
            animation-delay: 4s;
        }

        @keyframes gradientShift {

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
                transform: translateY(-30px) rotate(120deg);
            }

            66% {
                transform: translateY(20px) rotate(240deg);
            }
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 100%;
            overflow: hidden;
            transform: scale(0.9);
            animation: cardEntry 1s ease-out forwards;
        }

        @keyframes cardEntry {
            to {
                transform: scale(1);
            }
        }

        .form-section {
            padding: 3rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .hero-section {
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
            top: -50%;
            left: -50%;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .logo {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: logoSpin 20s linear infinite;
        }

        @keyframes logoSpin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .logo i {
            font-size: 3rem;
            color: white;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: textGlow 3s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            from {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }

            to {
                text-shadow: 2px 2px 20px rgba(255, 255, 255, 0.5);
            }
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
            position: relative;
        }

        .form-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            font-size: 1rem;
            font-family: 'Cairo', sans-serif;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .form-input:focus+.input-icon {
            color: #764ba2;
            transform: translateY(-50%) scale(1.1);
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1.5rem;
            border: 2px solid #667eea;
            border-radius: 25px;
            display: inline-block;
        }

        .login-link a:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            animation: slideIn 0.5s ease;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
            backdrop-filter: blur(5px);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating-icons {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 15px;
        }

        .floating-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            animation: bounce 2s infinite;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .floating-icon:nth-child(2) {
            animation-delay: 0.2s;
        }

        .floating-icon:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {

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

        @media (max-width: 768px) {
            .glass-card {
                margin: 1rem;
                border-radius: 15px;
            }

            .form-section,
            .hero-section {
                padding: 2rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
        }

        .particles-container {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
    </style>
</head>

<body>
    <div class="animated-background"></div>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="main-container">
        <div class="glass-card">
            <div class="row" style="display: flex; min-height: 600px;">
                <div class="col-lg-6" style="flex: 1;">
                    <div class="form-section">
                        <h2 class="form-title">إنشاء حساب جديد</h2>
                        @include('components.alerts')

                        <form method="POST" action="{{ route('customRegister') }}">
                            @csrf

                            <div class="input-group">
                                <input type="text" name="name" class="form-input" placeholder="أدخل اسمك الكامل"
                                    required>
                                <i class="fas fa-user input-icon"></i>
                            </div>

                            <div class="input-group">
                                <input type="text" name="username" class="form-input" placeholder="أدخل اسم المستخدم"
                                    required>
                                <i class="fas fa-at input-icon"></i>
                            </div>

                            <div class="input-group">
                                <input type="email" name="email" class="form-input"
                                    placeholder="أدخل بريدك الإلكتروني" required>
                                <i class="fas fa-envelope input-icon"></i>
                            </div>

                            <div class="input-group">
                                <input type="text" name="phone" class="form-input" placeholder="أدخل رقم هاتفك"
                                    required>
                                <i class="fas fa-phone input-icon"></i>
                            </div>

                            <div class="input-group">
                                <input type="text" name="address" class="form-input" placeholder="أدخل عنوانك"
                                    required>
                                <i class="fas fa-map-marker-alt input-icon"></i>
                            </div>

                            <div class="input-group">
                                <input type="password" name="password" class="form-input" placeholder="أدخل كلمة المرور"
                                    required>
                                <i class="fas fa-lock input-icon"></i>
                            </div>

                            <div class="input-group">
                                <input type="password" name="password_confirmation" class="form-input"
                                    placeholder="أعد إدخال كلمة المرور" required>
                                <i class="fas fa-shield-alt input-icon"></i>
                            </div>

                            <button type="submit" class="submit-btn">
                                <i class="fas fa-user-plus" style="margin-left: 10px;"></i>
                                إنشاء حساب
                            </button>

                            <div class="login-link">
                                <p style="margin-bottom: 10px; color: #666;">لديك حساب بالفعل؟</p>
                                <a href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt" style="margin-left: 8px;"></i>
                                    تسجيل الدخول
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6" style="flex: 1;">
                    <div class="hero-section">
                        <div class="particles-container" id="particles"></div>

                        <div class="floating-icons">
                            <div class="floating-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div class="floating-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="floating-icon">
                                <i class="fas fa-gem"></i>
                            </div>
                        </div>

                        <div class="logo">
                            <i class="fas fa-magic"></i>
                        </div>

                        <h1 class="hero-title">مرحباً بك</h1>
                        <p class="hero-subtitle">انضم إلى مجتمعنا واستمتع بتجربة فريدة ومميزة</p>

                        <div style="display: flex; gap: 20px; margin-top: 2rem;">
                            <div style="text-align: center;">
                                <i class="fas fa-shield-alt"
                                    style="font-size: 2rem; margin-bottom: 10px; opacity: 0.8;"></i>
                                <p style="font-size: 0.9rem;">أمان عالي</p>
                            </div>
                            <div style="text-align: center;">
                                <i class="fas fa-bolt"
                                    style="font-size: 2rem; margin-bottom: 10px; opacity: 0.8;"></i>
                                <p style="font-size: 0.9rem;">سرعة فائقة</p>
                            </div>
                            <div style="text-align: center;">
                                <i class="fas fa-heart"
                                    style="font-size: 2rem; margin-bottom: 10px; opacity: 0.8;"></i>
                                <p style="font-size: 0.9rem;">سهولة الاستخدام</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // إنشاء جسيمات متحركة
        function createParticles() {
            const container = document.getElementById('particles');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (Math.random() * 20 + 10) + 's';

                const keyframes = `
                    @keyframes float${i} {
                        0%, 100% {
                            transform: translate(0, 0) scale(1);
                            opacity: 0.6;
                        }
                        25% {
                            transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(1.2);
                            opacity: 1;
                        }
                        50% {
                            transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(0.8);
                            opacity: 0.4;
                        }
                        75% {
                            transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(1.1);
                            opacity: 0.8;
                        }
                    }
                `;

                const style = document.createElement('style');
                style.textContent = keyframes;
                document.head.appendChild(style);

                particle.style.animation = `float${i} ${Math.random() * 20 + 10}s infinite ease-in-out`;
                container.appendChild(particle);
            }
        }

        // تأثير تتبع المؤشر
        document.addEventListener('mousemove', (e) => {
            const cursor = document.createElement('div');
            cursor.style.position = 'fixed';
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            cursor.style.width = '6px';
            cursor.style.height = '6px';
            cursor.style.background = 'rgba(102, 126, 234, 0.6)';
            cursor.style.borderRadius = '50%';
            cursor.style.pointerEvents = 'none';
            cursor.style.zIndex = '9999';
            cursor.style.animation = 'cursorFade 1s ease-out forwards';

            document.body.appendChild(cursor);

            setTimeout(() => {
                cursor.remove();
            }, 1000);
        });

        // إضافة تأثير cursorFade
        const cursorStyle = document.createElement('style');
        cursorStyle.textContent = `
            @keyframes cursorFade {
                0% { transform: scale(1); opacity: 1; }
                100% { transform: scale(3); opacity: 0; }
            }
        `;
        document.head.appendChild(cursorStyle);

        // تحريك العناصر عند التمرير
        document.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const elements = document.querySelectorAll('.floating-icon');
            elements.forEach((el, index) => {
                el.style.transform =
                    `translateY(${scrolled * 0.1 * (index + 1)}px) rotate(${scrolled * 0.1}deg)`;
            });
        });

        // تشغيل إنشاء الجسيمات
        createParticles();

        // تأثير الكتابة التفاعلية
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'transform 0.3s ease';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>

</html>

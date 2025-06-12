<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('components.seo')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tajawal', 'Cairo', sans-serif;
            text-align: right;
            overflow-x: hidden;
            background: var(--primary-gradient);
            min-height: 100vh;
            position: relative;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: var(--primary-gradient);
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><radialGradient id="a" cx="50%" cy="50%" r="50%"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1)"/><stop offset="100%" style="stop-color:rgba(255,255,255,0)"/></radialGradient></defs><circle cx="20" cy="20" r="2" fill="url(%23a)"><animate attributeName="cx" values="20;80;20" dur="10s" repeatCount="indefinite"/></circle><circle cx="80" cy="40" r="1.5" fill="url(%23a)"><animate attributeName="cy" values="40;10;40" dur="8s" repeatCount="indefinite"/></circle><circle cx="40" cy="80" r="1" fill="url(%23a)"><animate attributeName="cx" values="40;60;40" dur="12s" repeatCount="indefinite"/></circle></svg>') repeat;
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            25% {
                transform: translateY(-20px) rotate(1deg);
            }

            50% {
                transform: translateY(0px) rotate(0deg);
            }

            75% {
                transform: translateY(-10px) rotate(-1deg);
            }
        }

        /* Glassmorphism Container */
        .glass-container {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow:
                0 25px 45px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        .login-card {
            width: 100%;
            max-width: 1000px;
            overflow: hidden;
            animation: slideInUp 0.8s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-form-section {
            padding: 60px 40px;
            position: relative;
        }

        .welcome-section {
            background: linear-gradient(135deg, rgba(103, 58, 183, 0.9) 0%, rgba(63, 81, 181, 0.9) 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><defs><pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"><path d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(60px, 60px);
            }
        }

        .logo-container {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            animation: logoFloat 3s ease-in-out infinite;
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

        .logo-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #333;
            margin-top: 20px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logo-subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-top: 8px;
            font-weight: 400;
        }

        .form-group {
            position: relative;
            margin-bottom: 30px;
        }

        .form-input {
            width: 100%;
            padding: 18px 20px 18px 50px;
            border: 2px solid rgba(103, 58, 183, 0.1);
            border-radius: 16px;
            font-size: 16px;
            font-family: 'Tajawal', sans-serif;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: #673ab7;
            box-shadow: 0 0 0 4px rgba(103, 58, 183, 0.1);
            transform: translateY(-2px);
        }

        .form-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #673ab7;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .form-input:focus+.form-icon {
            color: #3f51b5;
            transform: translateY(-50%) scale(1.1);
        }

        .login-btn {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 16px;
            font-size: 18px;
            font-weight: 600;
            color: white;
            background: var(--primary-gradient);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-family: 'Tajawal', sans-serif;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(103, 58, 183, 0.3);
        }

        .forgot-password {
            display: block;
            text-align: center;
            color: #673ab7;
            text-decoration: none;
            margin-top: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: #3f51b5;
            transform: translateY(-1px);
        }

        .register-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(103, 58, 183, 0.1);
        }

        .register-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 14px 28px;
            border: 2px solid #673ab7;
            border-radius: 12px;
            color: #673ab7;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
        }

        .register-btn:hover {
            background: #673ab7;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(103, 58, 183, 0.2);
        }

        .welcome-content {
            text-align: center;
            color: white;
            padding: 40px;
            position: relative;
            z-index: 2;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .welcome-text {
            font-size: 1.2rem;
            line-height: 1.6;
            opacity: 0.95;
            max-width: 400px;
            margin: 0 auto;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: floatUpDown 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 70%;
            left: 80%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 40px;
            height: 40px;
            top: 30%;
            left: 70%;
            animation-delay: 4s;
        }

        @keyframes floatUpDown {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: none;
            font-family: 'Tajawal', sans-serif;
        }

        .alert-danger {
            background: rgba(244, 67, 54, 0.1);
            color: #c62828;
            border: 1px solid rgba(244, 67, 54, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-form-section {
                padding: 40px 30px;
            }

            .welcome-section {
                display: none;
            }

            .logo-title {
                font-size: 1.8rem;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .form-input {
                padding: 16px 18px 16px 45px;
            }

            .login-btn {
                padding: 16px;
                font-size: 16px;
            }
        }

        /* RTL Improvements */
        .form-input {
            padding: 18px 50px 18px 20px;
        }

        .form-icon {
            right: 18px;
            left: auto;
        }

        /* Custom animations */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(103, 58, 183, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(103, 58, 183, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(103, 58, 183, 0);
            }
        }

        .login-btn:active {
            animation: pulse 0.6s;
        }
    </style>
</head>

<body>
    <div class="animated-bg"></div>

    <div class="main-container">
        <div class="login-card glass-container">
            <div class="row g-0 h-100">
                <div class="col-lg-6">
                    <div class="login-form-section">
                        <div class="floating-elements">
                            <div class="floating-element"></div>
                            <div class="floating-element"></div>
                            <div class="floating-element"></div>
                        </div>

                        <div class="logo-container">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="الشعار">
                            <p class="logo-subtitle">أهلاً بك مرة أخرى</p>
                        </div>

                        <form action="{{ route('customLogin') }}" method="POST">
                            @csrf
                            @include('components.alerts')
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-input"
                                    placeholder="البريد الإلكتروني أو رقم الهاتف" required />
                                <i class="fas fa-envelope form-icon"></i>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-input"
                                    placeholder="كلمة المرور" required />
                                <i class="fas fa-lock form-icon"></i>
                            </div>

                            <button type="submit" class="login-btn">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                تسجيل الدخول
                            </button>

                            <a href="{{ route('forgetPassword') }}" class="forgot-password">
                                <i class="fas fa-question-circle me-1"></i>
                                هل نسيت كلمة المرور؟
                            </a>

                            <div class="register-section">
                                <p class="mb-3" style="color: #666;">ليس لديك حساب؟</p>
                                <a href="{{ route('register') }}" class="register-btn">
                                    <i class="fas fa-user-plus"></i>
                                    إنشاء حساب جديد
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block">
                    <div class="welcome-section">
                        <div class="welcome-content">
                            <h2 class="welcome-title">نحن أكثر من مجرد شركة</h2>
                            <p class="welcome-text">
                                نحن نؤمن بتقديم أفضل الحلول لعملائنا لتحقيق أهدافهم بكفاءة واحترافية عالية. انضم إلينا
                                في رحلة النجاح والتميز.
                            </p>
                            <div class="mt-4">
                                <i class="fas fa-rocket" style="font-size: 3rem; opacity: 0.7;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

    <script>
        // تحسين تجربة المستخدم
        document.addEventListener('DOMContentLoaded', function() {
            // تأثير التركيز على الحقول
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    if (this.value === '') {
                        this.parentElement.classList.remove('focused');
                    }
                });
            });

            // تأثير الضغط على زر تسجيل الدخول
            const loginBtn = document.querySelector('.login-btn');
            loginBtn.addEventListener('click', function(e) {
                // إضافة تأثير بصري عند الضغط
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });

            // تحسين الأداء مع الرسوم المتحركة
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            if (prefersReducedMotion.matches) {
                document.body.classList.add('reduced-motion');
            }
        });

        // إضافة تأثير الكتابة
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });
        });
    </script>
</body>

</html>

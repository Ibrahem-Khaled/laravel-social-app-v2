<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الكاسر - سننطلق قريبًا</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
        }

        .glow {
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.7), 0 0 20px rgba(59, 130, 246, 0.5);
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body class="min-h-screen text-white">
    <!-- جسيمات الخلفية -->
    <div id="particles-js" class="absolute w-full h-full"></div>

    <div class="container mx-auto px-4 py-16 relative z-10">
        <!-- الشعار -->
        <div class="flex justify-center mb-12">
            <div class="bg-blue-500/20 p-6 rounded-full border border-blue-400/30 backdrop-blur-sm">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="w-16 h-16">
            </div>
        </div>

        <!-- العنوان الرئيسي -->
        <h1 class="text-5xl md:text-7xl font-bold text-center mb-6 glow animate__animated animate__fadeInDown">
            الكاسر
        </h1>

        <!-- الرسالة -->
        <div class="max-w-2xl mx-auto text-center mb-12 animate__animated animate__fadeInUp animate__delay-1s">
            <p class="text-xl md:text-2xl text-blue-200 mb-6">
                نحن نعد شيئًا استثنائيًا سيغير قواعد البث الرقمي!
            </p>
            <h2
                class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-400 to-cyan-400 text-transparent bg-clip-text pulse">
                سننطلق قريبًا...
            </h2>
        </div>

        <!-- عداد التنازلي -->
        <div
            class="max-w-2xl mx-auto grid grid-cols-4 gap-4 mb-16 animate__animated animate__fadeInUp animate__delay-2s">
            <div class="bg-blue-900/30 rounded-lg p-4 text-center border border-blue-400/20 backdrop-blur-sm">
                <div id="days" class="text-3xl font-bold text-blue-400">00</div>
                <div class="text-blue-200">أيام</div>
            </div>
            <div class="bg-blue-900/30 rounded-lg p-4 text-center border border-blue-400/20 backdrop-blur-sm">
                <div id="hours" class="text-3xl font-bold text-blue-400">00</div>
                <div class="text-blue-200">ساعات</div>
            </div>
            <div class="bg-blue-900/30 rounded-lg p-4 text-center border border-blue-400/20 backdrop-blur-sm">
                <div id="minutes" class="text-3xl font-bold text-blue-400">00</div>
                <div class="text-blue-200">دقائق</div>
            </div>
            <div class="bg-blue-900/30 rounded-lg p-4 text-center border border-blue-400/20 backdrop-blur-sm">
                <div id="seconds" class="text-3xl font-bold text-blue-400">00</div>
                <div class="text-blue-200">ثواني</div>
            </div>
        </div>

        <!-- نموذج الاشتراك -->
        <div
            class="max-w-md mx-auto bg-blue-900/20 rounded-xl p-8 border border-blue-400/30 backdrop-blur-sm animate__animated animate__fadeInUp animate__delay-3s">
            @include('components.alerts')
            <h3 class="text-xl font-bold text-center mb-4 text-blue-300">كن أول من يعرف عند الإطلاق!</h3>
            <form class="space-y-4" action="{{ route('subscribe') }}" method="POST">
                @csrf
                <input type="text" placeholder="اسمك" name="name"
                    class="w-full px-4 py-3 rounded-lg bg-blue-900/40 border border-blue-400/30 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="email" placeholder="بريدك الإلكتروني" name="email"
                    class="w-full px-4 py-3 rounded-lg bg-blue-900/40 border border-blue-400/30 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="tel" placeholder="رقم هاتفك" name="phone"
                    class="w-full px-4 py-3 rounded-lg bg-blue-900/40 border border-blue-400/30 focus:outline-none focus:ring-2 focus:ring-blue-500 text-right">

                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-bold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105">
                    إشعارني عند الإطلاق <i class="fas fa-paper-plane ml-2"></i>
                </button>
            </form>
        </div>

        <!-- وسائل التواصل -->
        <div
            class="flex justify-around space-x-5 max-w-2xl mx-auto mt-12 animate__animated animate__fadeInUp animate__delay-4s">
            <a href="https://www.instagram.com/alkaser_live"
                class="text-blue-300 hover:text-blue-400 text-2xl transition-all duration-300 transform hover:scale-125">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://twitter.com/alkaser.live"
                class="text-blue-300 hover:text-blue-400 text-2xl transition-all duration-300 transform hover:scale-125">
                <i class="fab fa-twitter"></i>
            </a>
            <a href='https://www.snapchat.com/add/alkaser.live'
                class="text-blue-300 hover:text-blue-400 text-2xl transition-all duration-300 transform hover:scale-125">
                <i class="fab fa-snapchat"></i>
            </a>
            <a href="https://api.whatsapp.com/send?phone=00966511053423"
                class="text-blue-300 hover:text-blue-400 text-2xl transition-all duration-300 transform hover:scale-125">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>

    <!-- الأمواج في الأسفل -->
    <div class="relative">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="absolute bottom-0 w-full">
            <path fill="#0ea5e9" fill-opacity="0.2"
                d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // جسيمات الخلفية
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: "#3b82f6"
                },
                shape: {
                    type: "circle"
                },
                opacity: {
                    value: 0.5,
                    random: true
                },
                size: {
                    value: 3,
                    random: true
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#3b82f6",
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: "none",
                    random: true,
                    straight: false,
                    out_mode: "out"
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: {
                        enable: true,
                        mode: "repulse"
                    },
                    onclick: {
                        enable: true,
                        mode: "push"
                    }
                }
            }
        });

        // عداد التنازلي (اضبط تاريخ الإطلاق هنا)
        const launchDate = new Date("2025-06-04T00:00:00").getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = launchDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("days").innerText = days.toString().padStart(2, "0");
            document.getElementById("hours").innerText = hours.toString().padStart(2, "0");
            document.getElementById("minutes").innerText = minutes.toString().padStart(2, "0");
            document.getElementById("seconds").innerText = seconds.toString().padStart(2, "0");
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
</body>

</html>

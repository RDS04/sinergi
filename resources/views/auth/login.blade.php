<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Metamedia | Login</title>
    <!-- Tailwind CSS v3 + Font Awesome + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'Inter', 'system-ui', 'sans-serif'],
                        'display': ['Playfair Display', 'serif'],
                    },
                    colors: {
                        'metamedia': '#018FD7',
                        'metagold': '#C9A03D',
                        'metalight': '#E8F4FB',
                        'metadark': '#0A5B9F',
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards',
                        'blink-gold': 'blinkGold 1.4s step-end infinite',
                        'float-particle': 'floatParticle 4s ease-in-out infinite',
                        'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        blinkGold: {
                            '0%, 100%': { opacity: '0.5', textShadow: '0 0 2px #C9A03D' },
                            '50%': { opacity: '1', textShadow: '0 0 10px #FFD966, 0 0 4px #C9A03D' }
                        },
                        floatParticle: {
                            '0%': { transform: 'translateY(0px) translateX(0px)', opacity: '0.6' },
                            '50%': { transform: 'translateY(-18px) translateX(8px)', opacity: '1' },
                            '100%': { transform: 'translateY(0px) translateX(0px)', opacity: '0.6' }
                        },
                        pulseGlow: {
                            '0%, 100%': { boxShadow: '0 0 0 0 rgba(201, 160, 61, 0.4)' },
                            '50%': { boxShadow: '0 0 0 8px rgba(201, 160, 61, 0)' }
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(145deg, #018FD7 0%, #0A5B9F 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 16px;
            position: relative;
            overflow-x: hidden;
        }

        /* Blink emas background particles */
        .gold-particle {
            position: fixed;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(circle, #FFD966, #C9A03D);
            border-radius: 50%;
            opacity: 0;
            animation: blinkParticle 2.2s infinite ease-in-out;
        }

        @keyframes blinkParticle {
            0% { opacity: 0; transform: scale(0.2); }
            35% { opacity: 0.9; transform: scale(1); }
            70% { opacity: 0.5; transform: scale(0.7); }
            100% { opacity: 0; transform: scale(0.1); }
        }

        .auth-container {
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(2px);
            border-radius: 2rem;
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(201, 160, 61, 0.25);
            transition: all 0.3s ease;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #C9A03D;
            font-size: 1rem;
            transition: all 0.2s;
            z-index: 2;
        }

        .auth-input {
            width: 100%;
            padding: 14px 20px 14px 48px;
            border-radius: 60px;
            border: 1.5px solid #e2e8f0;
            background: white;
            font-size: 0.9rem;
            transition: all 0.2s;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }

        .auth-input:focus {
            border-color: #018FD7;
            box-shadow: 0 0 0 3px rgba(1, 143, 215, 0.12);
        }

        .auth-input:focus + i {
            color: #018FD7;
        }

        .btn-auth {
            background: linear-gradient(105deg, #018FD7 0%, #0096E6 100%);
            border: none;
            border-radius: 60px;
            padding: 14px;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            transition: all 0.25s;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(1, 143, 215, 0.5);
        }

        .btn-auth:active {
            transform: translateY(1px);
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid #C9A03D;
            color: #C9A03D;
            font-weight: 600;
        }

        .btn-outline:hover {
            background: rgba(201, 160, 61, 0.1);
            border-color: #E8C468;
        }

        .blink-gold {
            animation: blinkGold 1.4s step-start infinite;
        }

        .float-diamond {
            animation: floatParticle 3s ease-in-out infinite;
        }

        @media (max-width: 480px) {
            .auth-card {
                border-radius: 1.5rem;
            }
            .auth-input {
                padding: 12px 16px 12px 44px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background Blink Emas Particles -->
    <div id="particlesContainer" style="position: fixed; inset: 0; pointer-events: none; z-index: 0;"></div>

    <div class="auth-container">
        <div class="auth-card p-6 md:p-8 animate-fade-in-up">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center gap-2 mb-3">
                    <i class="fas fa-diamond text-2xl text-[#C9A03D] float-diamond"></i>
                    <i class="fas fa-diamond text-xl text-[#018FD7] float-diamond" style="animation-delay: 0.4s;"></i>
                </div>
                <h1 class="font-display text-2xl font-bold text-[#018FD7] tracking-tight">Metamedia<span class="text-[#C9A03D] blink-gold">+</span></h1>
                <p class="text-xs text-gray-500 mt-1">Akses Kolaborasi & Sinergi Karir</p>
            </div>

            <!-- Title Login -->
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-[#018FD7]">Masuk ke Akun</h2>
                <p class="text-xs text-gray-400 mt-1">Selamat datang kembali di keluarga besar Metamedia</p>
            </div>

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="bg-red-400/20 border border-red-400 text-red-400 px-4 py-3 rounded-lg text-sm mb-5">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Alert -->
            @if (session('success'))
                <div class="bg-green-400/20 border border-green-400 text-green-400 px-4 py-3 rounded-lg text-sm mb-5">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Login (hanya username & password) -->
            <form id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <i class="fas fa-user-circle"></i>
                    <input type="text" name="username" class="auth-input" placeholder="Username" id="loginUsername" autocomplete="username" required value="{{ old('username') }}">
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="auth-input" placeholder="Kata Sandi" id="loginPassword" required>
                </div>
                <div class="flex justify-between items-center mb-5">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="rememberMe" name="remember" class="accent-[#018FD7]">
                        <label for="rememberMe" class="text-xs text-gray-500">Ingat saya</label>
                    </div>
                    <a href="#" class="text-xs text-[#018FD7] hover:text-[#C9A03D] transition">Lupa password?</a>
                </div>
                <button type="submit" class="btn-auth">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <!-- Separator -->
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400">atau</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <!-- Social Login -->
            <div class="text-center">
                <p class="text-xs text-gray-400 mb-3">Masuk dengan akun sosial</p>
                <div class="flex justify-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-[#018FD7] cursor-pointer hover:bg-gray-200 transition hover:scale-105"><i class="fab fa-google"></i></div>
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-[#018FD7] cursor-pointer hover:bg-gray-200 transition hover:scale-105"><i class="fab fa-linkedin-in"></i></div>
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-[#018FD7] cursor-pointer hover:bg-gray-200 transition hover:scale-105"><i class="fab fa-facebook-f"></i></div>
                </div>
            </div>

            <!-- Link ke Register -->
            <div class="mt-6 pt-4 text-center border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-[#018FD7] font-semibold hover:text-[#C9A03D] transition">Daftar sekarang</a>
                </p>
            </div>

            <!-- Footer -->
            <div class="mt-4 text-center">
                <p class="text-[10px] text-gray-400 flex items-center justify-center gap-1">
                    <i class="fas fa-diamond text-[#C9A03D] text-[8px] blink-gold"></i> 
                    Sinergi Keluarga Besar Metamedia
                    <i class="fas fa-diamond text-[#C9A03D] text-[8px] blink-gold" style="animation-delay: 0.5s;"></i>
                </p>
            </div>
        </div>
    </div>

    <script>
        // ========== EFEK BACKGROUND BLINK EMAS ==========
        const particlesContainer = document.getElementById('particlesContainer');
        function createGoldParticle() {
            const particle = document.createElement('div');
            particle.classList.add('gold-particle');
            const size = Math.random() * 7 + 2.5;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDuration = Math.random() * 1.8 + 1.0 + 's';
            particle.style.animationDelay = Math.random() * 2 + 's';
            particlesContainer.appendChild(particle);
            setTimeout(() => {
                if(particle && particle.remove) particle.remove();
            }, 2200);
        }
        
        setInterval(() => {
            for(let i=0; i<2; i++) createGoldParticle();
        }, 650);
        for(let i=0;i<14;i++) setTimeout(() => createGoldParticle(), i*150);
    </script>
</body>
</html>
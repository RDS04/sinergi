<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Metamedia Collab Day | Mobile Undangan</title>
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
                        'fade-in-up': 'fadeInUp 0.7s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards',
                        'blink-gold': 'blinkGold 1.2s step-end infinite',
                        'soft-pulse': 'softPulse 1.8s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        blinkGold: {
                            '0%, 100%': { opacity: '0.3', textShadow: '0 0 2px #C9A03D' },
                            '50%': { opacity: '1', textShadow: '0 0 12px #FFD966, 0 0 6px #C9A03D' }
                        },
                        softPulse: {
                            '0%': { transform: 'scale(1)', opacity: '0.6' },
                            '100%': { transform: 'scale(1.1)', opacity: '0' }
                        }
                    },
                    backgroundImage: {
                        'gold-gradient': 'linear-gradient(135deg, #C9A03D 0%, #E8C468 70%, #C9A03D 100%)',
                        'blue-glow': 'radial-gradient(circle at center, #018FD7 0%, #016aa3 100%)',
                    }
                }
            }
        }
    </script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background: #018FD7;
            overflow-x: hidden;
            font-family: 'Poppins', sans-serif;
        }

        /* Blink emas background effect: shimmer & floating gold dust */
        .gold-blink-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .gold-sparkle {
            position: absolute;
            background: radial-gradient(circle, #FFD966, #C9A03D);
            border-radius: 50%;
            opacity: 0;
            animation: sparkleFlash 1.6s infinite ease-in-out;
            box-shadow: 0 0 6px rgba(201, 160, 61, 0.8);
        }

        @keyframes sparkleFlash {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }

            30% {
                opacity: 0.9;
                transform: scale(1);
            }

            70% {
                opacity: 0.5;
                transform: scale(0.8);
            }

            100% {
                opacity: 0;
                transform: scale(0.2);
            }
        }



        /* Hide desktop wide layouts, force mobile max-width */
        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            background: #018FD7;
            position: relative;
            z-index: 5;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        /* Disable any large desktop spacing */
        @media (min-width: 640px) {
            .mobile-container {
                max-width: 480px;
                margin: 0 auto;
            }

            body {
                background: #018FD7;
                display: flex;
                justify-content: center;
            }

            .gold-blink-bg {
                max-width: 480px;
                left: 50%;
                transform: translateX(-50%);
                width: 480px;
            }
        }

        /* Card styling */
        .premium-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(2px);
        }

        .ornament {
            background: linear-gradient(90deg, transparent, #C9A03D, #E8C468, #C9A03D, transparent);
            height: 2px;
            width: 70%;
        }

        input,
        select {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(201, 160, 61, 0.5);
            transition: all 0.2s;
        }

        input:focus,
        select:focus {
            border-color: #C9A03D;
            background: rgba(1, 143, 215, 0.15);
            outline: none;
        }

        ::-webkit-scrollbar {
            width: 3px;
        }

        ::-webkit-scrollbar-track {
            background: #016aa3;
        }

        ::-webkit-scrollbar-thumb {
            background: #C9A03D;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <!-- Background Blink Emas : sparkling gold particles dynamic -->
    <div class="gold-blink-bg" id="goldSparkleContainer"></div>

    <div class="mobile-container relative z-10">
        <!-- Splash Screen (Cover) Full Screen dengan Animasi Bintang -->
        <div id="splashScreen"
            class="fixed inset-0 z-50 w-screen h-screen flex items-center justify-center transition-all duration-700 overflow-hidden"
            style="background: linear-gradient(135deg, #018FD7 0%, #016aa3 100%);">

            <!-- Animated Stars Background -->
            <div class="absolute inset-0 overflow-hidden">
                <!-- Star Container untuk animasi -->
                <div id="starsContainer" class="absolute inset-0"></div>
            </div>

            <!-- Splash Content -->
            <div
                class="relative z-10 text-center w-full h-full flex items-center justify-center px-5 animate-fade-in-up">
                <div
                    class="rounded-3xl p-8 bg-white shadow-2xl border border-[#C9A03D]/60 w-full max-w-md h-[90vh] overflow-y-auto flex flex-col justify-center">
                    <div class="mb-3">
                        <p class="text-[#C9A03D] text-[11px] font-bold tracking-[3px] uppercase">Universitas Metamedia
                        </p>
                    </div>
                    <i class="fas fa-diamond text-[#C9A03D] text-lg mb-2 inline-block"></i>
                    <p class="text-[11px] text-[#C9A03D] font-light mb-2 tracking-wide">Mengundang Anda Hadir di</p>
                    <h1 class="font-display text-4xl font-bold text-[#018FD7] leading-tight">Kolaborasi <br>Kampus</h1>
                    <p class="text-xs text-[#C9A03D] italic font-light mt-1">Universitas Metamedia & ENBI Group</p>
                    <div class="flex items-center justify-center gap-2 my-4">
                        <div class="w-8 h-[1px] bg-[#C9A03D]"></div>
                        <i class="fas fa-diamond text-[#C9A03D] text-sm"></i>
                        <div class="w-8 h-[1px] bg-[#C9A03D]"></div>
                    </div>
                    <p class="text-[#018FD7] text-[11px] tracking-wide uppercase font-bold">Kepada Yth.</p>
                    <h2 class="text-2xl font-display font-bold text-[#C9A03D] my-2">Tamu Undangan</h2>
                    <div class="w-10 h-[1px] bg-[#C9A03D] mx-auto my-3"></div>
                    <p class="text-xs text-[#016aa3] leading-relaxed px-1">Dengan penuh kebanggaan, kami mengundang Anda
                        untuk hadir dan menyaksikan momen bersejarah Kolaborasi Universitas Metamedia & ENBI Group
                        antara kampus dan industri yang membuka lembaran baru. Kehadiran Anda adalah kehormatan bagi
                        kami.</p>
                    <button id="openInvitationBtn"
                        class="mt-6 w-full py-3 rounded-full bg-gradient-to-r from-[#C9A03D] to-[#E8B84A] text-[#018FD7] font-extrabold text-sm shadow-xl transition-transform active:scale-95 flex items-center justify-center gap-2 border border-white/30 hover:shadow-2xl">
                        <i class="fas fa-envelope-open-text"></i> BUKA UNDANGAN
                    </button>
                    <p class="text-[#018FD7]/50 text-[10px] mt-4">✨ Tap untuk melanjutkan ✨</p>
                </div>
            </div>



            <style>
                @keyframes twinkleStar {

                    0%,
                    100% {
                        opacity: 0.3;
                        transform: scale(1);
                    }

                    50% {
                        opacity: 1;
                        transform: scale(1.2);
                    }
                }

                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .animate-fade-in-up {
                    animation: fadeInUp 0.7s ease-out forwards;
                }
            </style>
        </div>

        <!-- Main Content Invitation (Mobile optimized, no desktop breakpoints) -->
        <div class="gold-blink-bg" id="goldSparkleContainer"></div>
        <div id="invitationContent" class="hidden opacity-0 transition-opacity duration-700">
            <!-- Hero Section dengan tema #018FD7 dan blink gold -->
            <div class="relative min-h-[85vh] flex flex-col justify-center items-center text-center px-5 pt-12 pb-16 overflow-hidden"
                style="background: linear-gradient(rgba(0,0,0,0.45), rgba(1,79,159,0.6)), url('{{ asset("img/metamedia.jpg") }}') center/cover no-repeat;">
                <!-- Animated Stars Background -->
                <div id="heroStars" class="absolute inset-0"></div>
                <div class="absolute inset-0 bg-black/5"></div>

                <!-- Logo Top Left -->
                <div
                    class="absolute top-6 left-5 z-20 bg-white/20 backdrop-blur-sm rounded-lg p-2 border border-white/30">
                    <img src="{{ asset('storage/logo.png') }}" alt="Metamedia" class="h-12 w-12 object-contain">
                </div>

                <!-- Logo Top Right -->
                <div
                    class="absolute top-6 right-5 z-20 bg-white/20 backdrop-blur-sm rounded-lg p-2 border border-white/30">
                    <img src="{{ asset('storage/enbi.webp') }}" alt="ENBI" class="h-12 w-12 object-contain">
                </div>

                <div class="relative z-2 w-full">
                    <div
                        class="inline-block mb-4 px-3 py-1 rounded-full border border-[#C9A03D] bg-[#018FD7]/80 backdrop-blur-sm">
                        <span class="text-[11px] tracking-wider text-[#FFD966]"><i class="fas fa-calendar-alt mr-1"></i>
                            Save the Date</span>
                    </div>
                    <h1 class="font-display text-3xl font-black leading-tight text-white drop-shadow-xl">
                        Metamedia<br>Collaboration Day
                    </h1>
                    <div class="flex justify-center gap-2 my-4">
                        <i class="fas fa-diamond text-[#C9A03D] text-sm"></i>
                        <i class="fas fa-diamond text-[#C9A03D] text-sm"></i>
                        <i class="fas fa-diamond text-[#C9A03D] text-sm"></i>
                    </div>
                    <p class="text-white text-base italic font-light max-w-xs mx-auto">"Sinergi Keluarga Besar Metamedia
                        menuju Masa Depan Karir"</p>
                    <div class="w-24 h-[1px] bg-[#C9A03D] mx-auto my-5"></div>
                    <div class="space-y-2 text-white/90 text-sm">
                        <div><i class="fas fa-map-marker-alt text-[#FFD966] mr-2"></i> Metamedia Hall & Convention</div>
                        <div><i class="far fa-calendar-check text-[#FFD966] mr-2"></i> Sabtu, 14 Juni 2025</div>
                        <div><i class="far fa-clock text-[#FFD966] mr-2"></i> 08.00 - 17.00 WIB</div>
                    </div>

                    <!-- Countdown Timer Section -->
                    <div
                        class="mt-8 relative bg-white/15 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-lg overflow-hidden">
                        <!-- Animated Stars Background -->
                        <div id="countdownStars" class="absolute inset-0 rounded-2xl"></div>

                        <!-- Content -->
                        <div class="relative z-10">
                            <p class="text-white/80 text-xs tracking-widest uppercase mb-4">Hitung Mundur Acara</p>
                            <div class="grid grid-cols-4 gap-2">
                                <!-- Days -->
                                <div
                                    class="bg-[#FFD966]/20 backdrop-blur-sm rounded-xl p-3 border border-[#FFD966]/40 text-center">
                                    <div class="text-2xl font-black text-[#FFD966]" id="days">00</div>
                                    <p class="text-white/70 text-[10px] mt-1 uppercase tracking-wide">Hari</p>
                                </div>
                                <!-- Hours -->
                                <div
                                    class="bg-[#FFD966]/20 backdrop-blur-sm rounded-xl p-3 border border-[#FFD966]/40 text-center">
                                    <div class="text-2xl font-black text-[#FFD966]" id="hours">00</div>
                                    <p class="text-white/70 text-[10px] mt-1 uppercase tracking-wide">Jam</p>
                                </div>
                                <!-- Minutes -->
                                <div
                                    class="bg-[#FFD966]/20 backdrop-blur-sm rounded-xl p-3 border border-[#FFD966]/40 text-center">
                                    <div class="text-2xl font-black text-[#FFD966]" id="minutes">00</div>
                                    <p class="text-white/70 text-[10px] mt-1 uppercase tracking-wide">Menit</p>
                                </div>
                                <!-- Seconds -->
                                <div
                                    class="bg-[#FFD966]/20 backdrop-blur-sm rounded-xl p-3 border border-[#FFD966]/40 text-center">
                                    <div class="text-2xl font-black text-[#FFD966]" id="seconds">00</div>
                                    <p class="text-white/70 text-[10px] mt-1 uppercase tracking-wide">Detik</p>
                                </div>
                            </div>
                            <p class="text-white/60 text-[10px] text-center mt-4">
                                <i class="fas fa-hourglass-end text-[#FFD966] mr-1"></i> Segera dimulai! Bersiaplah
                                untuk
                                momen spektakuler
                            </p>
                        </div>
                    </div>
                    <div class="mt-8 animate-bounce">
                        <i class="fas fa-chevron-down text-[#FFD966] text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Invitation Call Section -->
            <div class="relative bg-white px-4 sm:px-6 py-12 sm:py-16 overflow-hidden">
                <!-- Subtle animated background -->
                <div id="invitationCallStars" class="absolute inset-0 opacity-30"></div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <!-- Main Heading -->
                    <div class="mb-10 sm:mb-12 text-center">
                        <h2
                            class="font-display text-3xl sm:text-4xl md:text-5xl font-black text-[#018FD7] leading-tight mb-4">
                            Kami Mengundang Anda
                        </h2>
                        <div class="flex justify-center mb-6">
                            <div
                                class="w-32 h-1.5 bg-gradient-to-r from-[#018FD7] via-[#C9A03D] to-[#018FD7] rounded-full shadow-md">
                            </div>
                        </div>
                        <p class="text-base sm:text-lg text-[#016aa3] font-light italic leading-relaxed">
                            Bergabunglah dalam Metamedia Collaboration Day dan rasakan energi kolaborasi keluarga besar
                            kami
                        </p>
                    </div>

                    <!-- Three Invitation Targets -->
                    <div class="grid grid-cols-1 gap-4 sm:gap-5 mb-10 sm:mb-12">
                        <!-- Mahasiswa -->
                        <div
                            class="group overflow-hidden rounded-3xl bg-gradient-to-br from-[#018FD7]/5 via-white to-[#E8F4FB] border-2 border-[#018FD7]/20 hover:border-[#C9A03D] transition-all duration-500 hover:shadow-xl hover:-translate-y-1 cursor-pointer active:scale-95">
                            <div class="p-6 sm:p-8">
                                <div class="flex items-start gap-4 sm:gap-5">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="flex items-center justify-center h-14 w-14 sm:h-16 sm:w-16 rounded-2xl bg-gradient-to-br from-[#018FD7] to-[#0A5B9F] group-hover:scale-110 transition-transform duration-300 shadow-md">
                                            <i class="fas fa-graduation-cap text-white text-2xl sm:text-3xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <h3 class="text-lg sm:text-xl font-bold text-[#016aa3] mb-2">Para Mahasiswa</h3>
                                        <p class="text-[#016aa3]/75 text-sm sm:text-base leading-relaxed font-light">
                                            Dapatkan wawasan karir terbaru, networking dengan profesional, dan
                                            kesempatan emas meraih doorprize eksklusif. Bangun masa depan karir Anda
                                            bersama kami!
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="h-1 w-0 bg-gradient-to-r from-[#018FD7] to-[#C9A03D] group-hover:w-full transition-all duration-500">
                            </div>
                        </div>

                        <!-- Alumni -->
                        <div
                            class="group overflow-hidden rounded-3xl bg-gradient-to-br from-[#018FD7]/5 via-white to-[#E8F4FB] border-2 border-[#018FD7]/20 hover:border-[#C9A03D] transition-all duration-500 hover:shadow-xl hover:-translate-y-1 cursor-pointer active:scale-95">
                            <div class="p-6 sm:p-8">
                                <div class="flex items-start gap-4 sm:gap-5">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="flex items-center justify-center h-14 w-14 sm:h-16 sm:w-16 rounded-2xl bg-gradient-to-br from-[#018FD7] to-[#0A5B9F] group-hover:scale-110 transition-transform duration-300 shadow-md">
                                            <i class="fas fa-handshake text-white text-2xl sm:text-3xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <h3 class="text-lg sm:text-xl font-bold text-[#016aa3] mb-2">Para Alumni</h3>
                                        <p class="text-[#016aa3]/75 text-sm sm:text-base leading-relaxed font-light">
                                            Kembali berkumpul dengan teman-teman lama, berbagi pengalaman sukses, dan
                                            berkolaborasi dalam membangun ekosistem karir yang berkelanjutan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="h-1 w-0 bg-gradient-to-r from-[#018FD7] to-[#C9A03D] group-hover:w-full transition-all duration-500">
                            </div>
                        </div>

                        <!-- Orang Tua -->
                        <div
                            class="group overflow-hidden rounded-3xl bg-gradient-to-br from-[#018FD7]/5 via-white to-[#E8F4FB] border-2 border-[#018FD7]/20 hover:border-[#C9A03D] transition-all duration-500 hover:shadow-xl hover:-translate-y-1 cursor-pointer active:scale-95">
                            <div class="p-6 sm:p-8">
                                <div class="flex items-start gap-4 sm:gap-5">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="flex items-center justify-center h-14 w-14 sm:h-16 sm:w-16 rounded-2xl bg-gradient-to-br from-[#018FD7] to-[#0A5B9F] group-hover:scale-110 transition-transform duration-300 shadow-md">
                                            <i class="fas fa-heart text-white text-2xl sm:text-3xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <h3 class="text-lg sm:text-xl font-bold text-[#016aa3] mb-2">Para Orang Tua</h3>
                                        <p class="text-[#016aa3]/75 text-sm sm:text-base leading-relaxed font-light">
                                            Saksikan perkembangan anak-anak Anda dan pelajari peluang karir di era
                                            digital. Dukung perjalanan pendidikan dan karir generasi muda Metamedia!
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="h-1 w-0 bg-gradient-to-r from-[#018FD7] to-[#C9A03D] group-hover:w-full transition-all duration-500">
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Call to Action -->
                    <div
                        class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#018FD7] via-[#016aa3] to-[#0A5B9F] p-6 sm:p-8 border-2 border-[#C9A03D]/40 shadow-2xl">
                        <!-- Decorative background elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#FFD966] opacity-5 rounded-full blur-3xl">
                        </div>
                        <div class="absolute bottom-0 left-0 w-40 h-40 bg-[#C9A03D] opacity-5 rounded-full blur-3xl">
                        </div>

                        <!-- Content -->
                        <div class="relative z-10">
                            <p
                                class="text-white/95 text-base sm:text-lg mb-3 font-light flex items-center justify-center">
                                <i class="fas fa-star text-[#FFD966] mr-2"></i>
                                <span>Jadilah bagian dari keluarga besar Metamedia</span>
                            </p>
                            <p class="text-[#FFD966] font-bold text-lg sm:text-xl mb-6 text-center">
                                dan rasakan pengalaman yang tak terlupakan
                            </p>
                            <p class="text-white text-sm sm:text-base font-semibold text-center mb-6">
                                Sinergi Keluarga Besar Menuju Masa Depan Karir
                            </p>
                            <div class="flex justify-center">
                                <a href="#rsvpForm"
                                    class="inline-block bg-[#FFD966] text-[#016aa3] font-extrabold py-3 sm:py-4 px-8 sm:px-10 rounded-full hover:bg-white transition-all shadow-lg hover:shadow-2xl transform hover:scale-105 active:scale-95 text-base sm:text-lg flex items-center gap-2">
                                    <i class="fas fa-arrow-down text-lg"></i>
                                    <span>Daftar Sekarang</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agenda / Timeline mobile friendly -->
            <div
                class="relative bg-gradient-to-b from-[#018FD7] to-[#016aa3] px-4 sm:px-6 py-12 sm:py-16 overflow-hidden">
                <!-- Animated Stars Background -->
                <div id="agendaStars" class="absolute inset-0"></div>
                <!-- Content -->
                <div class="relative z-10">
                    <div class="text-center mb-8 sm:mb-10">
                        <span class="text-[#FFD966] text-xs tracking-widest uppercase font-bold inline-block mb-3">
                            <i class="far fa-clock mr-2"></i>RUNDOWN ACARA
                        </span>
                        <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mt-2 leading-tight">
                            Alur Sinergi <span class="text-[#FFD966]">Hari Kolaborasi</span>
                        </h2>
                    </div>
                    <div class="relative max-w-2xl mx-auto">
                        <!-- Vertical Line for timeline -->
                        <div
                            class="absolute left-4 sm:left-8 top-0 bottom-0 w-1 bg-gradient-to-b from-[#FFD966] via-[#C9A03D] to-[#FFD966] hidden sm:block">
                        </div>

                        <div class="space-y-4 sm:space-y-5">
                            <!-- Timeline item 1 -->
                            <div class="relative">
                                <div
                                    class="absolute -left-2 sm:left-0 top-4 w-5 h-5 bg-[#FFD966] rounded-full border-4 border-[#016aa3] z-20 hidden sm:block">
                                </div>
                                <div
                                    class="bg-white/15 backdrop-blur-sm rounded-2xl p-5 sm:p-6 border-l-4 border-[#FFD966] sm:border-l-0 sm:ml-24 hover:bg-white/20 transition-all duration-300 hover:shadow-lg group cursor-pointer">
                                    <div class="flex items-start gap-3 sm:gap-0">
                                        <div
                                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-[#FFD966]/20 border border-[#FFD966]/50 flex-shrink-0 sm:hidden group-hover:scale-110 transition-transform">
                                            <span class="text-[#FFD966] font-bold">08:00</span>
                                        </div>
                                        <div class="flex-1">
                                            <div
                                                class="text-2xl sm:text-3xl font-black text-[#FFD966] mb-2 hidden sm:block">
                                                08.00</div>
                                            <h3 class="font-bold text-white text-base sm:text-lg mb-1">Registrasi &
                                                Coffee Morning</h3>
                                            <p class="text-white/70 text-sm sm:text-base">Keluarga besar berkumpul,
                                                ramah tamah dan networking awal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline item 2 -->
                            <div class="relative">
                                <div
                                    class="absolute -left-2 sm:left-0 top-4 w-5 h-5 bg-[#FFD966] rounded-full border-4 border-[#016aa3] z-20 hidden sm:block">
                                </div>
                                <div
                                    class="bg-white/15 backdrop-blur-sm rounded-2xl p-5 sm:p-6 border-l-4 border-[#FFD966] sm:border-l-0 sm:ml-24 hover:bg-white/20 transition-all duration-300 hover:shadow-lg group cursor-pointer">
                                    <div class="flex items-start gap-3 sm:gap-0">
                                        <div
                                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-[#FFD966]/20 border border-[#FFD966]/50 flex-shrink-0 sm:hidden group-hover:scale-110 transition-transform">
                                            <span class="text-[#FFD966] font-bold">09:30</span>
                                        </div>
                                        <div class="flex-1">
                                            <div
                                                class="text-2xl sm:text-3xl font-black text-[#FFD966] mb-2 hidden sm:block">
                                                09.30</div>
                                            <h3 class="font-bold text-white text-base sm:text-lg mb-1">Opening & Keynote
                                                Speech</h3>
                                            <p class="text-white/70 text-sm sm:text-base">"Masa Depan Karir di Ekosistem
                                                Media"</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline item 3 -->
                            <div class="relative">
                                <div
                                    class="absolute -left-2 sm:left-0 top-4 w-5 h-5 bg-[#FFD966] rounded-full border-4 border-[#016aa3] z-20 hidden sm:block">
                                </div>
                                <div
                                    class="bg-white/15 backdrop-blur-sm rounded-2xl p-5 sm:p-6 border-l-4 border-[#FFD966] sm:border-l-0 sm:ml-24 hover:bg-white/20 transition-all duration-300 hover:shadow-lg group cursor-pointer">
                                    <div class="flex items-start gap-3 sm:gap-0">
                                        <div
                                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-[#FFD966]/20 border border-[#FFD966]/50 flex-shrink-0 sm:hidden group-hover:scale-110 transition-transform">
                                            <span class="text-[#FFD966] font-bold">13:00</span>
                                        </div>
                                        <div class="flex-1">
                                            <div
                                                class="text-2xl sm:text-3xl font-black text-[#FFD966] mb-2 hidden sm:block">
                                                13.00</div>
                                            <h3 class="font-bold text-white text-base sm:text-lg mb-1">Panel Kolaborasi
                                            </h3>
                                            <p class="text-white/70 text-sm sm:text-base">Sharing session bersama para
                                                expert dan industry leader</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline item 4 -->
                            <div class="relative">
                                <div
                                    class="absolute -left-2 sm:left-0 top-4 w-5 h-5 bg-[#FFD966] rounded-full border-4 border-[#016aa3] z-20 hidden sm:block">
                                </div>
                                <div
                                    class="bg-white/15 backdrop-blur-sm rounded-2xl p-5 sm:p-6 border-l-4 border-[#FFD966] sm:border-l-0 sm:ml-24 hover:bg-white/20 transition-all duration-300 hover:shadow-lg group cursor-pointer">
                                    <div class="flex items-start gap-3 sm:gap-0">
                                        <div
                                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-[#FFD966]/20 border border-[#FFD966]/50 flex-shrink-0 sm:hidden group-hover:scale-110 transition-transform">
                                            <span class="text-[#FFD966] font-bold">15:30</span>
                                        </div>
                                        <div class="flex-1">
                                            <div
                                                class="text-2xl sm:text-3xl font-black text-[#FFD966] mb-2 hidden sm:block">
                                                15.30</div>
                                            <h3 class="font-bold text-white text-base sm:text-lg mb-1">Penutupan &
                                                Networking</h3>
                                            <p class="text-white/70 text-sm sm:text-base">Kesepakatan kolaborasi,
                                                doorprize, dan foto bersama</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quote sinergi dengan background emas blink halus -->
            <div
                class="bg-gradient-to-br from-[#E8F4FB] via-white to-[#E8F4FB] px-4 sm:px-6 py-12 sm:py-16 text-center relative overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute top-0 left-0 w-32 h-32 bg-[#018FD7] opacity-3 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-[#C9A03D] opacity-3 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <div class="flex justify-center mb-4">
                        <i class="fas fa-quote-left text-4xl sm:text-5xl text-[#C9A03D] opacity-50"></i>
                    </div>
                    <p
                        class="text-base sm:text-lg md:text-xl font-light text-[#016aa3] leading-relaxed max-w-3xl mx-auto mb-8 px-2">
                        "Keluarga besar Metamedia bergerak dalam harmoni, membangun karir masa depan dengan inovasi
                        tanpa batas."
                    </p>
                    <div class="flex flex-wrap justify-center gap-6 sm:gap-8">
                        <div class="flex flex-col items-center group cursor-pointer">
                            <div
                                class="flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#018FD7]/10 to-[#016aa3]/10 group-hover:from-[#018FD7]/20 group-hover:to-[#016aa3]/20 border border-[#018FD7]/20 group-hover:border-[#C9A03D]/50 transition-all duration-300 group-hover:scale-110 mb-3">
                                <i class="fas fa-bullhorn text-2xl sm:text-3xl text-[#018FD7]"></i>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-[#016aa3]">Media Partner</span>
                        </div>
                        <div class="flex flex-col items-center group cursor-pointer">
                            <div
                                class="flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#018FD7]/10 to-[#016aa3]/10 group-hover:from-[#018FD7]/20 group-hover:to-[#016aa3]/20 border border-[#018FD7]/20 group-hover:border-[#C9A03D]/50 transition-all duration-300 group-hover:scale-110 mb-3">
                                <i class="fas fa-graduation-cap text-2xl sm:text-3xl text-[#018FD7]"></i>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-[#016aa3]">Career Center</span>
                        </div>
                        <div class="flex flex-col items-center group cursor-pointer">
                            <div
                                class="flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#018FD7]/10 to-[#016aa3]/10 group-hover:from-[#018FD7]/20 group-hover:to-[#016aa3]/20 border border-[#018FD7]/20 group-hover:border-[#C9A03D]/50 transition-all duration-300 group-hover:scale-110 mb-3">
                                <i class="fas fa-chart-line text-2xl sm:text-3xl text-[#018FD7]"></i>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-[#016aa3]">Future Skills</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Showcase - Premium Tech Experience -->
            <div
                class="relative bg-gradient-to-b from-[#016aa3] to-[#0A5B9F] px-4 sm:px-6 py-12 sm:py-16 overflow-hidden">
                <!-- Animated Stars Background -->
                <div id="doorprizeStars" class="absolute inset-0"></div>
                <!-- Background decorative elements -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-[#C9A03D] opacity-5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-[#FFD966] opacity-5 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <!-- Header -->
                    <div class="text-center mb-8 sm:mb-12">
                        <span
                            class="inline-block px-3 sm:px-4 py-1.5 rounded-full border-2 border-[#C9A03D] bg-[#018FD7]/60 backdrop-blur-sm mb-3">
                            <span class="text-[#FFD966] text-xs sm:text-sm tracking-widest font-bold">
                                <i class="fas fa-gift mr-2"></i>DOORPRIZE MENARIK
                            </span>
                        </span>
                        <h2 class="font-display text-3xl sm:text-4xl font-bold text-white leading-tight mb-4">
                            Hadiah <span class="text-[#FFD966]">Premium</span> Menanti<br />Peserta Beruntung
                        </h2>
                        <p class="text-white/75 text-sm sm:text-base">Kesempatan emas memenangkan gadget flagship
                            terbaru di acara sinergi kami</p>
                    </div>

                    <!-- Product Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8">
                        <!-- iPhone 17 Pro -->
                        <div class="group relative">
                            <div
                                class="relative bg-white/15 backdrop-blur-md rounded-3xl p-6 border-2 border-white/20 overflow-hidden transition-all duration-500 hover:bg-white/25 hover:border-[#FFD966] hover:shadow-2xl cursor-pointer">
                                <!-- Glow effect on hover -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-b from-[#FFD966]/0 to-[#C9A03D]/0 group-hover:from-[#FFD966]/10 group-hover:to-[#C9A03D]/10 transition-all duration-500">
                                </div>

                                <div class="relative z-5 flex flex-col items-center h-full">
                                    <img src="{{ asset('storage/17 pro.webp') }}" alt="iPhone 17 Pro"
                                        class="w-28 sm:w-32 h-40 sm:h-48 object-contain mb-4 drop-shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <div class="text-center w-full">
                                        <h3 class="text-white font-bold text-lg sm:text-xl mb-2">iPhone 17 Pro</h3>
                                        <p
                                            class="text-[#FFD966] text-xs sm:text-sm font-bold px-3 py-1.5 rounded-full bg-[#FFD966]/20 border border-[#FFD966]/40 inline-block">
                                            🏆 Hadiah Utama
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MacBook -->
                        <div class="group relative">
                            <div
                                class="relative bg-white/15 backdrop-blur-md rounded-3xl p-6 border-2 border-white/20 overflow-hidden transition-all duration-500 hover:bg-white/25 hover:border-[#FFD966] hover:shadow-2xl cursor-pointer">
                                <!-- Glow effect on hover -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-b from-[#FFD966]/0 to-[#C9A03D]/0 group-hover:from-[#FFD966]/10 group-hover:to-[#C9A03D]/10 transition-all duration-500">
                                </div>

                                <div class="relative z-5 flex flex-col items-center h-full">
                                    <img src="{{ asset('storage/macbook.jpg') }}" alt="MacBook Pro"
                                        class="w-full h-40 object-contain mb-4 drop-shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <div class="text-center w-full">
                                        <h3 class="text-white font-bold text-lg sm:text-xl mb-2">MacBook Pro</h3>
                                        <p
                                            class="text-[#FFD966] text-xs sm:text-sm font-bold px-3 py-1.5 rounded-full bg-[#FFD966]/20 border border-[#FFD966]/40 inline-block">
                                            💎 Hadiah Istimewa
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prize Highlights -->
                    <div class="grid grid-cols-3 gap-2 sm:gap-3">
                        <div
                            class="bg-white/15 backdrop-blur-sm rounded-2xl p-3 sm:p-4 border-2 border-[#C9A03D]/30 hover:border-[#C9A03D]/70 transition-all hover:bg-white/20 cursor-pointer group">
                            <i
                                class="fas fa-star text-[#FFD966] text-2xl sm:text-3xl mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                            <p class="text-white/90 text-xs sm:text-sm font-bold">Eksklusif</p>
                        </div>
                        <div
                            class="bg-white/15 backdrop-blur-sm rounded-2xl p-3 sm:p-4 border-2 border-[#C9A03D]/30 hover:border-[#C9A03D]/70 transition-all hover:bg-white/20 cursor-pointer group">
                            <i
                                class="fas fa-gem text-[#FFD966] text-2xl sm:text-3xl mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                            <p class="text-white/90 text-xs sm:text-sm font-bold">Premium</p>
                        </div>
                        <div
                            class="bg-white/15 backdrop-blur-sm rounded-2xl p-3 sm:p-4 border-2 border-[#C9A03D]/30 hover:border-[#C9A03D]/70 transition-all hover:bg-white/20 cursor-pointer group">
                            <i
                                class="fas fa-crown text-[#FFD966] text-2xl sm:text-3xl mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                            <p class="text-white/90 text-xs sm:text-sm font-bold">Terbatas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partnership & Collaboration Section -->
            <div class="bg-white px-4 sm:px-6 py-12 sm:py-16 relative overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute top-0 left-0 w-32 h-32 bg-[#018FD7] opacity-3 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-[#C9A03D] opacity-3 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <div class="text-center mb-8 sm:mb-10">
                        <h3 class="font-display text-2xl sm:text-3xl font-bold text-[#016aa3] mb-2">Kolaborasi Strategis
                        </h3>
                        <p class="text-[#016aa3]/70 text-xs sm:text-sm">Partnership dalam Inovasi dan Pengembangan
                            Talenta</p>
                        <div
                            class="w-20 h-1.5 bg-gradient-to-r from-[#018FD7] to-[#C9A03D] rounded-full mx-auto mt-4 shadow-md">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-4">
                        <!-- Metamedia Logo -->
                        <div class="flex flex-col items-center group">
                            <div
                                class="bg-white p-4 rounded-2xl border-2 border-[#018FD7]/20 hover:border-[#018FD7]/60 transition-all shadow-md hover:shadow-lg group-hover:scale-105 mb-3">
                                <img src="{{ asset('storage/logo.png') }}" alt="Universitas Metamedia" class="w-24 h-24 object-contain">
                            </div>
                            <p class="text-[#016aa3] text-xs sm:text-sm font-bold text-center">Universitas<br>Metamedia
                            </p>
                        </div>

                        <!-- Connector -->
                        <div class="hidden sm:flex flex-col items-center gap-3">
                            <div class="w-10 h-[2px] bg-gradient-to-r from-[#C9A03D] to-[#018FD7] rounded-full"></div>
                            <i class="fas fa-handshake text-[#C9A03D] text-2xl"></i>
                            <div class="w-10 h-[2px] bg-gradient-to-r from-[#C9A03D] to-[#018FD7] rounded-full"></div>
                        </div>

                        <!-- ENBI Logo -->
                        <div class="flex flex-col items-center group">
                            <div
                                class="bg-white p-4 rounded-2xl border-2 border-[#018FD7]/20 hover:border-[#018FD7]/60 transition-all shadow-md hover:shadow-lg group-hover:scale-105 mb-3">
                                <img src="{{ asset('storage/enbi.webp') }}" alt="ENBI Group" class="w-24 h-24 object-contain">
                            </div>
                            <p class="text-[#016aa3] text-xs sm:text-sm font-bold text-center">ENBI<br>Group</p>
                        </div>
                    </div>

                    <p class="text-[#016aa3]/70 text-xs sm:text-sm text-center mt-6 sm:mt-8">Bersama membangun ekosistem
                        karir yang berkelanjutan dan inovatif</p>
                </div>
            </div>

            <!-- Lokasi Acara Section -->
            <div
                class="relative bg-gradient-to-b from-[#016aa3] to-[#018FD7] px-4 sm:px-6 py-12 sm:py-16 overflow-hidden">
                <!-- Animated Stars Background -->
                <div id="locationStars" class="absolute inset-0"></div>
                <!-- Content -->
                <div class="relative z-10">
                    <div class="text-center mb-8 sm:mb-10">
                        <span class="text-[#FFD966] text-xs tracking-widest uppercase font-bold inline-block mb-3">
                            <i class="fas fa-map-marker-alt mr-2"></i>LOKASI ACARA
                        </span>
                        <h2 class="font-display text-3xl sm:text-4xl font-bold text-white leading-tight">
                            Kunjungi Kami di<br><span class="text-[#FFD966]">Hotel Truntum Padang</span>
                        </h2>
                    </div>

                    <!-- Maps Container -->
                    <div
                        class="relative bg-white/15 backdrop-blur-md rounded-3xl overflow-hidden border-2 border-white/30 mb-6 shadow-xl">
                        <!-- Responsive Maps Embed -->
                        <div class="relative w-full" style="padding-bottom: 60%;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.2620176161035!2d100.35411877496513!3d-0.956801199033958!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b951e02493e7%3A0x4dcc74dad0400872!2sHotel%20Truntum%20Padang!5e0!3m2!1sid!2sid!4v1780212579258!5m2!1sid!2sid"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; border-radius: 16px;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>

                    <!-- Location Info Cards -->
                    <div class="space-y-3 sm:space-y-4">
                        <div
                            class="group bg-white/15 backdrop-blur-sm rounded-2xl p-4 sm:p-5 border-2 border-white/20 hover:border-[#FFD966]/60 hover:bg-white/20 transition-all duration-300 hover:shadow-lg cursor-pointer">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center w-12 h-12 rounded-xl bg-[#FFD966] group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-building text-[#016aa3] text-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white/70 text-xs sm:text-sm uppercase tracking-wide font-semibold">
                                        Tempat Acara</p>
                                    <p class="text-white font-bold text-base sm:text-lg mt-1">Hotel Truntum Padang</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group bg-white/15 backdrop-blur-sm rounded-2xl p-4 sm:p-5 border-2 border-white/20 hover:border-[#FFD966]/60 hover:bg-white/20 transition-all duration-300 hover:shadow-lg cursor-pointer">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center w-12 h-12 rounded-xl bg-[#FFD966] group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-map-pin text-[#016aa3] text-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white/70 text-xs sm:text-sm uppercase tracking-wide font-semibold">
                                        Alamat</p>
                                    <p class="text-white font-bold text-base sm:text-lg mt-1">Jl. Veteran, Padang,
                                        Sumatera Barat</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group bg-white/15 backdrop-blur-sm rounded-2xl p-4 sm:p-5 border-2 border-white/20 hover:border-[#FFD966]/60 hover:bg-white/20 transition-all duration-300 hover:shadow-lg cursor-pointer">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center w-12 h-12 rounded-xl bg-[#FFD966] group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-clock text-[#016aa3] text-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white/70 text-xs sm:text-sm uppercase tracking-wide font-semibold">
                                        Tanggal & Waktu</p>
                                    <p class="text-white font-bold text-base sm:text-lg mt-1">Sabtu, 19 Juni 2026</p>
                                    <p class="text-[#FFD966] font-semibold text-sm mt-1">08.00 - 17.00 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-8 p-4 sm:p-5 bg-[#FFD966]/20 border-2 border-[#FFD966]/40 rounded-2xl">
                        <p class="text-white/95 text-xs sm:text-sm text-center font-medium">
                            <i class="fas fa-info-circle text-[#FFD966] mr-2"></i>
                            Harap tiba lebih awal untuk registrasi dan networking session
                        </p>
                    </div>
                </div>
            </div>
            <!-- RSVP Form elegan dengan blink efek tombol -->
            <section
                class="py-10 sm:py-16 px-4 sm:px-6 bg-gradient-to-b from-[#018FD7] to-[#016aa3] relative overflow-hidden"
                id="rsvpForm">
                <!-- Decorative background -->
                <div class="absolute top-0 left-0 w-48 h-48 bg-[#C9A03D] opacity-3 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-[#FFD966] opacity-3 rounded-full blur-3xl"></div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <!-- Form Header -->
                    <div class="text-center mb-8 sm:mb-10">
                        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3 font-display">Konfirmasi Kehadiran
                        </h2>
                        <p class="text-white/85 text-sm sm:text-base font-light">Mohon lengkapi data berikut untuk
                            konfirmasi kehadiran Anda</p>
                    </div>

                    <!-- Form Container -->
                    <div class="bg-white/15 backdrop-blur-md rounded-3xl p-6 sm:p-8 border-2 border-white/20 shadow-2xl"
                        id="formContainer">
                        <form id="invitationForm" class="space-y-5 sm:space-y-6">
                            @csrf

                            <!-- Form Fields Section -->
                            <div class="space-y-5">
                                <!-- Nama Mahasiswa -->
                                <div class="group">
                                    <label class="block text-white/95 text-sm sm:text-base font-semibold mb-2.5">Nama
                                        Mahasiswa <span class="text-red-400">*</span></label>
                                    <div class="relative">
                                        <i
                                            class="fas fa-user absolute left-4 top-3.5 text-[#FFD966] text-lg opacity-60"></i>
                                        <input type="text" name="nama_mhs" required
                                            class="w-full pl-12 pr-4 py-3 sm:py-3.5 rounded-xl bg-white/20 border-2 border-white/30 text-white placeholder-white/50 focus:outline-none focus:border-[#FFD966] focus:bg-white/25 transition-all duration-300 group-focus-within:border-[#FFD966]"
                                            placeholder="Masukkan nama lengkap">
                                    </div>
                                    <p class="text-red-300 text-xs mt-2 hidden error-nama_mhs"></p>
                                </div>

                                <!-- Status Dropdown -->
                                <div class="group">
                                    <label class="block text-white/95 text-sm sm:text-base font-semibold mb-2.5">Status
                                        <span class="text-red-400">*</span></label>
                                    <div class="relative">
                                        <i
                                            class="fas fa-graduation-cap absolute left-4 top-3.5 text-[#FFD966] text-lg opacity-60"></i>
                                        <select name="status" required
                                            class="w-full pl-12 pr-4 py-3 sm:py-3.5 rounded-xl bg-white/20 border-2 border-white/30 text-white focus:outline-none focus:border-[#FFD966] focus:bg-white/25 transition-all duration-300 appearance-none cursor-pointer group-focus-within:border-[#FFD966]"
                                            style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'rgba(255,255,255,0.6)\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>'); background-repeat: no-repeat; background-position: right 12px center; background-size: 24px; padding-right: 40px;">
                                            <option value="" disabled selected style="background-color: #016aa3;">Pilih
                                                Status</option>
                                            <option value="mahasiswa" style="background-color: #016aa3;">Mahasiswa
                                            </option>
                                            <option value="alumni" style="background-color: #016aa3;">Alumni</option>
                                        </select>
                                    </div>
                                    <p class="text-red-300 text-xs mt-2 hidden error-status"></p>
                                </div>

                                <!-- Nama Orang Tua -->
                                <div class="group">
                                    <label class="block text-white/95 text-sm sm:text-base font-semibold mb-2.5">Nama
                                        Orang Tua / Wali <span class="text-red-400">*</span></label>
                                    <div class="relative">
                                        <i
                                            class="fas fa-user-tie absolute left-4 top-3.5 text-[#FFD966] text-lg opacity-60"></i>
                                        <input type="text" name="nama_ortu" required
                                            class="w-full pl-12 pr-4 py-3 sm:py-3.5 rounded-xl bg-white/20 border-2 border-white/30 text-white placeholder-white/50 focus:outline-none focus:border-[#FFD966] focus:bg-white/25 transition-all duration-300 group-focus-within:border-[#FFD966]"
                                            placeholder="Masukkan nama orang tua atau wali">
                                    </div>
                                    <p class="text-red-300 text-xs mt-2 hidden error-nama_ortu"></p>
                                </div>

                                <!-- WhatsApp Mahasiswa -->
                                <div class="group">
                                    <label class="block text-white/95 text-sm sm:text-base font-semibold mb-2.5">Nomor
                                        WhatsApp <span class="text-red-400">*</span></label>
                                    <div class="relative">
                                        <i
                                            class="fab fa-whatsapp absolute left-4 top-3.5 text-[#FFD966] text-lg opacity-60"></i>
                                        <input type="text" name="wa_mhs" required
                                            class="w-full pl-12 pr-4 py-3 sm:py-3.5 rounded-xl bg-white/20 border-2 border-white/30 text-white placeholder-white/50 focus:outline-none focus:border-[#FFD966] focus:bg-white/25 transition-all duration-300 group-focus-within:border-[#FFD966]"
                                            placeholder="628xxxxxxxxxx atau format lainnya">
                                    </div>
                                    <p class="text-white/70 text-xs sm:text-sm mt-2">Nomor WhatsApp untuk komunikasi
                                        terkait acara</p>
                                    <p class="text-red-300 text-xs mt-1 hidden error-wa_mhs"></p>
                                </div>
                            </div>

                            <!-- Error Alert -->
                            <div id="errorAlert"
                                class="bg-red-400/25 border-2 border-red-400/50 text-red-300 px-4 py-3 rounded-xl text-xs sm:text-sm hidden flex items-center gap-2">
                                <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                                <span id="errorMessage" class="flex-1"></span>
                            </div>

                            <!-- Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                <button type="submit" id="submitBtn"
                                    class="flex-1 px-6 py-3.5 sm:py-4 bg-gradient-to-r from-[#FFD966] via-[#E8C468] to-[#C9A03D] text-[#016aa3] font-bold text-base sm:text-lg rounded-2xl hover:shadow-2xl hover:shadow-[#FFD966]/50 hover:scale-105 transition-all active:scale-95 duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-paper-plane"></i><span>Kirim Konfirmasi</span>
                                </button>
                                <button type="reset"
                                    class="flex-1 px-6 py-3.5 sm:py-4 bg-white/20 text-white font-bold text-base sm:text-lg rounded-2xl border-2 border-white/40 hover:bg-white/30 hover:border-white/60 transition-all active:scale-95 duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-redo"></i><span>Reset</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Loading Spinner - Hidden by default -->
                    <div id="loadingSpinner"
                        class="hidden bg-white/15 backdrop-blur-md rounded-3xl p-8 border-2 border-white/20 text-center shadow-2xl">
                        <div class="flex flex-col items-center justify-center">
                            <div class="inline-flex items-center justify-center">
                                <div class="relative w-20 h-20">
                                    <div class="absolute inset-0 rounded-full border-4 border-white/20"></div>
                                    <div
                                        class="absolute inset-0 rounded-full border-4 border-transparent border-t-[#FFD966] border-r-[#C9A03D] animate-spin">
                                    </div>
                                </div>
                            </div>
                            <p class="text-white font-bold text-lg sm:text-xl mt-5">Memproses Data...</p>
                            <p class="text-white/75 text-sm mt-2">Kami sedang membuat QR Code Anda</p>
                        </div>
                    </div>

                    <!-- Success & Barcode Display - Hidden by default -->
                    <div id="successContainer" class="hidden space-y-6">
                        <!-- Success Message -->
                        <div
                            class="bg-green-400/25 border-2 border-green-400/50 text-green-300 px-6 py-4 rounded-2xl text-center font-bold text-base sm:text-lg flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle text-lg"></i>Konfirmasi Berhasil!
                        </div>
                        <!-- QR Code Display -->
                        <div
                            class="bg-white/15 backdrop-blur-md rounded-3xl p-6 sm:p-8 border-2 border-white/20 text-center shadow-2xl">
                            <h3 class="text-white font-bold text-xl sm:text-2xl mb-5">Barcode Check-in Anda</h3>
                            <div class="bg-white/30 rounded-2xl p-4 inline-block border-2 border-white/40">
                                <img id="qrCodeImage" src="" alt="QR Code" class="w-64 h-64">
                            </div>
                            <p class="text-white/85 text-sm mt-5">Simpan atau screenshot barcode ini untuk check-in di
                                acara</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col gap-3">
                            <button onclick="openKartu()"
                                class="w-full px-6 py-3.5 bg-[#FFD966] text-[#016aa3] font-bold text-base rounded-2xl hover:shadow-2xl hover:shadow-[#FFD966]/50 hover:scale-105 transition-all active:scale-95 duration-300 flex items-center justify-center gap-2">
                                <i class="fas fa-download"></i><span>Download QR Code</span>
                            </button>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="mt-6 sm:mt-8 p-4 sm:p-5 bg-[#FFD966]/20 border-2 border-[#FFD966]/40 rounded-2xl">
                        <p class="text-white/95 text-xs sm:text-sm text-center font-medium">
                            <i class="fas fa-shield-alt text-[#FFD966] mr-2"></i>
                            Data Anda aman dan hanya digunakan untuk keperluan acara Metamedia Collaboration Day
                        </p>
                    </div>
                </div>
            </section>

            <!-- Footer Elegan -->
            <footer
                class="bg-gradient-to-r from-[#016aa3] to-[#0A5B9F] px-4 sm:px-6 py-8 text-center border-t-2 border-white/10">
                <div class="flex justify-center gap-4 sm:gap-6 mb-4">
                    <a href="#"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-[#FFD966]/20 text-white/80 hover:text-[#FFD966] transition-all duration-300">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-[#FFD966]/20 text-white/80 hover:text-[#FFD966] transition-all duration-300">
                        <i class="fab fa-linkedin-in text-lg"></i>
                    </a>
                    <a href="#"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-[#FFD966]/20 text-white/80 hover:text-[#FFD966] transition-all duration-300">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-[#FFD966]/20 text-white/80 hover:text-[#FFD966] transition-all duration-300">
                        <i class="fab fa-tiktok text-lg"></i>
                    </a>
                </div>
                <p class="text-white/85 text-xs sm:text-sm font-medium mb-1">© 2025 Metamedia Collaboration Day</p>
                <p class="text-white/70 text-xs mb-2">Sinergi Keluarga Besar Menuju Masa Depan Karir</p>
                <p class="text-[#FFD966] text-xs font-semibold">#MetamediaCollabDay | #SinergiMasaDepan</p>
            </footer>
        </div>
    </div>
    <script>
        // // Auto clear cache saat halaman dimuat
        // if (performance.navigation.type === 2) {
        //     // Jika reload dari cache
        //     localStorage.removeItem('invitationQrData');
        //     window.location.reload();
        // }

        (function () {
            // 1. Generate blink-blink emas background (sparkling stars)
            const sparkleContainer = document.getElementById('goldSparkleContainer');
            function createSparkle() {
                const spark = document.createElement('div');
                spark.classList.add('gold-sparkle');
                const size = Math.random() * 8 + 3; // 3px - 11px
                spark.style.width = size + 'px';
                spark.style.height = size + 'px';
                spark.style.left = Math.random() * 100 + '%';
                spark.style.top = Math.random() * 100 + '%';
                const duration = Math.random() * 1.2 + 0.8; // 0.8s - 2s
                spark.style.animationDuration = duration + 's';
                spark.style.animationDelay = Math.random() * 1.5 + 's';
                sparkContainer.appendChild(spark);
                setTimeout(() => {
                    if (spark && spark.remove) spark.remove();
                }, duration * 1000 + 500);
            }
            // generate many sparkles
            setInterval(() => {
                if (document.getElementById('invitationContent') && !document.getElementById('invitationContent').classList.contains('hidden')) {
                    for (let i = 0; i < 3; i++) createSparkle();
                } else {
                    for (let i = 0; i < 2; i++) createSparkle();
                }
            }, 600);
            for (let i = 0; i < 12; i++) setTimeout(() => createSparkle(), i * 200);

            // Splash logic
            const splash = document.getElementById('splashScreen');
            const invitation = document.getElementById('invitationContent');
            const openBtn = document.getElementById('openInvitationBtn');

            function openInvitation() {
                if (!splash || !invitation) return;
                splash.style.opacity = '0';
                splash.style.pointerEvents = 'none';
                setTimeout(() => {
                    splash.style.display = 'none';
                    invitation.classList.remove('hidden');
                    setTimeout(() => {
                        invitation.classList.add('opacity-100');
                        invitation.classList.remove('opacity-0');
                        // smooth scroll sedikit kebawah (mobile)
                        setTimeout(() => {
                            window.scrollTo({ top: 80, behavior: 'smooth' });
                        }, 300);
                    }, 30);
                }, 600);
            }
            if (openBtn) openBtn.addEventListener('click', openInvitation);

            // RSVP AJAX handler
            const invitationForm = document.getElementById('invitationForm');
            const formContainer = document.getElementById('formContainer');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const successContainer = document.getElementById('successContainer');
            const errorAlert = document.getElementById('errorAlert');
            const submitBtn = document.getElementById('submitBtn');

            if (invitationForm) {
                invitationForm.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    // Clear previous errors
                    document.querySelectorAll('[class*="error-"]').forEach(el => {
                        el.classList.add('hidden');
                        el.textContent = '';
                    });
                    errorAlert.classList.add('hidden');

                    // Get form data
                    const formData = new FormData(invitationForm);

                    // Validate phone number (just check if not empty)
                    const wa_mhs = formData.get('wa_mhs');
                    if (!wa_mhs || wa_mhs.trim() === '') {
                        showFieldError('wa_mhs', 'Nomor WhatsApp tidak boleh kosong');
                        return;
                    }

                    // Show loading state
                    submitBtn.disabled = true;
                    formContainer.classList.add('hidden');
                    loadingSpinner.classList.remove('hidden');
                    successContainer.classList.add('hidden');

                    try {
                        // Send AJAX request with FormData (proper way)
                        const response = await fetch('{{ route("invitation.store") }}', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        // Check if response is ok first
                        if (!response.ok) {
                            throw new Error(`HTTP Error: ${response.status}`);
                        }

                        // Try to parse as JSON
                        let data;
                        try {
                            data = await response.json();
                        } catch (parseError) {
                            console.error('JSON Parse Error:', parseError);
                            const textContent = await response.text();
                            console.error('Response text:', textContent);
                            throw new Error('Response tidak valid (bukan JSON)');
                        }

                        if (data.success) {
                            // Success - show QR code and guest info
                            const qrImg = document.getElementById('qrCodeImage');
                            const nameEl = document.getElementById('infoNama');
                            const statusEl = document.getElementById('infoStatus');
                            const ortuEl = document.getElementById('infoOrtu');
                            const waEl = document.getElementById('infoWa');

                            // Safely set content with null checks
                            if (qrImg) qrImg.src = data.qr_code_url;
                            if (nameEl) nameEl.textContent = data.nama_mhs || '-';
                            if (statusEl) statusEl.textContent = (data.status === 'mahasiswa' ? 'Mahasiswa' : 'Alumni') || '-';
                            if (ortuEl) ortuEl.textContent = data.nama_ortu || '-';
                            if (waEl) waEl.textContent = data.wa_mhs || '-';

                            // Store QR code data for download
                            window.currentName = data.nama_mhs;
                            window.currentQRData = data.qr_code_url;
                            localStorage.setItem('invitationQrData', data.qr_code_url);
                            cacheQrData(data.qr_code_url);

                            // Transition to success view
                            loadingSpinner.classList.add('hidden');
                            successContainer.classList.remove('hidden');

                            // Scroll to success section
                            setTimeout(() => {
                                successContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }, 300);
                        } else {
                            // Handle validation errors
                            if (data.errors) {
                                Object.keys(data.errors).forEach(field => {
                                    showFieldError(field, data.errors[field][0]);
                                });
                            } else {
                                showAlert('Terjadi kesalahan: ' + (data.message || 'Silakan coba lagi'));
                            }

                            // Reset form view
                            loadingSpinner.classList.add('hidden');
                            formContainer.classList.remove('hidden');
                        }
                    } catch (error) {
                        console.error('Error detail:', error);
                        console.error('Error message:', error.message);

                        // Determine error message based on error type
                        let errorMsg = 'Gagal mengirim data. ';
                        if (error.message.includes('Failed to fetch')) {
                            errorMsg += 'Periksa koneksi internet Anda.';
                        } else if (error.message.includes('HTTP Error')) {
                            errorMsg += 'Server error, silakan coba lagi nanti.';
                        } else if (error.message.includes('JSON')) {
                            errorMsg += 'Response server tidak valid.';
                        } else {
                            errorMsg += error.message || 'Silakan coba lagi.';
                        }

                        showAlert(errorMsg);
                        loadingSpinner.classList.add('hidden');
                        formContainer.classList.remove('hidden');
                    } finally {
                        submitBtn.disabled = false;
                    }
                });
            }

            // Helper function to show field error
            function showFieldError(field, message) {
                const errorEl = document.querySelector(`.error-${field}`);
                if (errorEl) {
                    errorEl.textContent = message;
                    errorEl.classList.remove('hidden');
                }
            }

            // Helper function to show alert
            function showAlert(message) {
                const errorMsg = document.getElementById('errorMessage');
                errorMsg.textContent = message;
                errorAlert.classList.remove('hidden');
                errorAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            async function cacheQrData(url) {
                try {
                    const response = await fetch(url, { mode: 'cors' });
                    const blob = await response.blob();
                    const reader = new FileReader();

                    const dataUrl = await new Promise((resolve, reject) => {
                        reader.onloadend = () => resolve(reader.result);
                        reader.onerror = reject;
                        reader.readAsDataURL(blob);
                    });

                    localStorage.setItem('invitationQrData', dataUrl);
                    window.currentQRData = dataUrl;
                } catch (err) {
                    console.warn('Gagal menyimpan QR dalam localStorage:', err);
                    localStorage.setItem('invitationQrData', url);
                }
            }

            // tambahan efek blink pada elemen dengan class blink-gold-text bisa dijalankan
            // sudah tercover CSS
        })();

        // Function to download QR code
        function downloadQRCode() {
            if (!window.currentQRData) return;

            const link = document.createElement('a');
            link.href = window.currentQRData;
            link.download = `QR_Code_${window.currentName}_${new Date().getTime()}.png`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            const kartuUrl = '{{ route("kartu") }}';
            window.open(kartuUrl, '_blank');
        }

        function openKartu() {
            if (!window.currentQRData) return;
            const kartuUrl = '{{ route("kartu") }}';
            window.open(kartuUrl, '_blank');
        }
    </script>
    <style>
        .float-icon {
            animation: float 2.5s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        input,
        select {
            backdrop-filter: blur(4px);
            font-size: 0.85rem;
        }
    </style>

    <!-- Global Countdown Script -->
    <script>
        function updateCountdown() {
            // Target date: June 19, 2026 at 08:00 WIB
            const targetDate = new Date(2026, 5, 19, 8, 0, 0).getTime(); // Month is 0-indexed, so 5 = June
            const now = new Date().getTime();
            const gap = targetDate - now;

            // Time calculations (handle negative gap)
            const totalDays = Math.max(0, gap);
            const days = Math.floor(totalDays / (1000 * 60 * 60 * 24));
            const hours = Math.floor((totalDays % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((totalDays % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((totalDays % (1000 * 60)) / 1000);

            // Update elements if they exist
            const daysEl = document.getElementById('days');
            const hoursEl = document.getElementById('hours');
            const minutesEl = document.getElementById('minutes');
            const secondsEl = document.getElementById('seconds');

            if (daysEl) daysEl.innerText = String(days).padStart(2, '0');
            if (hoursEl) hoursEl.innerText = String(hours).padStart(2, '0');
            if (minutesEl) minutesEl.innerText = String(minutes).padStart(2, '0');
            if (secondsEl) secondsEl.innerText = String(seconds).padStart(2, '0');

            // If countdown finished
            if (gap < 0) {
                if (daysEl) daysEl.innerText = '00';
                if (hoursEl) hoursEl.innerText = '00';
                if (minutesEl) minutesEl.innerText = '00';
                if (secondsEl) secondsEl.innerText = '00';
            }
        }

        // Start countdown immediately
        updateCountdown();

        // Update every second
        setInterval(updateCountdown, 1000);

        // Create animated stars
        function createStars() {
            const starsContainer = document.getElementById('starsContainer');
            if (!starsContainer) return;

            const starCount = 50;
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'absolute rounded-full bg-white';

                const size = Math.random() * 3 + 1;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 2;

                star.style.width = size + 'px';
                star.style.height = size + 'px';
                star.style.left = x + '%';
                star.style.top = y + '%';
                star.style.animation = `twinkleStar ${duration}s ease-in-out ${delay}s infinite`;
                star.style.opacity = Math.random() * 0.7 + 0.3;
                star.style.boxShadow = '0 0 ' + (size * 2) + 'px rgba(255, 217, 102, 0.8)';

                starsContainer.appendChild(star);
            }
        }

        // Create stars for hero background
        function createHeroStars() {
            const heroStarsContainer = document.getElementById('heroStars');
            if (!heroStarsContainer) return;

            const starCount = 30;
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'absolute rounded-full bg-white';

                const size = Math.random() * 2.5 + 0.5;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 2;

                star.style.width = size + 'px';
                star.style.height = size + 'px';
                star.style.left = x + '%';
                star.style.top = y + '%';
                star.style.animation = `twinkleStar ${duration}s ease-in-out ${delay}s infinite`;
                star.style.opacity = Math.random() * 0.5 + 0.2;
                star.style.boxShadow = '0 0 ' + (size * 2) + 'px rgba(255, 255, 255, 0.6)';
                star.style.pointerEvents = 'none';

                heroStarsContainer.appendChild(star);
            }
        }

        // Create stars for countdown background
        function createCountdownStars() {
            const countdownStarsContainer = document.getElementById('countdownStars');
            if (!countdownStarsContainer) return;

            const starCount = 20;
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'absolute rounded-full bg-[#FFD966]';

                const size = Math.random() * 2 + 0.5;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 2;

                star.style.width = size + 'px';
                star.style.height = size + 'px';
                star.style.left = x + '%';
                star.style.top = y + '%';
                star.style.animation = `twinkleStar ${duration}s ease-in-out ${delay}s infinite`;
                star.style.opacity = Math.random() * 0.6 + 0.2;
                star.style.boxShadow = '0 0 ' + (size * 2) + 'px rgba(255, 217, 102, 0.6)';

                countdownStarsContainer.appendChild(star);
            }
        }

        // Create stars for agenda section background
        function createAgendaStars() {
            const agendaStarsContainer = document.getElementById('agendaStars');
            if (!agendaStarsContainer) return;

            const starCount = 25;
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'absolute rounded-full bg-white';

                const size = Math.random() * 2 + 0.5;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 2;

                star.style.width = size + 'px';
                star.style.height = size + 'px';
                star.style.left = x + '%';
                star.style.top = y + '%';
                star.style.animation = `twinkleStar ${duration}s ease-in-out ${delay}s infinite`;
                star.style.opacity = Math.random() * 0.5 + 0.2;
                star.style.boxShadow = '0 0 ' + (size * 2) + 'px rgba(255, 255, 255, 0.6)';
                star.style.pointerEvents = 'none';

                agendaStarsContainer.appendChild(star);
            }
        }

        // Create stars for doorprize section background
        function createDoorprizeStars() {
            const doorprizeStarsContainer = document.getElementById('doorprizeStars');
            if (!doorprizeStarsContainer) return;

            const starCount = 25;
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'absolute rounded-full bg-[#FFD966]';

                const size = Math.random() * 2 + 0.5;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 2;

                star.style.width = size + 'px';
                star.style.height = size + 'px';
                star.style.left = x + '%';
                star.style.top = y + '%';
                star.style.animation = `twinkleStar ${duration}s ease-in-out ${delay}s infinite`;
                star.style.opacity = Math.random() * 0.4 + 0.15;
                star.style.boxShadow = '0 0 ' + (size * 2) + 'px rgba(255, 217, 102, 0.5)';
                star.style.pointerEvents = 'none';

                doorprizeStarsContainer.appendChild(star);
            }
        }

        // Create stars for location section background
        function createLocationStars() {
            const locationStarsContainer = document.getElementById('locationStars');
            if (!locationStarsContainer) return;

            const starCount = 25;
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'absolute rounded-full bg-white';

                const size = Math.random() * 2 + 0.5;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 2;

                star.style.width = size + 'px';
                star.style.height = size + 'px';
                star.style.left = x + '%';
                star.style.top = y + '%';
                star.style.animation = `twinkleStar ${duration}s ease-in-out ${delay}s infinite`;
                star.style.opacity = Math.random() * 0.5 + 0.2;
                star.style.boxShadow = '0 0 ' + (size * 2) + 'px rgba(255, 255, 255, 0.6)';
                star.style.pointerEvents = 'none';

                locationStarsContainer.appendChild(star);
            }
        }

        // Create stars for invitation call section background
        function createInvitationCallStars() {
            const invitationCallStarsContainer = document.getElementById('invitationCallStars');
            if (!invitationCallStarsContainer) return;

            const starCount = 15;
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'absolute rounded-full bg-[#018FD7]';

                const size = Math.random() * 1.5 + 0.5;
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 2;

                star.style.width = size + 'px';
                star.style.height = size + 'px';
                star.style.left = x + '%';
                star.style.top = y + '%';
                star.style.animation = `twinkleStar ${duration}s ease-in-out ${delay}s infinite`;
                star.style.opacity = Math.random() * 0.4 + 0.1;
                star.style.boxShadow = '0 0 ' + (size * 2) + 'px rgba(1, 143, 215, 0.4)';
                star.style.pointerEvents = 'none';

                invitationCallStarsContainer.appendChild(star);
            }
        }

        createStars();
        createHeroStars();
        createCountdownStars();
        createAgendaStars();
        createDoorprizeStars();
        createLocationStars();
        createInvitationCallStars();
    </script>
</body>

</html>
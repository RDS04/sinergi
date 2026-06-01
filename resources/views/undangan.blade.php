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
                style="background: linear-gradient(rgba(0,0,0,0.45), rgba(1,79,159,0.6)), url('/img/metamedia.jpg') center/cover no-repeat;">
                <!-- Animated Stars Background -->
                <div id="heroStars" class="absolute inset-0"></div>
                <div class="absolute inset-0 bg-black/5"></div>

                <!-- Logo Top Left -->
                <div
                    class="absolute top-6 left-5 z-20 bg-white/20 backdrop-blur-sm rounded-lg p-2 border border-white/30">
                    <img src="{{ asset('img/logo.png') }}" alt="Metamedia" class="h-12 w-12 object-contain">
                </div>

                <!-- Logo Top Right -->
                <div
                    class="absolute top-6 right-5 z-20 bg-white/20 backdrop-blur-sm rounded-lg p-2 border border-white/30">
                    <img src="{{ asset('img/enbi.webp') }}" alt="ENBI" class="h-12 w-12 object-contain">
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
                    <div class="mt-8 relative bg-white/15 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-lg overflow-hidden">
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
                            <i class="fas fa-hourglass-end text-[#FFD966] mr-1"></i> Segera dimulai! Bersiaplah untuk
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
            <div class="relative bg-white px-5 py-16 overflow-hidden">
                <!-- Subtle animated background -->
                <div id="invitationCallStars" class="absolute inset-0 opacity-30"></div>
                
                <div class="relative z-10 max-w-2xl mx-auto text-center">
                    <!-- Main Heading -->
                    <div class="mb-12">
                        <h2 class="font-display text-4xl md:text-5xl font-black text-[#018FD7] leading-tight mb-4">
                            Kami Mengundang Anda
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-[#018FD7] to-[#C9A03D] rounded-full mx-auto mb-6"></div>
                        <p class="text-lg text-[#016aa3] font-light italic">
                            Bergabunglah dalam Metamedia Collaboration Day dan rasakan energi kolaborasi keluarga besar kami
                        </p>
                    </div>

                    <!-- Three Invitation Targets -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
                        <!-- Mahasiswa -->
                        <div class="group">
                            <div class="bg-gradient-to-br from-[#018FD7]/10 to-[#016aa3]/10 rounded-2xl p-6 border border-[#018FD7]/20 hover:border-[#C9A03D] transition-all duration-300 hover:shadow-lg">
                                <div class="flex justify-center mb-4">
                                    <div class="bg-gradient-to-br from-[#018FD7] to-[#0A5B9F] rounded-full p-4 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-[#016aa3] mb-2">Para Mahasiswa</h3>
                                <p class="text-[#016aa3]/70 text-sm leading-relaxed">
                                    Dapatkan wawasan karir terbaru, networking dengan profesional, dan kesempatan emas meraih doorprize eksklusif. Bangun masa depan karir Anda bersama kami!
                                </p>
                            </div>
                        </div>

                        <!-- Alumni -->
                        <div class="group">
                            <div class="bg-gradient-to-br from-[#018FD7]/10 to-[#016aa3]/10 rounded-2xl p-6 border border-[#018FD7]/20 hover:border-[#C9A03D] transition-all duration-300 hover:shadow-lg">
                                <div class="flex justify-center mb-4">
                                    <div class="bg-gradient-to-br from-[#018FD7] to-[#0A5B9F] rounded-full p-4 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-handshake text-white text-2xl"></i>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-[#016aa3] mb-2">Para Alumni</h3>
                                <p class="text-[#016aa3]/70 text-sm leading-relaxed">
                                    Kembali berkumpul dengan teman-teman lama, berbagi pengalaman sukses, dan berkolaborasi dalam membangun ekosistem karir yang berkelanjutan.
                                </p>
                            </div>
                        </div>

                        <!-- Orang Tua -->
                        <div class="group">
                            <div class="bg-gradient-to-br from-[#018FD7]/10 to-[#016aa3]/10 rounded-2xl p-6 border border-[#018FD7]/20 hover:border-[#C9A03D] transition-all duration-300 hover:shadow-lg">
                                <div class="flex justify-center mb-4">
                                    <div class="bg-gradient-to-br from-[#018FD7] to-[#0A5B9F] rounded-full p-4 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-heart text-white text-2xl"></i>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-[#016aa3] mb-2">Para Orang Tua</h3>
                                <p class="text-[#016aa3]/70 text-sm leading-relaxed">
                                    Saksikan perkembangan anak-anak Anda dan pelajari peluang karir di era digital. Dukung perjalanan pendidikan dan karir generasi muda Metamedia!
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Call to Action -->
                    <div class="bg-gradient-to-r from-[#018FD7] to-[#016aa3] rounded-2xl p-8 border border-[#C9A03D]/30">
                        <p class="text-white/90 text-lg mb-4 font-light">
                            <i class="fas fa-star text-[#FFD966] mr-2"></i> 
                            Jadilah bagian dari keluarga besar Metamedia dan rasakan pengalaman yang tak terlupakan
                        </p>
                        <p class="text-[#FFD966] font-bold text-xl mb-6">
                            Sinergi Keluarga Besar Menuju Masa Depan Karir
                        </p>
                        <a href="#rsvpForm" class="inline-block bg-[#FFD966] text-[#018FD7] font-extrabold py-3 px-8 rounded-full hover:bg-white transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-arrow-down mr-2"></i> Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Agenda / Timeline mobile friendly -->
            <div class="relative bg-gradient-to-b from-[#018FD7] to-[#016aa3] px-5 py-12 overflow-hidden">
                <!-- Animated Stars Background -->
                <div id="agendaStars" class="absolute inset-0"></div>
                <!-- Content -->
                <div class="relative z-10">
                <div class="text-center mb-6">
                    <span class="text-[#FFD966] text-xs tracking-widest"><i class="far fa-clock mr-1"></i> RUNDOWN
                        ACARA</span>
                    <h2 class="font-display text-2xl font-bold text-white mt-1">Alur Sinergi <span
                            class="text-[#FFD966]">Hari Kolaborasi</span></h2>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 border-l-4 border-[#FFD966]">
                        <div class="text-2xl font-black text-white">08.00</div>
                        <h3 class="font-bold text-white text-base">Registrasi & Coffee Morning</h3>
                        <p class="text-white/70 text-xs">Keluarga besar berkumpul, ramah tamah</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 border-l-4 border-[#FFD966]">
                        <div class="text-2xl font-black text-white">09.30</div>
                        <h3 class="font-bold text-white text-base">Opening & Keynote Speech</h3>
                        <p class="text-white/70 text-xs">"Masa Depan Karir di Ekosistem Media"</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 border-l-4 border-[#FFD966]">
                        <div class="text-2xl font-black text-white">13.00</div>
                        <h3 class="font-bold text-white text-base">Panel Kolaborasi</h3>
                        <p class="text-white/70 text-xs">Sharing session bersama para expert</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 border-l-4 border-[#FFD966]">
                        <div class="text-2xl font-black text-white">15.30</div>
                        <h3 class="font-bold text-white text-base">Penutupan & Networking</h3>
                        <p class="text-white/70 text-xs">Kesepakatan kolaborasi & foto bersama</p>
                    </div>
                </div>
                </div>
            </div>

            <!-- Quote sinergi dengan background emas blink halus -->
            <div class="bg-[#E8F4FB] px-5 py-12 text-center">
                <i class="fas fa-quote-right text-4xl text-[#C9A03D] opacity-40 mb-3"></i>
                <p class="text-base md:text-lg font-light text-[#016aa3] leading-relaxed">"Keluarga besar Metamedia
                    bergerak dalam harmoni, membangun karir masa depan dengan inovasi tanpa batas."</p>
                <div class="flex justify-center gap-6 mt-6">
                    <div class="flex flex-col items-center"><i
                            class="fas fa-bullhorn text-2xl text-[#018FD7] float-icon"></i><span
                            class="text-xs text-[#016aa3] mt-1">Media Partner</span></div>
                    <div class="flex flex-col items-center"><i
                            class="fas fa-graduation-cap text-2xl text-[#018FD7] float-icon"></i><span
                            class="text-xs text-[#016aa3] mt-1">Career Center</span></div>
                    <div class="flex flex-col items-center"><i
                            class="fas fa-chart-line text-2xl text-[#018FD7] float-icon"></i><span
                            class="text-xs text-[#016aa3] mt-1">Future Skills</span></div>
                </div>
            </div>

            <!-- Product Showcase - Premium Tech Experience -->
            <div class="relative bg-gradient-to-b from-[#016aa3] to-[#0A5B9F] px-5 py-14 overflow-hidden">
                <!-- Animated Stars Background -->
                <div id="doorprizeStars" class="absolute inset-0"></div>
                <!-- Background decorative elements -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-[#C9A03D] opacity-5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-[#FFD966] opacity-5 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <!-- Header -->
                    <div class="text-center mb-10">
                        <span
                            class="inline-block px-3 py-1 rounded-full border border-[#C9A03D] bg-[#018FD7]/60 backdrop-blur-sm mb-3">
                            <span class="text-[#FFD966] text-[10px] tracking-widest font-bold"><i
                                    class="fas fa-gift mr-1"></i> DOORPRIZE MENARIK</span>
                        </span>
                        <h2 class="font-display text-2xl font-bold text-white leading-tight">Hadiah <span
                                class="text-[#FFD966]">Premium</span> Menanti<br>Peserta Beruntung</h2>
                        <p class="text-white/70 text-sm mt-2">Kesempatan emas memenangkan gadget flagship terbaru di
                            acara sinergi kami</p>
                    </div>

                    <!-- Product Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                        <!-- iPhone 17 Pro -->
                        <div class="group relative">
                            <div
                                class="relative bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20 overflow-hidden transition-all duration-500 hover:bg-white/20 hover:border-[#FFD966]">
                                <!-- Glow effect on hover -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-b from-[#FFD966]/0 to-[#C9A03D]/0 group-hover:from-[#FFD966]/10 group-hover:to-[#C9A03D]/10 transition-all duration-500">
                                </div>

                                <div class="relative z-5 flex flex-col items-center h-full">
                                    <img src="{{ asset('img/17 pro.webp') }}" alt="iPhone 17 Pro"
                                        class="w-32 h-48 object-contain mb-3 drop-shadow-lg group-hover:scale-105 transition-transform duration-300">
                                    <div class="text-center w-full">
                                        <h3 class="text-white font-bold text-lg mb-1">iPhone 17 Pro</h3>
                                        <p class="text-[#FFD966] text-xs font-semibold mb-2">Hadiah Utama</p>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MacBook -->
                        <div class="group relative">
                            <div
                                class="relative bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/20 overflow-hidden transition-all duration-500 hover:bg-white/20 hover:border-[#FFD966]">
                                <!-- Glow effect on hover -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-b from-[#FFD966]/0 to-[#C9A03D]/0 group-hover:from-[#FFD966]/10 group-hover:to-[#C9A03D]/10 transition-all duration-500">
                                </div>

                                <div class="relative z-5 flex flex-col items-center h-full">
                                    <img src="{{ asset('img/macbook.jpg') }}" alt="MacBook Pro"
                                        class="w-full h-40 object-contain mb-3 drop-shadow-lg group-hover:scale-105 transition-transform duration-300">
                                    <div class="text-center w-full">
                                        <h3 class="text-white font-bold text-lg mb-1">MacBook Pro</h3>
                                        <p class="text-[#FFD966] text-xs font-semibold mb-2">Hadiah Istimewa</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prize Highlights -->
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div
                            class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-[#C9A03D]/20 hover:border-[#C9A03D]/50 transition-all">
                            <i class="fas fa-star text-[#FFD966] text-lg mb-1"></i>
                            <p class="text-white/80 text-xs font-semibold">Eksklusif</p>
                        </div>
                        <div
                            class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-[#C9A03D]/20 hover:border-[#C9A03D]/50 transition-all">
                            <i class="fas fa-gem text-[#FFD966] text-lg mb-1"></i>
                            <p class="text-white/80 text-xs font-semibold">Premium</p>
                        </div>
                        <div
                            class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-[#C9A03D]/20 hover:border-[#C9A03D]/50 transition-all">
                            <i class="fas fa-crown text-[#FFD966] text-lg mb-1"></i>
                            <p class="text-white/80 text-xs font-semibold">Terbatas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partnership & Collaboration Section -->
            <div class="bg-white px-5 py-12">
                <div class="text-center mb-8">
                    <h3 class="font-display text-xl font-bold text-[#016aa3] mb-1">Kolaborasi Strategis</h3>
                    <p class="text-[#016aa3]/70 text-xs">Partnership dalam Inovasi dan Pengembangan Talenta</p>
                    <div class="w-16 h-1 bg-gradient-to-r from-[#018FD7] to-[#C9A03D] rounded-full mx-auto mt-3"></div>
                </div>

                <div class="flex items-center justify-center gap-6">
                    <!-- Metamedia Logo -->
                    <div class="flex flex-col items-center">
                        <div
                            class="bg-white p-3 rounded-lg border border-[#018FD7]/20 hover:border-[#018FD7]/50 transition-all shadow-md hover:shadow-lg">
                            <img src="{{ asset('img/logo.png') }}" alt="Universitas Metamedia" class="w-20 h-20 object-contain">
                        </div>
                        <p class="text-[#016aa3] text-[10px] font-semibold mt-2 text-center">Universitas<br>Metamedia
                        </p>
                    </div>

                    <!-- Connector -->
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-8 h-[2px] bg-[#C9A03D] rounded-full"></div>
                        <i class="fas fa-handshake text-[#C9A03D] text-lg"></i>
                        <div class="w-8 h-[2px] bg-[#C9A03D] rounded-full"></div>
                    </div>

                    <!-- ENBI Logo -->
                    <div class="flex flex-col items-center">
                        <div
                            class="bg-white p-3 rounded-lg border border-[#018FD7]/20 hover:border-[#018FD7]/50 transition-all shadow-md hover:shadow-lg">
                            <img src="{{ asset('img/enbi.webp') }}" alt="ENBI Group" class="w-20 h-20 object-contain">
                        </div>
                        <p class="text-[#016aa3] text-[10px] font-semibold mt-2 text-center">ENBI<br>Group</p>
                    </div>
                </div>

                <p class="text-[#016aa3]/60 text-[10px] text-center mt-6">Bersama membangun ekosistem karir yang
                    berkelanjutan</p>
            </div>

            <!-- Lokasi Acara Section -->
            <div class="relative bg-gradient-to-b from-[#016aa3] to-[#018FD7] px-5 py-12 overflow-hidden">
                <!-- Animated Stars Background -->
                <div id="locationStars" class="absolute inset-0"></div>
                <!-- Content -->
                <div class="relative z-10">
                <div class="text-center mb-6">
                    <span
                        class="inline-block px-3 py-1 rounded-full border border-[#C9A03D] bg-white/10 backdrop-blur-sm mb-3">
                        <span class="text-[#FFD966] text-[10px] tracking-widest font-bold"><i
                                class="fas fa-map-marker-alt mr-1"></i> LOKASI ACARA</span>
                    </span>
                    <h2 class="font-display text-2xl font-bold text-white leading-tight">Kunjungi Kami di<br><span
                            class="text-[#FFD966]">Hotel Truntum Padang</span></h2>
                </div>

                <!-- Maps Container -->
                <div
                    class="relative bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/20 mb-6">
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
                <div class="space-y-3">
                    <div
                        class="bg-white/15 backdrop-blur-sm rounded-xl p-4 border border-white/20 hover:border-[#FFD966]/50 transition-all">
                        <div class="flex items-start gap-3">
                            <div class="bg-[#FFD966] rounded-lg p-2 flex-shrink-0">
                                <i class="fas fa-building text-[#016aa3] text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white/80 text-xs">Tempat Acara</p>
                                <p class="text-white font-semibold text-sm">Hotel Truntum Padang</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white/15 backdrop-blur-sm rounded-xl p-4 border border-white/20 hover:border-[#FFD966]/50 transition-all">
                        <div class="flex items-start gap-3">
                            <div class="bg-[#FFD966] rounded-lg p-2 flex-shrink-0">
                                <i class="fas fa-map-pin text-[#016aa3] text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white/80 text-xs">Alamat</p>
                                <p class="text-white font-semibold text-sm">Jl. Veteran, Padang, Sumatera Barat</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white/15 backdrop-blur-sm rounded-xl p-4 border border-white/20 hover:border-[#FFD966]/50 transition-all">
                        <div class="flex items-start gap-3">
                            <div class="bg-[#FFD966] rounded-lg p-2 flex-shrink-0">
                                <i class="fas fa-clock text-[#016aa3] text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white/80 text-xs">Tanggal & Waktu</p>
                                <p class="text-white font-semibold text-sm">Sabtu, 19 Juni 2026 | 08.00 - 17.00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-3 bg-[#FFD966]/20 border border-[#FFD966]/30 rounded-lg">
                    <p class="text-white/90 text-xs text-center">
                        <i class="fas fa-info-circle text-[#FFD966] mr-1"></i>
                        Harap tiba lebih awal untuk registrasi dan networking session
                    </p>
                </div>
                </div>
            </div>
            <!-- RSVP Form elegan dengan blink efek tombol -->
            <section class="py-10 px-5 bg-gradient-to-b from-[#018FD7] to-[#016aa3]">
                <div class="max-w-2xl mx-auto">
                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-white mb-2 font-display">Konfirmasi Kehadiran</h2>
                        <p class="text-white/80 text-sm">Mohon lengkapi data berikut untuk konfirmasi kehadiran Anda</p>
                    </div>

                    <!-- Form Container -->
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                        <form method="POST" action="{{ route('invitation.store') }}" class="space-y-6">
                            @csrf

                            <!-- Data Mahasiswa Section -->
                            <div>
                                <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">
                                    <i class="fas fa-graduation-cap text-[#FFD966] mr-2"></i>Data Mahasiswa
                                </h3>
                                
                                <div class="space-y-4">
                                    <!-- Nama Mahasiswa -->
                                    <div>
                                        <label class="block text-white/90 text-sm font-medium mb-2">Nama Mahasiswa</label>
                                        <input type="text" name="nama_mhs" value="{{ old('nama_mhs') }}" required
                                            class="w-full px-4 py-2.5 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:border-[#FFD966] focus:bg-white/30 transition"
                                            placeholder="Masukkan nama lengkap">
                                        @if ($errors->has('nama_mhs'))
                                            <p class="text-red-300 text-xs mt-1">{{ $errors->first('nama_mhs') }}</p>
                                        @endif
                                    </div>

                                    <!-- Status Dropdown -->
                                    <div>
                                        <label class="block text-white/90 text-sm font-medium mb-2">Status</label>
                                        <select name="status" required
                                            class="w-full px-4 py-2.5 rounded-lg bg-white/20 border border-white/30 text-white focus:outline-none focus:border-[#FFD966] focus:bg-white/30 transition appearance-none cursor-pointer"
                                            style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'rgba(255,255,255,0.5)\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>'); background-repeat: no-repeat; background-position: right 8px center; background-size: 24px; padding-right: 36px;">
                                            <option value="" disabled selected style="background-color: #016aa3;">Pilih Status</option>
                                            <option value="mahasiswa" style="background-color: #016aa3;">Mahasiswa</option>
                                            <option value="alumni" style="background-color: #016aa3;">Alumni</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <p class="text-red-300 text-xs mt-1">{{ $errors->first('status') }}</p>
                                        @endif
                                    </div>

                                    <!-- Nama Orang Tua & Prodi Row -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-white/90 text-sm font-medium mb-2">Nama Orang Tua / Wali</label>
                                            <input type="text" name="nama_ortu" value="{{ old('nama_ortu') }}" required
                                                class="w-full px-4 py-2.5 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:border-[#FFD966] focus:bg-white/30 transition"
                                                placeholder="Nama orang tua">
                                            @if ($errors->has('nama_ortu'))
                                                <p class="text-red-300 text-xs mt-1">{{ $errors->first('nama_ortu') }}</p>
                                            @endif
                                        </div>
                                   
                                    </div>

                                    <!-- WhatsApp Mahasiswa -->
                                    <div>
                                        <label class="block text-white/90 text-sm font-medium mb-2">Nomor WhatsApp Mahasiswa</label>
                                        <input type="tel" name="wa_mhs" value="{{ old('wa_mhs') }}" required
                                            class="w-full px-4 py-2.5 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/50 focus:outline-none focus:border-[#FFD966] focus:bg-white/30 transition"
                                            placeholder="628...">
                                        @if ($errors->has('wa_mhs'))
                                            <p class="text-red-300 text-xs mt-1">{{ $errors->first('wa_mhs') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-white/20"></div>

                            <!-- Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                <button type="submit" 
                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-[#FFD966] to-[#C9A03D] text-[#018FD7] font-bold rounded-lg hover:shadow-lg hover:scale-105 transition-all active:scale-95">
                                    <i class="fas fa-paper-plane mr-2"></i>Kirim Konfirmasi
                                </button>
                                <button type="reset" 
                                    class="flex-1 px-6 py-3 bg-white/20 text-white font-semibold rounded-lg border border-white/40 hover:bg-white/30 transition-all active:scale-95">
                                    <i class="fas fa-redo mr-2"></i>Reset
                                </button>
                            </div>

                            <!-- Success Message -->
                            @if ($message = Session::get('success'))
                                <div class="bg-green-400/20 border border-green-400 text-green-300 px-4 py-3 rounded-lg text-sm">
                                    <i class="fas fa-check-circle mr-2"></i>{{ $message }}
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- Info Box -->
                    <div class="mt-6 p-4 bg-[#FFD966]/20 border border-[#FFD966]/30 rounded-lg">
                        <p class="text-white/90 text-xs text-center">
                            <i class="fas fa-info-circle text-[#FFD966] mr-1"></i>
                            Data Anda aman dan hanya digunakan untuk keperluan acara Metamedia Collaboration Day
                        </p>
                    </div>
                </div>
            </section>

            <!-- Footer Elegan -->
            <footer class="bg-[#016aa3] px-5 py-6 text-center text-white/70 text-xs border-t border-white/10">
                <div class="flex justify-center gap-6 mb-3">
                    <i class="fab fa-instagram text-white/80 hover:text-[#FFD966] transition"></i>
                    <i class="fab fa-linkedin-in text-white/80 hover:text-[#FFD966] transition"></i>
                    <i class="fab fa-twitter text-white/80 hover:text-[#FFD966] transition"></i>
                    <i class="fab fa-tiktok text-white/80 hover:text-[#FFD966] transition"></i>
                </div>
                <p>© 2025 Metamedia Collaboration Day — Sinergi Keluarga Besar Menuju Masa Depan Karir</p>
                <p class="text-[9px] mt-1">#MetamediaCollabDay | #SinergiMasaDepan</p>
            </footer>
        </div>
    </div>

    <script>
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

                // RSVP handler
                const rsvpForm = document.getElementById('rsvpForm');
                if (rsvpForm) {
                    rsvpForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        const toast = document.createElement('div');
                        toast.className = 'fixed bottom-5 left-1/2 transform -translate-x-1/2 bg-[#C9A03D] text-[#018FD7] font-bold px-5 py-2.5 rounded-full shadow-2xl z-50 flex items-center gap-2 text-sm animate-fade-in-up';
                        toast.innerHTML = '<i class="fas fa-check-circle"></i> Konfirmasi berhasil! Kami akan menghubungi Anda.';
                        document.body.appendChild(toast);
                        setTimeout(() => {
                            toast.style.opacity = '0';
                            setTimeout(() => toast.remove(), 500);
                        }, 3500);
                        rsvpForm.reset();
                    });
                }

                // tambahan efek blink pada elemen dengan class blink-gold-text bisa dijalankan
                // sudah tercover CSS
            })();
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
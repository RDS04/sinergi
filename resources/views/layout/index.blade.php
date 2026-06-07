<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AdminLTE 3 | Metamedia Admin Panel</title>
    <!-- Google Fonts: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Theme style (AdminLTE 3) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Override custom theme: #018FD7 dan aksen emas -->
    <style>
        :root {
            --metamedia: #018FD7;
            --metagold: #C9A03D;
            --metagold-light: #E8C468;
        }
        /* Custom navbar brand & sidebar */
        .main-header.navbar {
            background: linear-gradient(90deg, #018FD7 0%, #0096E6 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .main-header .navbar-nav .nav-link {
            color: white;
        }
        .main-header .navbar-nav .nav-link:hover {
            color: #FFD966;
        }
        .brand-link {
            background: linear-gradient(135deg, #016aa3 0%, #018FD7 100%);
            border-bottom: 1px solid rgba(201,160,61,0.3);
        }
        .brand-link .brand-text {
            color: white;
            font-weight: 600;
        }
        .brand-link .brand-image {
            filter: drop-shadow(0 0 2px rgba(201,160,61,0.6));
        }
        /* Sidebar */
        .main-sidebar, .main-sidebar::before {
            background: linear-gradient(180deg, #0A2E44 0%, #0A1E2F 100%);
        }
        .nav-sidebar .nav-link.active {
            background: linear-gradient(90deg, #018FD7, #0096E6);
            color: white;
            border-left-color: #C9A03D;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .nav-sidebar .nav-link.active i {
            color: #FFD966;
        }
        .nav-sidebar .nav-link:hover:not(.active) {
            background: rgba(1, 143, 215, 0.2);
            color: #E8C468;
        }
        .nav-sidebar .nav-link {
            color: #d2d6de;
            transition: all 0.2s;
        }
        .nav-sidebar .nav-link i {
            color: #C9A03D;
        }
        .nav-sidebar .nav-header {
            color: #C9A03D;
            font-weight: 600;
            letter-spacing: 1px;
        }
        /* Treeview menu hover */
        .nav-treeview > .nav-item > .nav-link {
            color: #b8c7ce;
        }
        .nav-treeview > .nav-item > .nav-link:hover {
            color: #FFD966;
            background: rgba(1,143,215,0.15);
        }
        /* Dropdown user menu */
        .user-header {
            background: linear-gradient(135deg, #018FD7, #0A5B9F) !important;
        }
        .dropdown-item.active, .dropdown-item:active {
            background-color: #018FD7;
        }
        /* Kartu / card custom border gold */
        .card {
            border-radius: 0.75rem;
            border-top: 3px solid #C9A03D;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .btn-metamedia {
            background: #018FD7;
            color: white;
            border: none;
        }
        .btn-metamedia:hover {
            background: #0A5B9F;
            color: #FFD966;
        }
        .btn-outline-gold {
            border: 1px solid #C9A03D;
            color: #C9A03D;
            background: transparent;
        }
        .btn-outline-gold:hover {
            background: #C9A03D;
            color: #0A1E2F;
        }
        /* Blink emas elemen kecil */
        .gold-blink {
            animation: blinkGold 1.8s step-start infinite;
        }
        @keyframes blinkGold {
            0%, 100% { opacity: 0.7; text-shadow: 0 0 1px #FFD966; }
            50% { opacity: 1; text-shadow: 0 0 5px #FFD966; }
        }
        /* Info box icon gold */
        .small-box .icon {
            color: rgba(201,160,61,0.3);
        }
        /* Dashboard-specific helpers (from dashboard styles) */
        .content-wrapper { padding: 30px 0; background: #f4f6f9; }
        .small-box { margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.12); border-radius: 12px; padding: 20px; transition: all 0.3s; position: relative; background: white; }
        .small-box:hover { transform: translateY(-2px); box-shadow: 0 3px 6px rgba(0,0,0,0.15); }
        .small-box h3 { font-size: 2.5rem; font-weight: 700; color: var(--metamedia); margin: 0 0 5px 0; }
        .small-box p { font-size: 0.9rem; color: #666; margin: 0; }
        .small-box .icon { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); font-size: 3rem; color: rgba(1,143,215,0.1); }
        .user-info-card { background: linear-gradient(135deg, #018FD7 0%, #016aa3 100%); color: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; }
        .user-info-card h5 { font-weight: 700; font-size: 1.5rem; margin-bottom: 15px; }
        .btn-logout { background: #FFD966; color: #018FD7; border: none; font-weight: 700; border-radius: 8px; padding: 10px 25px; transition: all 0.3s; }
        .btn-logout:hover { background: #E8C468; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(201,160,61,0.3); }
        .table th { background: #f5f5f5; }
        .table tbody tr:hover { background: #f8f9fa; }
        /* Konten utama */
        .content-wrapper {
            background: #f4f6f9;
        }
        /* Footer */
        .main-footer {
            background: white;
            border-top: 1px solid rgba(201,160,61,0.3);
        }
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #1e2a3a;
        }
        ::-webkit-scrollbar-thumb {
            background: #C9A03D;
            border-radius: 10px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar / Header -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Kontak</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block" style="display: none;">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Cari..." aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Notifications Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge" style="background: #C9A03D;">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">3 Notifikasi</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2" style="color:#018FD7;"></i> 2 pesan baru
                            <span class="float-right text-muted text-sm">3 menit</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2" style="color:#C9A03D;"></i> 8 pendaftar baru
                            <span class="float-right text-muted text-sm">12 jam</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-chart-line mr-2" style="color:#018FD7;"></i> Laporan kolaborasi
                            <span class="float-right text-muted text-sm">2 hari</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">Lihat Semua</a>
                    </div>
                </li>
                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle"></i>
                        <span class="ml-1 d-none d-md-inline">Admin Metamedia</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog mr-2"></i> Pengaturan
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link d-flex align-items-center">
                <i class="fas fa-diamond text-warning mr-2" style="font-size: 1.6rem; color: #C9A03D !important;"></i>
                <span class="brand-text font-weight-bold">Metamedia <span class="gold-blink" style="color:#FFD966;">+</span></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="fas fa-user-circle fa-2x text-gold" style="color:#C9A03D;"></i>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block text-white">Administrator</a>
                        <small class="text-gold" style="color:#E8C468;"><i class="fas fa-circle" style="font-size: 8px;"></i> Online</small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <!-- Karir & Alumni -->
                        <li class="nav-item">
                            <a href="{{ route('daftar-hadir') }}" class="nav-link {{ request()->routeIs('daftar-hadir') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Daftar Kehadiran</p>
                            </a>
                        </li>
                        <!-- Laporan -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Laporan Statistik</p>
                            </a>
                        </li>
                        <!-- Pengaturan -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Pengaturan Sistem</p>
                            </a>
                        </li>
                        <!-- Menu khusus -->
                        <li class="nav-header">EKSTRA</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-envelope"></i>
                                <p>Pesan Masuk <span class="badge badge-warning right" style="background:#C9A03D;">4</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Jadwal Acara</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2026 <a href="#" style="color:#018FD7;">Metamedia Collaboration</a>.</strong>
            All rights reserved. 
            <div class="float-right d-none d-sm-inline-block">
                <i class="fas fa-diamond" style="color:#C9A03D;"></i> <span class="gold-blink">Sinergi Keluarga Besar</span>
            </div>
        </footer>
    </div>

    <!-- REQUIRED SCRIPTS (jQuery, Bootstrap, AdminLTE) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- Chart.js untuk demo statistik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Chart sinergi / statistik sederhana (init only if canvas exists)
        if (document.getElementById('statChart')) {
            const ctx = document.getElementById('statChart').getContext('2d');
            new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Kolaborasi Aktif',
                    data: [12, 19, 15, 25, 30, 42],
                    borderColor: '#018FD7',
                    backgroundColor: 'rgba(1, 143, 215, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#C9A03D',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { labels: { color: '#0A5B9F' } }
                }
            }
            });
        }
        // Optional: Toggle treeview (AdminLTE sudah handle)
        // Menambahkan efek blink pada beberapa ikon
        document.querySelectorAll('.gold-blink').forEach(el => {
            el.style.animation = 'blinkGold 1.5s step-start infinite';
        });
    </script>
    @yield('scripts')
    <!-- Tambahan style live -->
    <style>
        .small-box .icon i {
            color: rgba(201,160,61,0.2);
            transition: 0.2s;
        }
        .small-box:hover .icon i {
            color: rgba(201,160,61,0.5);
            transform: scale(1.02);
        }
        .nav-sidebar .nav-link.active p, .nav-sidebar .nav-link.active i {
            color: white;
        }
        .user-panel .info small i {
            margin-right: 4px;
        }
        .badge-warning {
            background-color: #C9A03D !important;
            color: #0A1E2F;
        }
        .btn-outline-gold {
            border-radius: 30px;
            padding: 0.25rem 1rem;
        }
    </style>
</body>
</html>
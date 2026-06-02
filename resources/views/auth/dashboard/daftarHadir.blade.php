@extends('layout.index')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard <small>Metamedia Collaboration Day</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color:#018FD7;">Beranda</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
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
                        'fade-in': 'fadeIn 0.4s ease forwards',
                        'blink-gold': 'blinkGold 1.5s step-end infinite',
                        'pulse-gold': 'pulseGold 2s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(8px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        blinkGold: {
                            '0%, 100%': { opacity: '0.6', textShadow: '0 0 2px #C9A03D' },
                            '50%': { opacity: '1', textShadow: '0 0 8px #FFD966' }
                        },
                        pulseGold: {
                            '0%, 100%': { boxShadow: '0 0 0 0 rgba(201,160,61,0.4)' },
                            '50%': { boxShadow: '0 0 0 6px rgba(201,160,61,0)' }
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #eef2f7 0%, #e0e8f0 100%);
            font-family: 'Poppins', sans-serif;
        }
        /* Custom scroll & efek */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #C9A03D; border-radius: 10px; }
        
        .table-container {
            transition: all 0.3s;
        }
        .menu-tab {
            transition: all 0.25s ease;
            cursor: pointer;
        }
        .menu-tab.active {
            background: linear-gradient(135deg, #018FD7, #0096E6);
            color: white;
            box-shadow: 0 4px 12px rgba(1, 143, 215, 0.3);
        }
        .menu-tab.active i {
            color: #FFD966;
        }
        .menu-tab:not(.active):hover {
            background: #E8F4FB;
            border-color: #018FD7;
        }
        .btn-gold {
            background: linear-gradient(105deg, #C9A03D, #E8B84A);
            color: #0A1E2F;
            transition: 0.2s;
        }
        .btn-gold:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(201,160,61,0.4);
        }
        .badge-hadir {
            background: #10b981;
            color: white;
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-belum {
            background: #f59e0b;
            color: white;
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 11px;
        }
        .badge-undangan {
            background: #018FD7;
            color: white;
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 11px;
        }
        .search-input {
            border-radius: 40px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }
        .search-input:focus {
            border-color: #018FD7;
            box-shadow: 0 0 0 3px rgba(1,143,215,0.1);
            outline: none;
        }
        .gold-dot {
            animation: pulseGold 1.5s infinite;
        }
        @keyframes pulseGold {
            0% { opacity: 0.5; transform: scale(0.8);}
            100% { opacity: 1; transform: scale(1.2);}
        }
    </style>
</head>
<body class="p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Dashboard -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-display text-2xl md:text-3xl font-bold text-[#018FD7] flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-[#C9A03D]"></i> 
                    Dashboard Daftar Hadir
                </h1>
                <p class="text-sm text-gray-500 mt-1">Kelola undangan & kehadiran tamu kolaborasi Metamedia</p>
            </div>
            <div class="flex gap-2">
                <div class="bg-white rounded-full px-4 py-2 shadow-sm flex items-center gap-2 text-sm">
                    <i class="fas fa-calendar-alt text-[#C9A03D]"></i>
                    <span class="text-gray-600">14 Juni 2025</span>
                </div>
                <div class="bg-white rounded-full px-4 py-2 shadow-sm flex items-center gap-2 text-sm">
                    <i class="fas fa-users text-[#018FD7]"></i>
                    <span class="text-gray-600" id="totalCountSpan">0 Total</span>
                </div>
            </div>
        </div>

        <!-- Kartu Statistik Singkat -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl p-4 shadow-sm border-l-4 border-[#018FD7]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs">Total Undangan</p>
                        <p class="text-2xl font-bold text-[#018FD7]" id="totalUndanganCount">0</p>
                    </div>
                    <i class="fas fa-envelope-open-text text-3xl text-[#018FD7]/30"></i>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 shadow-sm border-l-4 border-[#C9A03D]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs">Telah Hadir</p>
                        <p class="text-2xl font-bold text-[#C9A03D]" id="totalHadirCount">0</p>
                    </div>
                    <i class="fas fa-check-circle text-3xl text-[#C9A03D]/30"></i>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 shadow-sm border-l-4 border-gray-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs">Belum Hadir</p>
                        <p class="text-2xl font-bold text-gray-500" id="totalBelumCount">0</p>
                    </div>
                    <i class="fas fa-hourglass-half text-3xl text-gray-400/30"></i>
                </div>
            </div>
        </div>

        <!-- Menu Pilihan: Daftar dari Undangan / Daftar Kehadiran -->
        <div class="flex flex-wrap gap-3 mb-6 border-b border-gray-200 pb-2">
            <button id="tabUndangan" class="menu-tab active px-6 py-2.5 rounded-full flex items-center gap-2 font-semibold text-sm shadow-sm bg-white border border-gray-200">
                <i class="fas fa-envelope"></i> Daftar dari Undangan
            </button>
            <button id="tabKehadiran" class="menu-tab px-6 py-2.5 rounded-full flex items-center gap-2 font-semibold text-sm shadow-sm bg-white border border-gray-200">
                <i class="fas fa-fingerprint"></i> Daftar Kehadiran
            </button>
        </div>

        <!-- Filter & Pencarian -->
        <div class="flex flex-col sm:flex-row justify-between gap-3 mb-5">
            <div class="relative w-full sm:w-72">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchInput" placeholder="Cari nama, email, atau institusi..." class="search-input w-full pl-10 pr-4 py-2.5 bg-white shadow-sm text-sm">
            </div>
            <div class="flex gap-2">
                <button id="exportBtn" class="px-4 py-2 bg-white border border-[#018FD7] text-[#018FD7] rounded-full text-sm font-medium hover:bg-[#018FD7] hover:text-white transition flex items-center gap-2">
                    <i class="fas fa-download"></i> Export CSV
                </button>
                <button id="refreshBtn" class="px-4 py-2 bg-white border border-gray-300 rounded-full text-sm hover:bg-gray-50 transition">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 table-container">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-[#018FD7]/5 to-[#C9A03D]/5">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#018FD7] uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#018FD7] uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#018FD7] uppercase tracking-wider">No. Telepon</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#018FD7] uppercase tracking-wider">Status Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#018FD7] uppercase tracking-wider">Status Kehadiran</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-[#018FD7] uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-gray-100 bg-white">
                        <!-- Data akan diisi oleh javascript -->
                    </tbody>
                </table>
            </div>
            <div id="emptyState" class="py-12 text-center hidden">
                <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                <p class="text-gray-400">Tidak ada data ditemukan</p>
            </div>
            <!-- Pagination sederhana -->
            <div class="px-6 py-3 bg-gray-50 flex justify-between items-center text-xs text-gray-500 border-t">
                <span id="showingInfo">Menampilkan 0 dari 0 data</span>
                <div class="flex gap-2">
                    <button id="prevPage" class="px-3 py-1 rounded-md bg-white border disabled:opacity-50" disabled><i class="fas fa-chevron-left"></i></button>
                    <span id="pageInfo" class="px-3 py-1">Halaman 1</span>
                    <button id="nextPage" class="px-3 py-1 rounded-md bg-white border disabled:opacity-50" disabled><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Use server-provided data when available
        const undanganData = {!! isset($invitations) ? json_encode($invitations) : '[]' !!};
        const daftarKehadiran = {!! isset($presences) ? json_encode($presences) : '[]' !!};

        // State
        let activeTab = "undangan"; // 'undangan' or 'kehadiran'
        let currentPage = 1;
        let rowsPerPage = 100;
        let searchQuery = "";

        // Mendapatkan data berdasarkan tab dan filter
        function getFilteredData() {
            let data = [];
            if (activeTab === "undangan") {
                data = [...undanganData];
                if (searchQuery) {
                    const q = searchQuery.toLowerCase();
                    data = data.filter(item => 
                        item.nama.toLowerCase().includes(q) || 
                        item.email.toLowerCase().includes(q) || 
                        item.instansi.toLowerCase().includes(q)
                    );
                }
            } else {
                // Daftar Kehadiran
                data = [...daftarKehadiran];
                if (searchQuery) {
                    const q = searchQuery.toLowerCase();
                    data = data.filter(item => 
                        item.nama.toLowerCase().includes(q) || 
                        item.email.toLowerCase().includes(q) || 
                        item.instansi.toLowerCase().includes(q)
                    );
                }
            }
            return data;
        }

        // Update total statistik berdasarkan tab undangan (untuk header kartu selalu refer ke undangan total hadir/belum)
        function updateStats() {
            const totalUndangan = undanganData.length;
            const totalHadir = undanganData.filter(u => u.statusKehadiran === "Hadir").length;
            const totalBelum = totalUndangan - totalHadir;
            document.getElementById("totalUndanganCount").innerText = totalUndangan;
            document.getElementById("totalHadirCount").innerText = totalHadir;
            document.getElementById("totalBelumCount").innerText = totalBelum;
            // totalCountSpan di header
            const filtered = getFilteredData();
            document.getElementById("totalCountSpan").innerHTML = `${filtered.length} Data`;
        }

        // Render tabel sesuai tab & pagination
        function renderTable() {
            const filteredData = getFilteredData();
            const totalRows = filteredData.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            if (currentPage > totalPages) currentPage = totalPages || 1;
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedData = filteredData.slice(start, end);
            const tbody = document.getElementById("tableBody");
            const emptyStateDiv = document.getElementById("emptyState");

            if (paginatedData.length === 0) {
                tbody.innerHTML = '';
                emptyStateDiv.classList.remove("hidden");
                document.getElementById("showingInfo").innerText = `Menampilkan 0 dari 0 data`;
                document.getElementById("pageInfo").innerText = `Halaman 1`;
                document.getElementById("prevPage").disabled = true;
                document.getElementById("nextPage").disabled = true;
                return;
            }
            emptyStateDiv.classList.add("hidden");
            
            // generate rows
            let html = '';
            paginatedData.forEach((item, idx) => {
                const nomor = start + idx + 1;
                if (activeTab === "undangan") {
                    // Status kategori badge (Mahasiswa/Alumni)
                    const statusKategori = item.status === 'mahasiswa'
                        ? '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold"><i class="fas fa-graduation-cap"></i> Mahasiswa</span>'
                        : '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-semibold"><i class="fas fa-award"></i> Alumni</span>';
                    
                    // Status kehadiran badge
                    const statusBadge = item.statusKehadiran === "Hadir" 
                        ? '<span class="badge-hadir"><i class="fas fa-check-circle mr-1"></i> Hadir</span>' 
                        : '<span class="badge-belum"><i class="fas fa-clock mr-1"></i> Belum Hadir</span>';
                    const actionBtn = item.statusKehadiran === "Hadir" 
                        ? `<button class="text-gray-400 text-xs cursor-default" disabled><i class="fas fa-check-double"></i> Hadir</button>`
                        : `<button onclick="markHadir(${item.id})" class="text-[#018FD7] hover:text-[#C9A03D] transition text-xs font-medium px-2 py-1 rounded-full border border-[#018FD7]/30"><i class="fas fa-check-circle mr-1"></i> Tandai Hadir</button>`;
                    
                    html += `<tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-600">${nomor}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">${escapeHtml(item.nama)}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${escapeHtml(item.email)}<br><span class="text-xs">${escapeHtml(item.kontak || '-')}</span></td>
                        <td class="px-6 py-4">${statusKategori}</td>
                        <td class="px-6 py-4">${statusBadge}</td>
                        <td class="px-6 py-4 text-center">${actionBtn}</td>
                    </tr>`;
                } else {
                    // Daftar Kehadiran view
                    html += `<tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-600">${nomor}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">${escapeHtml(item.nama)}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">${escapeHtml(item.email)}</td>
                        <td class="px-6 py-4"><span class="badge-undangan"><i class="fas fa-fingerprint mr-1"></i> Check-in ${escapeHtml(item.checkIn)}</span><div class="text-xs text-gray-400">${escapeHtml(item.metode)}</div></td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-[#C9A03D] hover:text-[#018FD7] transition"><i class="fas fa-receipt"></i></button>
                        </td>
                    </tr>`;
                }
            });
            tbody.innerHTML = html;
            document.getElementById("showingInfo").innerText = `Menampilkan ${start+1} - ${Math.min(end, totalRows)} dari ${totalRows} data`;
            document.getElementById("pageInfo").innerHTML = `Halaman ${currentPage} dari ${totalPages || 1}`;
            document.getElementById("prevPage").disabled = currentPage === 1;
            document.getElementById("nextPage").disabled = currentPage === totalPages || totalPages === 0;
            updateStats();
        }

        // Fungsi Tandai Hadir - AJAX ke server untuk update database
        window.markHadir = function(id) {
            const guest = undanganData.find(g => g.id === id);
            if (!guest) {
                showToast("Data tidak ditemukan", true);
                return;
            }

            if (guest.statusKehadiran === "Hadir") {
                showToast(`⚠️ ${guest.nama} sudah tercatat hadir sebelumnya`, true);
                return;
            }

            // Disable button saat loading
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';

            // AJAX request ke server untuk update database
            fetch(`/invitation/${id}/mark-attendance`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update data lokal
                    guest.statusKehadiran = data.data.statusKehadiran;
                    guest.waktuHadir = new Date().toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'}) + " WIB";
                    renderTable();
                    showToast(`✅ ${guest.nama} telah ditandai hadir`, false);
                } else {
                    showToast(`❌ ${data.message}`, true);
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan koneksi', true);
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        };

        // Export CSV berdasarkan filtered data
        function exportCSV() {
            const data = getFilteredData();
            if (data.length === 0) {
                showToast("Tidak ada data untuk diekspor", true);
                return;
            }
            let csvRows = [];
            if (activeTab === "undangan") {
                csvRows.push(["No", "Nama Lengkap", "Email", "Kontak", "Status Kehadiran", "Waktu Hadir"]);
                data.forEach((item, idx) => {
                    csvRows.push([idx+1, item.nama, item.email, item.kontak || '-', item.statusKehadiran, item.waktuHadir || '-']);
                });
            } else {
                csvRows.push(["No", "Nama Lengkap", "Email", "Check-in Time", "Metode"]);
                data.forEach((item, idx) => {
                    csvRows.push([idx+1, item.nama, item.email, item.checkIn, item.metode]);
                });
            }
            const csvContent = csvRows.map(row => row.map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(",")).join("\n");
            const blob = new Blob(["\uFEFF" + csvContent], { type: "text/csv;charset=utf-8;" });
            const link = document.createElement("a");
            const url = URL.createObjectURL(blob);
            link.href = url;
            link.setAttribute("download", `daftar_${activeTab}_metamedia.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
            showToast("Export CSV berhasil", false);
        }

        // Toast notifikasi
        function showToast(msg, isError = false) {
            const toastDiv = document.createElement('div');
            toastDiv.className = `fixed bottom-5 left-1/2 transform -translate-x-1/2 px-5 py-2.5 rounded-full shadow-xl z-50 flex items-center gap-2 text-sm font-semibold animate-fade-in`;
            toastDiv.style.background = isError ? '#ef4444' : 'linear-gradient(135deg, #018FD7, #0096E6)';
            toastDiv.style.color = 'white';
            toastDiv.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-triangle' : 'fa-check-circle'}"></i> ${msg}`;
            document.body.appendChild(toastDiv);
            setTimeout(() => {
                toastDiv.style.opacity = '0';
                setTimeout(() => toastDiv.remove(), 500);
            }, 2500);
        }

        // Escape HTML
        function escapeHtml(str) { 
            if(!str) return ''; 
            return str.replace(/[&<>]/g, function(m) {
                if(m === '&') return '&amp;';
                if(m === '<') return '&lt;';
                if(m === '>') return '&gt;';
                return m;
            });
        }

        // Event listeners
        document.getElementById("tabUndangan").addEventListener("click", () => {
            activeTab = "undangan";
            currentPage = 1;
            document.getElementById("tabUndangan").classList.add("active");
            document.getElementById("tabKehadiran").classList.remove("active");
            renderTable();
        });
        document.getElementById("tabKehadiran").addEventListener("click", () => {
            activeTab = "kehadiran";
            currentPage = 1;
            document.getElementById("tabKehadiran").classList.add("active");
            document.getElementById("tabUndangan").classList.remove("active");
            renderTable();
        });
        document.getElementById("searchInput").addEventListener("input", (e) => {
            searchQuery = e.target.value;
            currentPage = 1;
            renderTable();
        });
        document.getElementById("prevPage").addEventListener("click", () => {
            if (currentPage > 1) { currentPage--; renderTable(); }
        });
        document.getElementById("nextPage").addEventListener("click", () => {
            const total = Math.ceil(getFilteredData().length / rowsPerPage);
            if (currentPage < total) { currentPage++; renderTable(); }
        });
        document.getElementById("exportBtn").addEventListener("click", exportCSV);
        document.getElementById("refreshBtn").addEventListener("click", () => {
            searchQuery = "";
            document.getElementById("searchInput").value = "";
            currentPage = 1;
            renderTable();
            showToast("Data berhasil dimuat ulang", false);
        });

        // initial render
        renderTable();
    </script>
</body>
@endsection
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan QR Kehadiran</title>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #17211b;
            background:
                linear-gradient(135deg, rgba(11, 36, 27, 0.74), rgba(30, 57, 47, 0.42)),
                url("{{ asset('storage/bg_scan.png') }}") center / cover fixed no-repeat,
                #eaf0e7;
        }

        button,
        input {
            font: inherit;
        }

        .page {
            width: min(1120px, calc(100% - 32px));
            min-height: 100vh;
            margin: 0 auto;
            padding: 28px 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 20px;
        }

        .header {
            color: #fff;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.35);
        }

        .header h1 {
            font-size: clamp(28px, 4vw, 46px);
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: 0;
        }

        .header p {
            width: min(650px, 100%);
            margin-top: 10px;
            font-size: 15px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.88);
        }

        .content {
            display: grid;
            grid-template-columns: minmax(0, 0.95fr) minmax(340px, 1.05fr);
            gap: 18px;
            align-items: stretch;
        }

        .panel {
            border: 1px solid rgba(255, 255, 255, 0.48);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.88);
            box-shadow: 0 24px 70px rgba(12, 28, 20, 0.25);
            backdrop-filter: blur(16px);
        }

        .scanner-panel,
        .data-panel {
            padding: 18px;
        }

        .panel-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .panel-title h2 {
            font-size: 17px;
            font-weight: 800;
            color: #18261d;
        }

        .badge {
            flex: 0 0 auto;
            border-radius: 999px;
            padding: 6px 10px;
            background: #e8f4ec;
            color: #1d6b3b;
            font-size: 12px;
            font-weight: 800;
        }

        .camera-container {
            position: relative;
            width: 100%;
            max-width: 430px;
            margin: 0 auto;
            overflow: hidden;
            aspect-ratio: 1;
            border-radius: 8px;
            background: #101410;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }

        #video {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #canvas {
            display: none;
        }

        .scanner-overlay {
            position: absolute;
            inset: 15%;
            border: 2px solid rgba(255, 255, 255, 0.92);
            border-radius: 8px;
            box-shadow: 0 0 0 999px rgba(0, 0, 0, 0.22);
        }

        .scanner-overlay::after {
            content: "";
            position: absolute;
            left: 12px;
            right: 12px;
            top: 50%;
            height: 2px;
            background: #4ade80;
            box-shadow: 0 0 18px #4ade80;
        }

        .controls,
        .form-actions,
        .search-actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-top: 14px;
        }

        .form-actions {
            grid-template-columns: 1fr auto;
        }

        .search-actions {
            grid-template-columns: 1fr auto;
            margin-top: 10px;
        }

        .btn {
            min-height: 42px;
            border: 0;
            border-radius: 6px;
            padding: 10px 14px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 800;
            transition: transform 0.16s ease, box-shadow 0.16s ease, background 0.16s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: #1f7a45;
            color: #fff;
            box-shadow: 0 10px 24px rgba(31, 122, 69, 0.22);
        }

        .btn-dark {
            background: #142019;
            color: #fff;
        }

        .btn-soft {
            border: 1px solid #d4ddd5;
            background: #f7faf7;
            color: #25362a;
        }

        .status-text {
            margin-top: 12px;
            min-height: 42px;
            border-radius: 6px;
            padding: 11px 12px;
            background: rgba(20, 32, 25, 0.07);
            color: #445046;
            font-size: 13px;
            line-height: 1.45;
            text-align: center;
        }

        .status-text.success {
            background: #e1f5e8;
            color: #166534;
        }

        .status-text.error {
            background: #fee2e2;
            color: #991b1b;
        }

        .search-box {
            margin-bottom: 18px;
            border-bottom: 1px solid #dde5de;
            padding-bottom: 18px;
        }

        .search-box p {
            margin: 5px 0 12px;
            color: #5b665f;
            font-size: 13px;
            line-height: 1.55;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #344239;
            font-size: 12px;
            font-weight: 800;
        }

        .form-group input {
            width: 100%;
            min-height: 42px;
            border: 1px solid #d4ddd5;
            border-radius: 6px;
            padding: 10px 12px;
            background: #fbfdfb;
            color: #17211b;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: 3px solid rgba(31, 122, 69, 0.16);
            border-color: #1f7a45;
            background: #fff;
        }

        .form-group input[readonly] {
            background: #f3f6f3;
            color: #4f5d54;
        }

        .loading-overlay {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 14px;
            background: rgba(10, 18, 13, 0.62);
            color: #fff;
        }

        .loading-overlay.show {
            display: flex;
        }

        .spinner {
            width: 42px;
            height: 42px;
            border: 4px solid rgba(255, 255, 255, 0.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.9s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .toast-container {
            position: fixed;
            top: 18px;
            right: 18px;
            z-index: 60;
            display: grid;
            gap: 10px;
            width: min(360px, calc(100% - 36px));
        }

        .toast {
            border-left: 5px solid #1f7a45;
            border-radius: 8px;
            padding: 14px 16px;
            background: #fff;
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.22s ease-out;
        }

        .toast.error {
            border-left-color: #dc2626;
        }

        .toast.warning {
            border-left-color: #d97706;
        }

        .toast-title {
            font-size: 14px;
            font-weight: 900;
            color: #17211b;
        }

        .toast-message {
            margin-top: 3px;
            color: #56625b;
            font-size: 13px;
            line-height: 1.45;
        }

        @keyframes slideIn {
            from {
                transform: translateX(20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 840px) {
            body {
                background-attachment: scroll;
            }

            .page {
                width: min(100% - 24px, 560px);
                justify-content: flex-start;
                padding: 22px 0;
            }

            .content {
                grid-template-columns: 1fr;
            }

            .controls,
            .form-actions,
            .search-actions {
                grid-template-columns: 1fr;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <div>Memproses...</div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <main class="page">
        <header class="header">
            <h1>Check Kehadiran</h1>

        </header>

        <section class="content">
            <div class="panel scanner-panel">
                <div class="panel-title">
                    <h2>Scan Barcode</h2>
                    <span class="badge">Live Camera</span>
                </div>

                <div class="camera-container">
                    <video id="video" playsinline muted></video>
                    <canvas id="canvas"></canvas>
                    <div class="scanner-overlay"></div>
                </div>

                <div class="controls">
                    <button type="button" class="btn btn-primary" onclick="startScanning()">Mulai Scan</button>
                    <button type="button" class="btn btn-soft" onclick="stopScanning()">Stop</button>
                    <button type="button" class="btn btn-soft" onclick="window.history.back()">Kembali</button>
                </div>

                <div class="status-text" id="statusText">Tekan "Mulai Scan" untuk memulai.</div>
            </div>

            <div class="panel data-panel">
                <div class="search-box">
                    <div class="panel-title">
                        <h2>Cari Manual</h2>
                        <span class="badge">Tanpa QR</span>
                    </div>
                    <p>Input nama atau no. WhatsApp sesuai data undangan, lalu konfirmasi kehadiran setelah data tampil.
                    </p>
                    <form id="manualSearchForm">
                        <div class="form-group">
                            <label for="search_query">Nama / No. WhatsApp</label>
                            <input type="search" id="search_query" name="query"
                                placeholder="Contoh: Budi atau 081234567890" autocomplete="off">
                        </div>
                        <div class="search-actions">
                            <button type="submit" class="btn btn-dark">Cari Data</button>
                            <button type="button" class="btn btn-soft" onclick="clearSearch()">Bersihkan</button>
                        </div>
                    </form>
                </div>

                <form id="attendanceForm" method="POST" action="/record-presence">
                    @csrf
                    <div class="panel-title">
                        <h2>Data Kehadiran</h2>
                    </div>

                    <div class="form-group">
                        <label for="nama_mhs">Nama</label>
                        <input type="text" id="nama_mhs" name="nama_mhs" readonly>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" id="status" name="status" readonly>
                    </div>

                    <div class="form-group">
                        <label for="wa_mhs">No. WhatsApp</label>
                        <input type="text" id="wa_mhs" name="wa_mhs" readonly>
                    </div>

                    <div class="form-group" id="parentSection" style="display: none;">
                        <label for="nama_ortu_1">Nama Orang Tua/Wali</label>
                        <input type="text" id="nama_ortu_1" name="nama_ortu_1" readonly>
                    </div>

                    <div class="form-group" id="parentSection2" style="display: none;">
                        <label for="nama_ortu_2">Nama Orang Tua/Wali Kedua</label>
                        <input type="text" id="nama_ortu_2" name="nama_ortu_2" readonly>
                    </div>

                    <input type="hidden" id="invitation_id" name="invitation_id">

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Konfirmasi Kehadiran</button>
                        <button type="button" class="btn btn-soft" onclick="resetForm()">Reset</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const statusText = document.getElementById('statusText');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const toastContainer = document.getElementById('toastContainer');

        let scanning = false;
        let lastScannedWa = null;
        let lastScanTime = 0;
        let scannedToday = {};
        let isSubmitting = false;
        let scanFrameId = null;

        const findInvitationUrl = @json(route('find-by-wa-ortu'));
        const searchInvitationUrl = @json(route('search-invitation'));
        const recordPresenceUrl = @json(route('record-presence'));

        function showToast(title, message, type = 'success', duration = 3600) {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            `;
            toastContainer.appendChild(toast);
            setTimeout(() => toast.remove(), duration);
        }

        function updateStatus(message, type = 'normal') {
            statusText.textContent = message;
            statusText.className = 'status-text';
            if (type === 'success') statusText.classList.add('success');
            if (type === 'error') statusText.classList.add('error');
        }

        function showLoading(show) {
            loadingOverlay.classList.toggle('show', show);
        }

        async function postJson(url, payload) {
            const response = await fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(payload)
            });

            const contentType = response.headers.get('content-type') || '';
            const result = contentType.includes('application/json')
                ? await response.json()
                : { success: false, message: await response.text() };

            if (!response.ok) {
                const error = new Error(result.message || `Server error (${response.status})`);
                error.status = response.status;
                error.payload = result;
                throw error;
            }

            return result;
        }

        async function startScanning() {
            if (scanning) return;

            if (typeof jsQR !== 'function') {
                updateStatus('Library scanner gagal dimuat.', 'error');
                showToast('Scanner Error', 'Periksa koneksi internet atau CDN jsQR.', 'error');
                return;
            }

            if (!window.isSecureContext && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
                updateStatus('Browser membutuhkan HTTPS untuk akses kamera.', 'error');
                showToast('Akses Kamera Ditolak', 'Pastikan halaman dibuka dengan HTTPS.', 'error', 5200);
                return;
            }

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                updateStatus('Browser tidak mendukung akses kamera.', 'error');
                showToast('Browser Tidak Didukung', 'Gunakan Chrome, Firefox, Safari, atau Edge terbaru.', 'error');
                return;
            }

            updateStatus('Meminta izin kamera...');

            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    audio: false,
                    video: {
                        facingMode: { ideal: 'environment' },
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                });

                video.srcObject = stream;
                await video.play();
                scanning = true;
                updateStatus('Kamera aktif. Arahkan ke QR Code.', 'success');
                scanFrameId = requestAnimationFrame(scanQR);
            } catch (err) {
                let message = err.message || 'Kamera tidak bisa diakses.';
                if (err.name === 'NotAllowedError') message = 'Izin kamera ditolak. Aktifkan izin kamera di browser.';
                if (err.name === 'NotFoundError') message = 'Kamera tidak ditemukan di perangkat ini.';
                if (err.name === 'NotReadableError') message = 'Kamera sedang digunakan aplikasi lain.';

                updateStatus(message, 'error');
                showToast('Error Kamera', message, 'error', 5200);
            }
        }

        function stopScanning() {
            scanning = false;

            if (scanFrameId) {
                cancelAnimationFrame(scanFrameId);
                scanFrameId = null;
            }

            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }

            updateStatus('Scan dihentikan.');
        }

        function scanQR() {
            if (!scanning) return;

            if (video.readyState < HTMLMediaElement.HAVE_CURRENT_DATA || !video.videoWidth || !video.videoHeight) {
                scanFrameId = requestAnimationFrame(scanQR);
                return;
            }

            const ctx = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: 'attemptBoth'
            });

            if (!code) {
                scanFrameId = requestAnimationFrame(scanQR);
                return;
            }

            const waMhs = code.data.trim();
            const currentTime = Date.now();

            if (!waMhs || (lastScannedWa === waMhs && currentTime - lastScanTime < 3000)) {
                scanFrameId = requestAnimationFrame(scanQR);
                return;
            }

            lastScannedWa = waMhs;
            lastScanTime = currentTime;

            // Kamera tetap hidup
            fetchInvitationData(waMhs, true);

            // lanjut scan lagi
            scanFrameId = requestAnimationFrame(scanQR);
        }

        async function fetchInvitationData(waMhs, autoSubmit = false) {
            if (scannedToday[waMhs]) {
                showToast('Sudah Diproses', 'Data ini sudah diproses dari halaman scanner.', 'warning');
                return;
            }

            showLoading(true);
            updateStatus('Mengambil data undangan...');

            try {
                const result = await postJson(findInvitationUrl, { wa_mhs: waMhs });
                showLoading(false);

                if (!result.success) {
                    delete scannedToday[waMhs];
                    updateStatus(result.message || 'Data tidak ditemukan.', 'error');
                    showToast('Data Tidak Ditemukan', result.message || 'Coba cari manual dengan nama.', 'error');
                    return;
                }

                populateForm(result.data);
                updateStatus('Data ditemukan.', 'success');
                showToast('Data Ditemukan', `${result.data.nama_mhs} siap dikonfirmasi.`);

                if (autoSubmit) {
                    scannedToday[waMhs] = true;
                    setTimeout(() => {
                        isSubmitting = false;
                        document.getElementById('attendanceForm').dispatchEvent(new Event('submit'));
                    }, 1200);
                }
            } catch (err) {
                showLoading(false);
                delete scannedToday[waMhs];
                updateStatus(err.message || 'Gagal mengambil data.', 'error');
                showToast('Gagal Mengambil Data', err.message || 'Silahkan coba lagi.', 'error');
            }
        }

        function populateForm(data) {
            document.getElementById('nama_mhs').value = data.nama_mhs || '';
            document.getElementById('status').value = data.status || '';
            document.getElementById('wa_mhs').value = data.wa_mhs || '';
            document.getElementById('invitation_id').value = data.id || '';

            const parentSection = document.getElementById('parentSection');
            const parentSection2 = document.getElementById('parentSection2');
            const parentName1 = document.getElementById('nama_ortu_1');
            const parentName2 = document.getElementById('nama_ortu_2');

            parentName1.value = data.nama_ortu_1 || '';
            parentName2.value = data.nama_ortu_2 || '';
            parentSection.style.display = data.nama_ortu_1 ? 'block' : 'none';
            parentSection2.style.display = data.nama_ortu_2 ? 'block' : 'none';
        }

        function resetForm() {
            document.getElementById('attendanceForm').reset();
            document.getElementById('invitation_id').value = '';
            document.getElementById('parentSection').style.display = 'none';
            document.getElementById('parentSection2').style.display = 'none';
            lastScannedWa = null;
            isSubmitting = false;
            updateStatus('Tekan "Mulai Scan" untuk memulai.');
        }

        function clearSearch() {
            document.getElementById('search_query').value = '';
            resetForm();
        }

        document.getElementById('manualSearchForm').addEventListener('submit', async function (event) {
            event.preventDefault();

            const query = document.getElementById('search_query').value.trim();
            if (query.length < 2) {
                showToast('Input Belum Lengkap', 'Masukkan minimal 2 karakter nama atau nomor WA.', 'warning');
                return;
            }

            showLoading(true);
            updateStatus('Mencari data undangan...');

            try {
                const result = await postJson(searchInvitationUrl, { query });
                showLoading(false);
                populateForm(result.data);
                stopScanning();
                updateStatus('Data ditemukan. Klik konfirmasi untuk mencatat kehadiran.', 'success');
                showToast('Data Ditemukan', `${result.data.nama_mhs} siap dikonfirmasi.`);
            } catch (err) {
                showLoading(false);
                updateStatus(err.message || 'Data tidak ditemukan.', 'error');
                showToast('Data Tidak Ditemukan', err.message || 'Coba cek lagi nama atau nomor WA.', 'error');
            }
        });

        document.getElementById('attendanceForm').addEventListener('submit', async function (event) {
            event.preventDefault();

            if (isSubmitting) return;

            const formData = new FormData(this);
            const waMhs = formData.get('wa_mhs');
            const namaMhs = document.getElementById('nama_mhs').value;

            if (!waMhs || !formData.get('invitation_id')) {
                showToast('Data Belum Dipilih', 'Scan QR atau cari data terlebih dahulu.', 'warning');
                return;
            }

            showLoading(true);
            isSubmitting = true;

            try {
                const result = await postJson(recordPresenceUrl, {
                    wa_mhs: waMhs,
                    invitation_id: formData.get('invitation_id')
                });

                showLoading(false);

                if (result.success) {
                    scannedToday[waMhs] = true;
                    updateStatus('Kehadiran berhasil dicatat.', 'success');
                    showToast('Hadir', `${namaMhs} berhasil dicatat hadir.`);
                    setTimeout(resetForm, 1800);
                    return;
                }

                updateStatus(result.message || 'Gagal mencatat kehadiran.', 'error');
                showToast('Gagal', result.message || 'Silahkan coba lagi.', 'error');
                isSubmitting = false;
            } catch (err) {
                showLoading(false);

                if (err.payload && err.payload.data) {
                    scannedToday[waMhs] = true;
                    updateStatus('Sudah tercatat kehadiran hari ini.', 'error');
                    showToast('Sudah Hadir', 'Data ini sudah tercatat hari ini.', 'warning');
                    setTimeout(resetForm, 1800);
                    return;
                }

                updateStatus(err.message || 'Gagal menyimpan kehadiran.', 'error');
                showToast('Terjadi Kesalahan', err.message || 'Silahkan coba lagi.', 'error');
                isSubmitting = false;
            }
        });

        window.addEventListener('load', () => setTimeout(startScanning, 500));
        window.addEventListener('beforeunload', stopScanning);
        window.addEventListener('pagehide', stopScanning);
    </script>
</body>

</html>
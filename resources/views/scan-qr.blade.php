<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan QR Code</title>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #333;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 14px;
            color: #888;
        }

        .content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        /* Camera Section */
        .camera-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .camera-container {
            position: relative;
            width: 100%;
            max-width: 300px;
            background: #000;
            border-radius: 4px;
            overflow: hidden;
            aspect-ratio: 1;
            margin: 0 auto;
        }

        #video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        #canvas {
            display: none;
        }

        .scanner-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 200px;
            border: 2px solid #0f0;
            border-radius: 6px;
            z-index: 10;
        }

        .controls {
            display: flex;
            gap: 10px;
        }

        .btn-control {
            flex: 1;
            padding: 10px 16px;
            font-size: 13px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            color: #333;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-control:hover {
            background-color: #f5f5f5;
            border-color: #999;
        }

        .status-text {
            font-size: 13px;
            color: #666;
            text-align: center;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }

        .status-text.success {
            color: #0b7d22;
            background-color: #d9edda;
        }

        .status-text.error {
            color: #b91d13;
            background-color: #f8d7da;
        }

        /* Form Section */
        .form-section {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: block;
        }

        .form-section h2 {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #555;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            font-size: 13px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            background-color: #fafafa;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 60px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #333;
            background-color: white;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            flex: 1;
            padding: 10px 16px;
            font-size: 13px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .btn-submit {
            background-color: #333;
            color: white;
        }

        .btn-submit:hover {
            background-color: #000;
        }

        .btn-cancel {
            background-color: #e0e0e0;
            color: #333;
        }

        .btn-cancel:hover {
            background-color: #d0d0d0;
        }

        /* Loading */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .loading-overlay.show {
            display: flex;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #333;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            color: white;
            font-size: 14px;
        }

        /* Toast Notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: white;
            padding: 16px 24px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 320px;
            animation: slideInRight 0.3s ease-out;
            border-left: 4px solid #333;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .toast.hide {
            animation: slideOutRight 0.3s ease-out;
        }

        .toast-icon {
            font-size: 24px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }

        .toast-message {
            font-size: 13px;
            color: #666;
            line-height: 1.4;
        }

        .toast.success {
            border-left-color: #0b7d22;
            background-color: #d9edda;
        }

        .toast.success .toast-icon {
            color: #0b7d22;
        }

        .toast.success .toast-title {
            color: #0b7d22;
        }

        .toast.error {
            border-left-color: #b91d13;
            background-color: #f8d7da;
        }

        .toast.error .toast-icon {
            color: #b91d13;
        }

        .toast.error .toast-title {
            color: #b91d13;
        }

        .toast.warning {
            border-left-color: #ff9800;
            background-color: #fff3cd;
        }

        .toast.warning .toast-icon {
            color: #ff9800;
        }

        .toast.warning .toast-title {
            color: #ff9800;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <div class="loading-text">Memproses...</div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <div class="container">
        <div class="header">
            <h1>Scan QR Code</h1>
            <p>Arahkan kamera ke QR Code untuk mengisi form kehadiran</p>
        </div>

        <div class="content">
            <!-- Form Section -->
            <div class="form-section" id="formSection">
                <h2>Data Kehadiran</h2>
                <form id="attendanceForm" method="POST" action="/record-presence">
                    @csrf

                    <div class="form-group">
                        <label for="nama_mhs">Nama Mahasiswa</label>
                        <input type="text" id="nama_mhs" name="nama_mhs" readonly>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" id="status" name="status" readonly>
                    </div>
                    <div class="form-group">
                        <label for="wa_mhs">No. WhatsApp Mahasiswa</label>
                        <input type="text" id="wa_mhs" name="wa_mhs" readonly>
                    </div>
                    <input type="hidden" id="invitation_id" name="invitation_id">

                    <div class="form-actions">
                        <button type="submit" class="btn btn-submit">Konfirmasi Kehadiran</button>
                        <button type="button" class="btn btn-cancel" onclick="resetForm()">Reset</button>
                    </div>
                </form>
            </div>

            <!-- Camera Section -->
            <div class="camera-section">
                <div class="camera-container">
                    <video id="video" autoplay playsinline></video>
                    <canvas id="canvas"></canvas>
                    <div class="scanner-overlay"></div>
                </div>

                <div class="controls">
                    <button class="btn-control" onclick="startScanning()">Mulai Scan</button>
                    <button class="btn-control" onclick="stopScanning()">Stop</button>
                    <button class="btn-control" onclick="window.history.back()">Kembali</button>
                </div>

                <div class="status-text" id="statusText">Tekan "Mulai Scan" untuk memulai</div>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const statusText = document.getElementById('statusText');
        const formSection = document.getElementById('formSection');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const toastContainer = document.getElementById('toastContainer');

        let scanning = false;
        let lastScannedWa = null;
        let lastScanTime = 0;
        let scannedToday = {}; // Track who has been scanned today
        let isSubmitting = false; // Prevent multiple form submissions
        let scanFrameId = null;

        const basePath = window.location.pathname.startsWith('/sinergi') ? '/sinergi' : '';
        const findInvitationUrl = `${basePath}/api/find-by-wa-ortu`;
        const findInvitationFallbackUrl = `${basePath}/api/find-by-wa-mhs`;
        const recordPresenceUrl = `${basePath}/record-presence`;

        // Toast notification function
        function showToast(title, message, type = 'success', duration = 4000) {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            let icon = '✓';
            if (type === 'error') icon = '✕';
            if (type === 'warning') icon = '⚠';
            
            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Auto remove toast
            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 300);
            }, duration);
            
            // Resume scanning after toast appears
            setTimeout(() => {
                if (!scanning) {
                    startScanning();
                }
            }, 500);
        }

        function updateStatus(message, type = 'normal') {
            statusText.textContent = message;
            statusText.className = 'status-text';
            if (type === 'success') statusText.classList.add('success');
            if (type === 'error') statusText.classList.add('error');
        }

        function startScanning() {
            if (scanning) return;

            // Check HTTPS requirement
            if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
                const errorMsg = 'Website harus menggunakan HTTPS untuk akses kamera. Hubungi administrator.';
                updateStatus('⚠ ' + errorMsg, 'error');
                showToast('Keamanan Browser', errorMsg, 'error', 6000);
                console.warn('Camera requires HTTPS - current protocol:', location.protocol);
                return;
            }

            // Check if getUserMedia is supported
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                const errorMsg = 'Browser Anda tidak mendukung akses kamera. Gunakan Chrome, Firefox, atau Safari terbaru.';
                updateStatus('❌ ' + errorMsg, 'error');
                showToast('Browser Tidak Didukung', errorMsg, 'error');
                return;
            }

            navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment' }
            }).then(stream => {
                video.srcObject = stream;
                scanning = true;
                updateStatus('✓ Kamera aktif - Arahkan ke QR Code', 'success');
                scanQR();
            }).catch(err => {
                console.error('Camera Error:', err.name, err.message);
                let errorMsg = err.message;
                
                // Provide user-friendly error messages
                if (err.name === 'NotAllowedError') {
                    errorMsg = 'Izin kamera ditolak. Silakan beri izin di pengaturan browser.';
                } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                    errorMsg = 'Kamera tidak ditemukan di perangkat ini.';
                } else if (err.name === 'NotSecureError') {
                    errorMsg = 'Koneksi tidak aman. Gunakan HTTPS untuk akses kamera.';
                } else if (err.name === 'TypeError') {
                    errorMsg = 'Error mengakses kamera. Periksa koneksi internet Anda.';
                }
                
                updateStatus('❌ ' + errorMsg, 'error');
                showToast('Error Kamera', errorMsg, 'error', 6000);
            });
        }

        function stopScanning() {
            scanning = false;
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
            }
            updateStatus('Scan dihentikan');
        }

        function scanQR() {
            if (!scanning) return;

            const ctx = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            if (canvas.width > 0 && canvas.height > 0) {
                ctx.drawImage(video, 0, 0);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);

                if (code) {
                    const waMhs = code.data.trim();
                    
                    // Check if already scanned today - PREVENT DUPLICATE IMMEDIATELY
                    if (scannedToday[waMhs]) {
                        console.log('Already scanned today, showing alert');
                        scanning = false;
                        showToast('Sudah Mengisi Kehadiran ⚠', `Anda sudah mengisi form kehadiran. Tidak dapat scan dua kali!`, 'warning', 4000);
                        // Resume scanning for next person
                        setTimeout(() => startScanning(), 500);
                        return;
                    }
                    
                    // Prevent duplicate rapid scanning
                    const currentTime = Date.now();
                    if (lastScannedWa === waMhs && currentTime - lastScanTime < 3000) {
                        console.log('Duplicate scan detected, ignoring');
                        requestAnimationFrame(scanQR);
                        return;
                    }
                    
                    lastScannedWa = waMhs;
                    lastScanTime = currentTime;
                    
                    // MARK AS SCANNED IMMEDIATELY before any async operation
                    scannedToday[waMhs] = true;
                    
                    console.log('QR Code detected:', waMhs);
                    fetchInvitationData(waMhs);
                    scanning = false;
                    return;
                }
            }

            requestAnimationFrame(scanQR);
        }

        async function requestInvitationData(url, waMhs) {
            const response = await fetch(url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ wa_mhs: waMhs })
            });

            const contentType = response.headers.get('content-type') || '';
            const payload = contentType.includes('application/json')
                ? await response.json()
                : { success: false, message: await response.text() };

            if (!response.ok) {
                const message = response.status === 419
                    ? 'Sesi halaman scan kedaluwarsa. Refresh halaman lalu coba scan lagi.'
                    : (payload.message || `Server error (${response.status})`);

                const error = new Error(message);
                error.status = response.status;
                throw error;
            }

            return payload;
        }

        async function fetchInvitationData(waMhs) {
            showLoading(true);
            updateStatus('Mengambil data...');

            try {
                let result;

                try {
                    result = await requestInvitationData(findInvitationUrl, waMhs);
                } catch (err) {
                    if (err.status !== 404) {
                        throw err;
                    }

                    console.warn('Endpoint utama tidak ditemukan, mencoba endpoint lama:', findInvitationFallbackUrl);
                    result = await requestInvitationData(findInvitationFallbackUrl, waMhs);
                }

                showLoading(false);
                if (result.success) {
                    populateForm(result.data);
                    // scannedToday[waOrtu] is already TRUE from scanQR() - keep it
                    updateStatus('Data ditemukan! Konfirmasi dalam 2 detik...', 'success');
                    
                    // Auto-submit setelah 2 detik
                    setTimeout(() => {
                        isSubmitting = false; // UNLOCK before submitting
                        document.getElementById('attendanceForm').dispatchEvent(new Event('submit'));
                    }, 2000);
                } else {
                    // Data not found - keep scannedToday[waOrtu] = true to prevent retry
                    delete scannedToday[waMhs];
                    isSubmitting = false; // Unlock if failed
                    updateStatus(result.message || 'Data tidak ditemukan', 'error');
                    showToast('Data Tidak Ditemukan', result.message || 'Silahkan daftarkan diri terlebih dahulu', 'error', 3000);
                }
            } catch (err) {
                console.error('Find invitation error:', err);
                showLoading(false);
                // Error - keep scannedToday[waOrtu] = true to prevent retry
                delete scannedToday[waMhs];
                isSubmitting = false; // Unlock if error
                updateStatus(err.message || 'Gagal mengambil data', 'error');
                showToast('Gagal Mengambil Data', err.message || 'Silahkan coba lagi atau hubungi admin', 'error', 5000);
            }
        }

        function populateForm(data) {
            document.getElementById('nama_mhs').value = data.nama_mhs || '';
            document.getElementById('status').value = data.status || '';
            document.getElementById('wa_mhs').value = data.wa_mhs || '';
            document.getElementById('invitation_id').value = data.id || '';
        }

        function resetForm() {
            // Clear semua input fields
            document.getElementById('nama_mhs').value = '';
            document.getElementById('status').value = '';
            document.getElementById('wa_mhs').value = '';
            document.getElementById('invitation_id').value = '';
            
            // Reset form state
            document.getElementById('attendanceForm').reset();
            formSection.classList.remove('show');
            updateStatus('Tekan "Mulai Scan" untuk memulai');
            lastScannedWa = null;
            isSubmitting = false;
            
            // Resume scanning
            startScanning();
        }

        function showLoading(show) {
            if (show) {
                loadingOverlay.classList.add('show');
            } else {
                loadingOverlay.classList.remove('show');
            }
        }

        startScanning = async function() {
            if (scanning) return;

            if (typeof jsQR !== 'function') {
                const errorMsg = 'Library scanner gagal dimuat. Periksa koneksi internet atau CDN.';
                updateStatus(errorMsg, 'error');
                showToast('Scanner Error', errorMsg, 'error', 6000);
                return;
            }

            if (!window.isSecureContext && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
                const errorMsg = 'SSL/HTTPS belum valid, sehingga browser menolak akses kamera.';
                updateStatus(errorMsg, 'error');
                showToast('Keamanan Browser', errorMsg, 'error', 6000);
                console.warn('Camera requires a secure context:', {
                    protocol: location.protocol,
                    isSecureContext: window.isSecureContext
                });
                return;
            }

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                const errorMsg = 'Browser Anda tidak mendukung akses kamera. Gunakan Chrome, Firefox, atau Safari terbaru.';
                updateStatus(errorMsg, 'error');
                showToast('Browser Tidak Didukung', errorMsg, 'error');
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
                video.setAttribute('playsinline', true);
                await video.play();

                scanning = true;
                updateStatus('Kamera aktif - Arahkan ke QR Code', 'success');

                if (scanFrameId) {
                    cancelAnimationFrame(scanFrameId);
                }
                scanFrameId = requestAnimationFrame(scanQR);
            } catch (err) {
                console.error('Camera Error:', err.name, err.message);
                let errorMsg = err.message || 'Kamera tidak bisa diakses.';

                if (err.name === 'NotAllowedError') {
                    errorMsg = 'Izin kamera ditolak. Klik ikon di address bar browser lalu pilih Camera: Allow.';
                } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                    errorMsg = 'Kamera tidak ditemukan di perangkat ini.';
                } else if (err.name === 'NotReadableError') {
                    errorMsg = 'Kamera sedang dipakai aplikasi lain. Tutup aplikasi kamera lalu coba lagi.';
                } else if (err.name === 'NotSecureError') {
                    errorMsg = 'Koneksi tidak aman. Pastikan SSL/HTTPS domain sudah valid.';
                }

                updateStatus(errorMsg, 'error');
                showToast('Error Kamera', errorMsg, 'error', 6000);
            }
        };

        stopScanning = function() {
            scanning = false;

            if (scanFrameId) {
                cancelAnimationFrame(scanFrameId);
                scanFrameId = null;
            }

            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }

            updateStatus('Scan dihentikan');
        };

        scanQR = function() {
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

            if (!waMhs) {
                scanFrameId = requestAnimationFrame(scanQR);
                return;
            }

            if (scannedToday[waMhs]) {
                scanning = false;
                showToast('Sudah Mengisi Kehadiran', 'Anda sudah mengisi form kehadiran. Tidak dapat scan dua kali!', 'warning', 4000);
                setTimeout(() => startScanning(), 500);
                return;
            }

            const currentTime = Date.now();
            if (lastScannedWa === waMhs && currentTime - lastScanTime < 3000) {
                scanFrameId = requestAnimationFrame(scanQR);
                return;
            }

            lastScannedWa = waMhs;
            lastScanTime = currentTime;
            scannedToday[waMhs] = true;
            scanning = false;

            if (scanFrameId) {
                cancelAnimationFrame(scanFrameId);
                scanFrameId = null;
            }

            console.log('QR Code detected:', waMhs);
            fetchInvitationData(waMhs);
        };

        // Auto-start scanning on page load
        window.addEventListener('load', function() {
            setTimeout(startScanning, 500);
        });

        // Handle form submission
        document.getElementById('attendanceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Prevent multiple submissions
            if (isSubmitting) {
                console.log('Already submitting, ignoring');
                return;
            }
            
            console.log('Form submitted!');
            showLoading(true);
            isSubmitting = true;

            const formData = new FormData(this);
            const waMhs = formData.get('wa_mhs');
            const namaMhs = document.getElementById('nama_mhs').value;

            console.log('Submitting presence with waMhs:', waMhs);

            fetch(recordPresenceUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    wa_mhs: waMhs,
                    invitation_id: formData.get('invitation_id')
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(result => {
                console.log('Result:', result);
                showLoading(false);
                
                // Check if already present (duplicate scan)
                if (!result.success && result.data) {
                    // Already scanned - don't save again
                    updateStatus('Sudah tercatat kehadiran hari ini', 'error');
                    // KEEP scannedToday[waMhs] = true to block further scans
                    const scanTime = new Date(result.data.present_at).toLocaleTimeString('id-ID');
                    showToast('Sudah Mengisi Kehadiran ⚠', `Anda sudah mengisi form kehadiran. Tidak dapat scan dua kali!`, 'warning', 5000);
                    
                    // Countdown before reset (2 seconds)
                    let countdown = 2;
                    const countdownInterval = setInterval(() => {
                        if (countdown > 0) {
                            updateStatus(`Form akan di-reset dalam ${countdown} detik...`, 'error');
                            countdown--;
                        } else {
                            clearInterval(countdownInterval);
                            isSubmitting = false;
                            resetForm();
                        }
                    }, 1000);
                } else if (result.success) {
                    console.log('Success! Data saved to database');
                    updateStatus('Kehadiran berhasil dicatat!', 'success');
                    // KEEP scannedToday[waMhs] = true to block further scans
                    showToast('Hadir ✓', `${namaMhs} - Status: HADIR`, 'success', 3000);
                    
                    // Countdown before reset (2 seconds)
                    let countdown = 2;
                    const countdownInterval = setInterval(() => {
                        if (countdown > 0) {
                            updateStatus(`Form akan di-reset dalam ${countdown} detik...`, 'success');
                            countdown--;
                        } else {
                            clearInterval(countdownInterval);
                            isSubmitting = false;
                            resetForm();
                        }
                    }, 1000);
                } else {
                    updateStatus('Gagal mencatat kehadiran', 'error');
                    showToast('Gagal', 'Gagal mencatat kehadiran. Silahkan coba lagi.', 'error', 3000);
                    // KEEP scannedToday[waMhs] = true to block further scans
                    isSubmitting = false; // Unlock
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
                showLoading(false);
                updateStatus('Gagal menyimpan kehadiran', 'error');
                showToast('Terjadi Kesalahan', 'Gagal menyimpan kehadiran. Silahkan coba lagi.', 'error', 3000);
                // KEEP scannedToday[waMhs] = true to block further scans
                isSubmitting = false; // Unlock
            });
        });
    </script>
</body>
</html>

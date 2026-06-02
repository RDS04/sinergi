<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Kartu Undangan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: #0f172a;
            color: #111827;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .page {
            width: 100%;
            max-width: 520px;
            position: relative;
        }

        .card {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.35);
            background: #fff;
        }

        .card img.bg {
            width: 100%;
            display: block;
            object-fit: cover;
            height: auto;
        }

        .qr-overlay {
            position: absolute;
            left: 50%;
            top: 50%;
            width: min(180px, 60%);
            aspect-ratio: 1;
            transform: translate(-50%, -50%);
            border-radius: 20px;
            background: rgba(255,255,255,0.95);
            border: 2px solid rgba(255,255,255,0.85);
            display: grid;
            place-items: center;
            padding: 12px;
            box-shadow: 0 12px 28px rgba(0,0,0,0.18);
        }

        .qr-overlay img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 16px;
        }

        .message {
            margin-top: 18px;
            text-align: center;
            color: #f8fafc;
            font-size: 14px;
            line-height: 1.6;
        }

        .actions {
            margin-top: 18px;
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .actions a,
        .actions button {
            padding: 12px 18px;
            border-radius: 999px;
            border: none;
            background: #facc15;
            color: #0f172a;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .actions a:hover,
        .actions button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 30px rgba(250,204,21,0.25);
        }

        .note {
            margin-top: 10px;
            color: rgba(255,255,255,0.75);
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 520px) {
            .qr-overlay {
                width: 70%;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <img class="bg" src="{{ asset('storage/kartu undangan.png') }}" alt="Kartu Undangan" onerror="console.error('Gambar kartu gagal dimuat dari: ' + this.src)">
            <div class="qr-overlay">
                <img id="qrCodeImage" crossorigin="anonymous" src="" alt="QR Code" />
            </div>
        </div>
        <p class="message">QR Code akan otomatis muncul di tengah kartu undangan ketika halaman dibuka melalui tombol "Buka Kartu Undangan".</p>
        <div class="actions">
            <a id="backButton" href="javascript:history.back()">Kembali</a>
            <button id="downloadCard">Download Kartu</button>
        </div>
        <p class="note">Jika QR Code tidak tampil, buka kembali dari halaman undangan setelah membuat QR Code.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        const qrImage = document.getElementById('qrCodeImage');
        const downloadBtn = document.getElementById('downloadCard');

        const storedQr = localStorage.getItem('invitationQrData');

        if (storedQr) {
            qrImage.src = storedQr;
        } else {
            qrImage.alt = 'Tidak ada QR code';
            qrImage.style.opacity = '0.3';
        }

        downloadBtn.addEventListener('click', () => {
            if (!storedQr) {
                alert('QR Code belum tersedia. Silakan kembali ke halaman undangan dan buat QR Code terlebih dahulu.');
                return;
            }
            downloadBtn.disabled = true;
            downloadBtn.textContent = 'Memproses...';
            
            const cardElement = document.querySelector('.card');
            html2canvas(cardElement, {
                backgroundColor: null,
                scale: window.devicePixelRatio || 2,
                useCORS: true,
                allowTaint: true,
                logging: false,
                proxy: null,
                ignoreElements: (element) => {
                    return false;
                }
            }).then(canvas => {
                try {
                    const link = document.createElement('a');
                    link.href = canvas.toDataURL('image/png');
                    link.download = 'kartu-undangan.png';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    downloadBtn.disabled = false;
                    downloadBtn.textContent = 'Download Kartu';
                } catch (error) {
                    console.error('Download error:', error);
                    alert('Gagal mengunduh kartu. Silakan coba lagi.');
                    downloadBtn.disabled = false;
                    downloadBtn.textContent = 'Download Kartu';
                }
            }).catch(error => {
                console.error('Canvas error:', error);
                alert('Gagal membuat unduhan kartu. Silakan coba lagi.');
                downloadBtn.disabled = false;
                downloadBtn.textContent = 'Download Kartu';
            });
        });
    </script>
</body>
</html>
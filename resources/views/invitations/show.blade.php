<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Undangan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            color: #1a1a1a;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 13px;
            color: #666;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            text-align: center;
        }

        .barcode-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .barcode-section h2 {
            font-size: 14px;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .barcode-container {
            background: white;
            padding: 20px;
            border-radius: 4px;
            display: inline-block;
            border: 1px solid #ddd;
        }

        .barcode-container svg {
            max-width: 100%;
            height: auto;
        }

        .data-section {
            margin-top: 30px;
        }

        .section-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #999;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .data-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .data-item {
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .data-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 4px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .data-value {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .data-item.full {
            grid-column: 1 / -1;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        button {
            flex: 1;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-print {
            background-color: #333;
            color: white;
        }

        .btn-print:hover {
            background-color: #000;
        }

        .btn-back {
            background-color: #f0f0f0;
            color: #333;
        }

        .btn-back:hover {
            background-color: #e0e0e0;
        }

        .btn-download {
            background-color: #28a745;
            color: white;
        }

        .btn-download:hover {
            background-color: #218838;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 20px;
            }

            .button-group {
                display: none;
            }

            .success-message {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }

            .data-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .button-group {
                flex-direction: column;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bukti Undangan</h1>
            <p>Data undangan Anda telah berhasil terdaftar</p>
        </div>

        <div class="success-message">
            ✓ Data berhasil ditambahkan ke sistem
        </div>

        <!-- Barcode Section -->
        <div class="barcode-section">
            <h2>QR Code Checkin Mahasiswa</h2>
            <div class="barcode-container">
                <img src="{{ $qrCodeUrl }}" alt="QR Code Checkin" style="max-width: 100%; height: auto;">
            </div>
            <p style="font-size: 12px; color: #666; margin-top: 10px;">
                <strong>Nomor WhatsApp Mahasiswa:</strong> {{ $invitation->wa_mhs }}<br>
                <small style="color: #999;">Scan untuk checkin di event</small>
            </p>
        </div>

        <!-- Attendance QR Code Section -->
        <div class="barcode-section">
            <h2>Alternatif: Input Manual</h2>
            <p style="font-size: 13px; color: #333; margin-bottom: 15px;">
                Jika QR Code tidak terbaca, buka <strong>/sinergi/scan-qr</strong> dan input nomor WhatsApp Anda
            </p>
            <input type="text" id="manualWaInput" value="{{ $invitation->wa_mhs }}" readonly 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; text-align: center; font-weight: bold;">
            <button type="button" onclick="copyToClipboard('{{ $invitation->wa_mhs }}')" 
                    style="width: 100%; margin-top: 10px; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Salin Nomor WhatsApp
            </button>
        </div>

        <!-- Data Mahasiswa -->
        <div class="data-section">
            <div class="section-title">Data Mahasiswa</div>
            <div class="data-grid">
                <div class="data-item">
                    <div class="data-label">Nama Mahasiswa</div>
                    <div class="data-value">{{ $invitation->nama_mhs }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Status</div>
                    <div class="data-value" style="text-transform: capitalize;">{{ $invitation->status }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Program Studi</div>
                    <div class="data-value">{{ $invitation->prodi }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">No. WhatsApp</div>
                    <div class="data-value">{{ $invitation->wa_mhs }}</div>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua/Wali -->
        <div class="data-section">
            <div class="section-title">Data Orang Tua / Wali</div>
            <div class="data-grid">
                <div class="data-item">
                    <div class="data-label">Nama Orang Tua / Wali</div>
                    <div class="data-value">{{ $invitation->nama_ortu }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">No. WhatsApp</div>
                    <div class="data-value">{{ $invitation->wa_ortu }}</div>
                </div>
                <div class="data-item full">
                    <div class="data-label">Alamat</div>
                    <div class="data-value">{{ $invitation->alamat_ortu }}</div>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <button type="button" class="btn-print" onclick="window.print()">Cetak</button>
            <button type="button" class="btn-print" onclick="window.location='{{ route('scan-qr') }}'" style="background-color: #007bff;">Scan QR</button>
            <button type="button" class="btn-back" onclick="window.location='{{ route('invitation.index') }}'">Kembali</button>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Nomor berhasil disalin!');
            }).catch(err => {
                alert('Gagal menyalin: ' + err);
            });
        }
    </script>
</body>
</html>

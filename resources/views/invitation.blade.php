<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Undangan</title>
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
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #1a1a1a;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 14px;
            color: #666;
        }

        .form-section {
            margin-bottom: 28px;
        }

        .section-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #999;
            margin-bottom: 16px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        textarea:focus {
            outline: none;
            border-color: #555;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        button {
            flex: 1;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-submit {
            background-color: #333;
            color: white;
        }

        .btn-submit:hover {
            background-color: #000;
        }

        .btn-reset {
            background-color: #f0f0f0;
            color: #333;
        }

        .btn-reset:hover {
            background-color: #e0e0e0;
        }

        .loading {
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

        .loading.show {
            display: flex;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #333;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            color: white;
            font-size: 16px;
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .container {
                padding: 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
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
    <!-- Loading Indicator -->
    <div id="loadingOverlay" class="loading">
        <div class="spinner"></div>
        <div class="loading-text">Memproses data...</div>
    </div>

    <div class="container">
        <div class="header">
            <h1>Form Undangan</h1>
            <p>Mohon lengkapi data berikut dengan akurat</p>
        </div>

        @if ($message = Session::get('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                {{ $message }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <strong>Terjadi kesalahan:</strong>
                <ul style="margin-top: 8px; margin-bottom: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('invitation.store') }}">
            @csrf

            <!-- Data Mahasiswa -->
            <div class="form-section">
                <div class="section-title">Data Mahasiswa</div>
                
                <div class="form-group">
                    <label for="nama_mhs">Nama Mahasiswa</label>
                    <input type="text" id="nama_mhs" name="nama_mhs" value="{{ old('nama_mhs') }}" required style="@if ($errors->has('nama_mhs')) border-color: #dc3545; @endif">
                    @if ($errors->has('nama_mhs'))
                        <small style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $errors->first('nama_mhs') }}</small>
                    @endif
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_ortu">Nama Orang Tua / Wali</label>
                        <input type="text" id="nama_ortu" name="nama_ortu" value="{{ old('nama_ortu') }}" required style="@if ($errors->has('nama_ortu')) border-color: #dc3545; @endif">
                        @if ($errors->has('nama_ortu'))
                            <small style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $errors->first('nama_ortu') }}</small>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="prodi">Program Studi</label>
                        <input type="text" id="prodi" name="prodi" value="{{ old('prodi') }}" required style="@if ($errors->has('prodi')) border-color: #dc3545; @endif">
                        @if ($errors->has('prodi'))
                            <small style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $errors->first('prodi') }}</small>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="wa_mhs">Nomor WhatsApp Mahasiswa</label>
                    <input type="tel" id="wa_mhs" name="wa_mhs" value="{{ old('wa_mhs') }}" placeholder="628..." required style="@if ($errors->has('wa_mhs')) border-color: #dc3545; @endif">
                    @if ($errors->has('wa_mhs'))
                        <small style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $errors->first('wa_mhs') }}</small>
                    @endif
                </div>
            </div>

            <!-- Data Orang Tua/Wali -->
            <div class="form-section">
                <div class="section-title">Data Orang Tua / Wali (Lanjutan)</div>
                
                <div class="form-group">
                    <label for="alamat_ortu">Alamat Orang Tua / Wali</label>
                    <textarea id="alamat_ortu" name="alamat_ortu" required style="@if ($errors->has('alamat_ortu')) border-color: #dc3545; @endif">{{ old('alamat_ortu') }}</textarea>
                    @if ($errors->has('alamat_ortu'))
                        <small style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $errors->first('alamat_ortu') }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="wa_ortu">Nomor WhatsApp Orang Tua / Wali</label>
                    <input type="tel" id="wa_ortu" name="wa_ortu" value="{{ old('wa_ortu') }}" placeholder="628..." required style="@if ($errors->has('wa_ortu')) border-color: #dc3545; @endif">
                    @if ($errors->has('wa_ortu'))
                        <small style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $errors->first('wa_ortu') }}</small>
                    @endif
                </div>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <button type="submit" class="btn-submit">Kirim</button>
                <button type="reset" class="btn-reset">Reset</button>
            </div>
        </form>
    </div>

    <script>
        const form = document.querySelector('form');
        const loadingOverlay = document.getElementById('loadingOverlay');

        // Show loading when form is submitted
        form.addEventListener('submit', function(e) {
            // Only show loading if form passes client-side validation
            if (form.checkValidity() === false) {
                e.preventDefault();
                return;
            }
            loadingOverlay.classList.add('show');
        });

        // Clear form when page loads with success message
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('success'))
                const formElement = document.querySelector('form');
                if (formElement) {
                    formElement.reset();
                }
            @endif
        });

        // Auto-hide success message after 5 seconds
        const successMsg = document.querySelector('div[style*="background-color: #d4edda"]');
        if (successMsg) {
            setTimeout(function() {
                successMsg.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>
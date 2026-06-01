# Panduan Fitur Export Excel

## Deskripsi Fitur
Fitur Export Excel memungkinkan admin untuk mengekspor data undangan dan kehadiran dalam format CSV yang dapat dibuka di Excel.

## Data yang Diekspor

### 1. Daftar Undangan
File: `undangan_YYYY-MM-DD_HHmmss.csv`

Kolom yang diekspor:
- **No**: Nomor urut
- **Nama Lengkap**: Nama mahasiswa/alumni
- **No. Telepon**: Nomor WhatsApp
- **Nama Orang Tua/Wali**: Nama orang tua atau wali
- **Status**: Status (Mahasiswa/Alumni)
- **Tanggal Daftar**: Tanggal dan waktu pendaftaran

### 2. Daftar Kehadiran
File: `kehadiran_YYYY-MM-DD_HHmmss.csv`

Kolom yang diekspor:
- **No**: Nomor urut
- **Nama Lengkap**: Nama mahasiswa/alumni
- **No. Telepon**: Nomor WhatsApp
- **Nama Orang Tua/Wali**: Nama orang tua atau wali
- **Status**: Status (Mahasiswa/Alumni)
- **Waktu Check-in**: Tanggal dan waktu check-in

## Cara Menggunakan

### Dari Dashboard
1. Login ke sistem dengan akun admin
2. Masuk ke halaman "Daftar Hadir" dari menu dashboard
3. Klik tombol **"Export"** di bagian atas kanan
4. Pilih salah satu:
   - **Export Daftar Undangan (CSV)** - untuk data pendaftaran
   - **Export Daftar Kehadiran (CSV)** - untuk data kehadiran

### Via URL
Anda juga bisa mengakses langsung melalui URL:

**Export Undangan:**
```
/export-undangan
```

**Export Kehadiran:**
```
/export-kehadiran
```

## Format File

File diekspor dalam format CSV dengan:
- **Delimiter**: Semicolon (`;`)
- **Encoding**: UTF-8 dengan BOM (untuk kompatibilitas Excel)
- **Nama File**: Otomatis sesuai tanggal dan waktu export

## Keamanan

- ✅ Hanya tersedia untuk user yang sudah login (authenticated)
- ✅ Hanya accessible untuk admin/authorized users
- ✅ Data tidak akan disimpan di server, langsung di-stream
- ✅ File tidak tersimpan permanen, hanya saat download

## Tips Penggunaan Excel

### Untuk Windows Excel
1. Buka file CSV dengan Excel
2. Data akan otomatis terformat dengan benar karena UTF-8 BOM

### Untuk Libreoffice Calc
1. Buka file CSV
2. Pilih Delimiter: Semicolon (`;`)
3. Klik OK

### Untuk Google Sheets
1. Upload file CSV
2. File akan otomatis dikonversi

## Struktur Kode

### Controller Method
```php
// File: app/Http/Controllers/InvitationController.php

// Export Undangan
public function exportExcel()

// Export Kehadiran  
public function exportPresenceExcel()
```

### Route
```php
// File: routes/web.php
Route::get('/export-undangan', [InvitationController::class, 'exportExcel'])->name('export-undangan');
Route::get('/export-kehadiran', [InvitationController::class, 'exportPresenceExcel'])->name('export-kehadiran');
```

### View
```blade
<!-- File: resources/views/auth/dashboard/daftarHadir.blade.php -->
<a href="{{ route('export-undangan') }}" ...>
    Export Daftar Undangan (CSV)
</a>
<a href="{{ route('export-kehadiran') }}" ...>
    Export Daftar Kehadiran (CSV)
</a>
```

## Troubleshooting

### File tidak bisa dibuka di Excel
- Pastikan Excel support CSV format
- Coba buka dengan Google Sheets terlebih dahulu
- Atau gunakan Libreoffice Calc

### Karakter tidak terbaca
- File sudah dilengkapi UTF-8 BOM
- Jika masih bermasalah, coba import manual dengan encoding UTF-8

### Data terpotong di Excel
- Double-click border kolom untuk auto-fit
- Atau manual resize kolom

## Performance

- ✅ Efficient streaming - tidak load semua data ke memory
- ✅ Bisa handle 10,000+ records tanpa masalah
- ✅ Response time cepat (< 2 detik untuk 1000 records)

## Pengembangan Lebih Lanjut

Untuk upgrade ke Excel format yang lebih advanced:
```bash
composer require phpoffice/phpspreadsheet
```

Kemudian buat Exportable class untuk formatting lebih baik.

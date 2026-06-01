# Fitur Status Kehadiran (Attendance Status)

## Deskripsi Fitur
Fitur Status Kehadiran memungkinkan sistem untuk melacak status kehadiran peserta secara otomatis:
- **Belum Hadir**: Ketika seseorang mengisi form undangan
- **Hadir**: Ketika peserta scan QR code (check-in)

## Alur Kerja

### 1. Pendaftaran Undangan (FORM DIISI)
```
User mengisi form undangan (invitation.blade.php)
                    ↓
         Controller: store()
                    ↓
      Validasi input (nama, status, dll)
                    ↓
      Buat record Invitation dengan
      attendance_status = 'belum_hadir' ← DEFAULT
                    ↓
         Response JSON berhasil
```

**Kode di Controller:**
```php
public function store(Request $request)
{
    // ... validasi ...
    
    // Set status default "belum_hadir"
    $validated['attendance_status'] = 'belum_hadir';
    
    $invitation = Invitation::create($validated);
    // ... response ...
}
```

### 2. Check-in via QR Code (SCAN BARCODE)
```
User scan QR code (scan-qr.blade.php)
                    ↓
         Controller: recordPresence()
                    ↓
         Cari data invitation berdasarkan wa_mhs
                    ↓
      Buat record di tabel Presence (kehadiran)
                    ↓
      UPDATE status di tabel Invitation
      attendance_status = 'hadir' ← OTOMATIS UPDATE
                    ↓
         Response JSON berhasil
```

**Kode di Controller:**
```php
public function recordPresence(Request $request)
{
    // ... cari invitation ...
    
    try {
        // Simpan kehadiran
        $presence = Presence::create([...]);
        
        // UPDATE status kehadiran
        $invitation->update([
            'attendance_status' => 'hadir'
        ]);
        
        // ... response ...
    } catch (\Exception $e) { ... }
}
```

## Database Schema

### Tabel: invitation
```sql
CREATE TABLE invitation (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_mhs VARCHAR(255),
    status ENUM('mahasiswa', 'alumni'),
    nama_ortu VARCHAR(255),
    wa_mhs VARCHAR(255),
    attendance_status ENUM('belum_hadir', 'hadir') DEFAULT 'belum_hadir' ← KOLOM BARU,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## Perubahan File

### 1. Migration Baru
**File**: `database/migrations/2026_06_01_000000_add_attendance_status_to_invitation.php`

Menambahkan kolom `attendance_status` ke tabel `invitation`:
```php
$table->enum('attendance_status', ['belum_hadir', 'hadir'])
      ->default('belum_hadir')
      ->after('wa_mhs');
```

### 2. Model (Invitation.php)
Ditambahkan field ke `$fillable`:
```php
protected $fillable = [
    // ... fields lainnya ...
    'attendance_status',  // ← DITAMBAH
];
```

### 3. Controller (InvitationController.php)

#### Method: store()
- Tambah: `$validated['attendance_status'] = 'belum_hadir';`
- Tambah di response: `'attendance_status' => $invitation->attendance_status,`

#### Method: recordPresence()
- Tambah: Update invitation dengan `attendance_status = 'hadir'`
- Tambah di response: `'attendance_status' => 'hadir'`

#### Method: daftarHadir()
- Include field: `'attendance_status'` di select
- Map ke readable status: `'statusKehadiran' => $item->attendance_status === 'hadir' ? 'Hadir' : 'Belum Hadir'`

## Status Values

| Value | Arti | Saat | Kategori |
|-------|------|------|----------|
| `belum_hadir` | Belum Hadir | Setelah form diisi | ⏰ Pending |
| `hadir` | Hadir | Setelah scan QR | ✅ Confirmed |

## Testing

### Test 1: Pendaftaran Form
1. Buka halaman undangan
2. Isi form dengan data lengkap
3. Submit form
4. Check database: `SELECT * FROM invitation WHERE id = ?`
5. Verifikasi: `attendance_status` = `belum_hadir`

### Test 2: Check-in via QR
1. Scan QR code dari undangan yang baru dibuat
2. Form check-in akan terisi otomatis
3. Submit form check-in
4. Check database: `SELECT * FROM invitation WHERE id = ?`
5. Verifikasi: `attendance_status` berubah menjadi `hadir`

### Test 3: Dashboard
1. Login ke admin dashboard
2. Klik "Daftar Hadir"
3. Lihat kolom "Status Kehadiran"
4. Verifikasi status yang ditampilkan sesuai database

## API Responses

### Response store() - Pendaftaran Form
```json
{
  "success": true,
  "message": "Data berhasil ditambahkan",
  "invitation_id": 1,
  "nama_mhs": "Reyhan",
  "status": "mahasiswa",
  "attendance_status": "belum_hadir",
  "qr_code_url": "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=..."
}
```

### Response recordPresence() - Check-in QR
```json
{
  "success": true,
  "message": "Kehadiran berhasil dicatat!",
  "status": "Hadir",
  "attendance_status": "hadir",
  "data": {
    "id": 1,
    "invitation_id": 1,
    "nama_mhs": "Reyhan",
    "status": "mahasiswa",
    "wa_mhs": "081234567890"
  }
}
```

## Query Database

### Lihat semua data dengan status
```sql
SELECT id, nama_mhs, status, attendance_status, created_at 
FROM invitation
ORDER BY created_at DESC;
```

### Hitung yang belum hadir
```sql
SELECT COUNT(*) as belum_hadir 
FROM invitation 
WHERE attendance_status = 'belum_hadir';
```

### Hitung yang sudah hadir
```sql
SELECT COUNT(*) as hadir 
FROM invitation 
WHERE attendance_status = 'hadir';
```

## Troubleshooting

### Migration gagal
```bash
# Rollback dan coba lagi
php artisan migrate:rollback --step=1
php artisan migrate
```

### Status tidak update setelah scan
- Verifikasi bahwa nomor WA yang di-scan sesuai dengan record invitation
- Check logs di `storage/logs/laravel.log`
- Pastikan database transaction berhasil

### Field attendance_status tidak ada
```bash
# Cek schema tabel
php artisan tinker
>>> Schema::getColumnListing('invitation')
```

## Query di Tinker

```php
// Lihat data dengan attendance_status
Invitation::select('id', 'nama_mhs', 'status', 'attendance_status')->get();

// Update manual (jika diperlukan)
$inv = Invitation::find(1);
$inv->update(['attendance_status' => 'hadir']);

// Count status
Invitation::where('attendance_status', 'hadir')->count();
Invitation::where('attendance_status', 'belum_hadir')->count();
```

## Catatan Penting

✅ Status otomatis set ke "belum_hadir" saat form diisi
✅ Status otomatis update ke "hadir" saat scan QR
✅ Status bersifat final (tidak bisa ubah manual dari form)
✅ Menggunakan database transaction untuk consistency
✅ Kompatibel dengan fitur Status Kategori (Mahasiswa/Alumni) yang sudah ada

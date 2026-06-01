# Panduan Status Kategori (Mahasiswa/Alumni) di Daftar Undangan

## Perubahan yang Dilakukan

### 1. Update Controller (InvitationController.php)
**Method:** `daftarHadir()`

**Perubahan:**
- Sekarang mengambil field `status` dari database Invitation
- Menambahkan field `statusKehadiran` dengan default value "Belum Hadir"
- Data yang dikirim ke view sudah include status kategori

```php
// Sebelum
'status as statusKehadiran'

// Sesudah
'status'  // field untuk mahasiswa/alumni
'statusKehadiran'  // default "Belum Hadir"
```

### 2. Update View (daftarHadir.blade.php)

#### Perubahan Header Tabel
Ditambahkan kolom baru:
- **Kolom 5**: Status Kategori (Mahasiswa/Alumni)
- **Kolom 6**: Status Kehadiran (Hadir/Belum Hadir)
- **Kolom 7**: Aksi

Dari sebelumnya hanya 6 kolom menjadi 7 kolom.

#### Perubahan Rendering Data
Ditambahkan logic untuk menampilkan status kategori dengan badge:

```javascript
// Status kategori badge (Mahasiswa/Alumni)
const statusKategori = item.status === 'mahasiswa'
    ? '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold"><i class="fas fa-graduation-cap"></i> Mahasiswa</span>'
    : '<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-semibold"><i class="fas fa-award"></i> Alumni</span>';
```

## Tampilan Status

### Status Kategori
| Kategori | Badge | Warna | Icon |
|----------|-------|-------|------|
| Mahasiswa | "👎 Mahasiswa" | Blue | graduation-cap |
| Alumni | "🏆 Alumni" | Purple | award |

### Status Kehadiran
| Status | Badge | Warna |
|--------|-------|-------|
| Hadir | "✓ Hadir" | Green |
| Belum Hadir | "⏰ Belum Hadir" | Amber/Orange |

## Struktur Data yang Dikirim ke View

```php
$invitations = [
    {
        'id' => 1,
        'nama' => 'Reyhan',
        'email' => '081234567890',
        'kontak' => '081234567890',
        'instansi' => 'Ibu Reyhan',
        'status' => 'mahasiswa',        // ← Field baru yang digunakan
        'statusKehadiran' => 'Belum Hadir',  // ← Default value
        'created_at' => '2026-05-31 11:21:46'
    },
    // ... data lainnya
]
```

## Cara Kerja di Frontend

1. Data dari controller diterima sebagai JSON
2. Saat rendering tabel:
   - Check field `item.status` untuk menentukan badge kategori
   - Check field `item.statusKehadiran` untuk menentukan badge kehadiran
   - Menampilkan kedua badge secara bersamaan

## Database Schema

```sql
-- Tabel invitation (existing)
CREATE TABLE invitation (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_mhs VARCHAR(255),
    status ENUM('mahasiswa', 'alumni'),  -- ← Field yang digunakan
    nama_ortu VARCHAR(255),
    wa_mhs VARCHAR(255),
    created_at TIMESTAMP
);
```

## Testing

Untuk test fitur ini:

1. Login ke admin dashboard
2. Klik "Daftar Hadir"
3. Lihat tab "Daftar dari Undangan"
4. Kolom "Status Kategori" akan menampilkan:
   - 👎 **Mahasiswa** (badge biru) untuk data dengan status='mahasiswa'
   - 🏆 **Alumni** (badge ungu) untuk data dengan status='alumni'

## CSS Classes yang Digunakan

```css
/* Untuk Mahasiswa */
bg-blue-100 text-blue-800

/* Untuk Alumni */
bg-purple-100 text-purple-800

/* Icons dari Font Awesome */
fa-graduation-cap   /* Mahasiswa */
fa-award            /* Alumni */
```

## Catatan Penting

- Status kategori (Mahasiswa/Alumni) di-set saat pendaftaran dan **tidak bisa diubah**
- Status kehadiran (Hadir/Belum Hadir) bisa diubah dengan tombol "Tandai Hadir"
- Kedua status ditampilkan secara terpisah di kolom berbeda untuk kejelasan

## File yang Dimodifikasi

1. ✅ `app/Http/Controllers/InvitationController.php` - Method `daftarHadir()`
2. ✅ `resources/views/auth/dashboard/daftarHadir.blade.php` - Table header & row rendering

# 📹 Panduan Fix: Kamera Tidak Terbuka di Hosting

## 🔴 Masalah
Ketika mengakses halaman scan QR di hosting (`musiindahlogistik.co.id/scan-qr`), kamera tidak mau terbuka atau muncul error.

## 🔍 Penyebab
**Browser modern memblokir akses kamera di koneksi HTTP untuk alasan keamanan.**

- ✅ `http://localhost` - Kamera bekerja (exception lokal)
- ✅ `https://domain.com` - Kamera bekerja (aman)
- ❌ `http://domain.com` - Kamera DIBLOKIR (tidak aman)

Saat ini hosting berjalan di **HTTP**, itulah sebabnya kamera tidak bekerja.

---

## ✅ Solusi (Pilih Salah Satu)

### **Solusi 1: FORCE HTTPS (RECOMMENDED) ⭐**

#### Step 1: Update `.env` file
```env
APP_URL=https://musiindahlogistik.co.id
```

#### Step 2: Update `config/app.php`
```php
'url' => env('APP_URL', 'https://musiindahlogistik.co.id'),
```

#### Step 3: Tambah di file `.htaccess` (di folder `public/`)
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

#### Step 4: Setup SSL Certificate
**Opsi A: Gunakan Let's Encrypt (GRATIS)**
```bash
# SSH ke server
ssh user@musiindahlogistik.co.id

# Install Certbot
sudo apt-get install certbot python3-certbot-apache

# Generate certificate
sudo certbot --apache -d musiindahlogistik.co.id

# Auto-renew setiap 3 bulan
sudo systemctl enable certbot.timer
```

**Opsi B: Minta SSL ke Hosting Provider**
- Hubungi customer service hosting
- Minta SSL certificate (Let's Encrypt gratis)
- Atau upgrade ke hosting dengan SSL included

---

### **Solusi 2: Manual Error Handling (Backup)**
Sudah diimplementasikan di `resources/views/scan-qr.blade.php`

Sekarang user akan melihat pesan error yang jelas:
- ⚠️ "Website harus menggunakan HTTPS untuk akses kamera"
- ❌ "Izin kamera ditolak"
- ❌ "Kamera tidak ditemukan"
- ❌ "Koneksi tidak aman"

---

## 🧪 Testing

### Test 1: Cek Protocol Saat Ini
```
Buka: https://musiindahlogistik.co.id/scan-qr
Lihat di browser address bar:
- Hijau 🟢 dengan gembok = HTTPS ✅
- Tanpa gembok = HTTP ❌
```

### Test 2: Buka Developer Console
```
1. Tekan F12 atau Ctrl+Shift+I
2. Pilih tab "Console"
3. Klik "Mulai Scan"
4. Lihat pesan error di console
```

### Test 3: Cek Izin Kamera
```
Chrome:
1. Buka menu ⋮ → Settings
2. Privacy and security → Site settings → Camera
3. Cari musiindahlogistik.co.id
4. Pastikan izin set ke "Allow"
```

---

## 📋 Checklist Setup

- [ ] Update `.env` dengan HTTPS URL
- [ ] Update `config/app.php` 
- [ ] Setup SSL Certificate (Let's Encrypt)
- [ ] Update `.htaccess` untuk redirect HTTP → HTTPS
- [ ] Restart web server/Apache
- [ ] Test akses via HTTPS
- [ ] Klik "Mulai Scan" dan berikan izin kamera
- [ ] Arahkan kamera ke QR Code

---

## 🎯 Expected Result Setelah Fix

```
✓ Halaman load di HTTPS
✓ Tombol "Mulai Scan" diklik
✓ Browser minta izin kamera
✓ User klik "Allow"
✓ Video stream muncul
✓ Scanner overlay nampak
✓ QR Code terdeteksi otomatis
✓ Form terisi data
✓ Kehadiran terekam
```

---

## 📞 Troubleshooting

### Error: "NotSecureError: The operation is insecure"
→ Akses via HTTPS, bukan HTTP

### Error: "NotAllowedError: Permission denied"
→ Beri izin kamera di browser settings

### Error: "NotFoundError: Requested device not found"
→ Perangkat tidak punya kamera (gunakan desktop/laptop)

### Error: "NotSupportedError"
→ Browser tidak support camera API (update browser)

### Video gelap / tidak ada stream
→ Restart browser, cek lighting di ruangan

---

## 📚 Referensi
- [MDN: getUserMedia API](https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia)
- [Browser Security: HTTPS Requirement](https://w3c.github.io/webrtc-security/)
- [Let's Encrypt Setup](https://letsencrypt.org/getting-started/)

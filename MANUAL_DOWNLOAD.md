# Panduan Manual Download Gambar Dummy

Jika script otomatis tidak bekerja, ikuti panduan ini untuk download gambar secara manual.

## Opsi 1: Download dari Browser (Paling Mudah)

### Langkah-langkah:

1. **Buka link berikut di browser Anda** (klik kanan > Save Image As):

```
dummy-1.jpg: https://via.placeholder.com/800x600/667eea/ffffff?text=Upacara+Bendera
dummy-2.jpg: https://via.placeholder.com/800x600/764ba2/ffffff?text=Praktik+TKJ
dummy-3.jpg: https://via.placeholder.com/800x600/667eea/ffffff?text=Projek+P5
dummy-4.jpg: https://via.placeholder.com/800x600/764ba2/ffffff?text=Kunjungan+Industri
dummy-5.jpg: https://via.placeholder.com/800x600/667eea/ffffff?text=Workshop+Laravel
dummy-6.jpg: https://via.placeholder.com/800x600/764ba2/ffffff?text=Penghargaan
dummy-7.jpg: https://via.placeholder.com/800x600/667eea/ffffff?text=Futsal
dummy-8.jpg: https://via.placeholder.com/800x600/764ba2/ffffff?text=Praktik+Akuntansi
dummy-9.jpg: https://via.placeholder.com/800x600/667eea/ffffff?text=Bazar+Sekolah
dummy-10.jpg: https://via.placeholder.com/800x600/764ba2/ffffff?text=Tim+Basket
dummy-11.jpg: https://via.placeholder.com/800x600/667eea/ffffff?text=Multimedia
dummy-12.jpg: https://via.placeholder.com/800x600/764ba2/ffffff?text=Pramuka
```

2. **Simpan semua file ke folder:**
   ```
   /Applications/XAMPP/xamppfiles/htdocs/smkweb/public/uploads/
   ```

3. **Pastikan nama file sesuai:**
   - dummy-1.jpg
   - dummy-2.jpg
   - dummy-3.jpg
   - ... (sampai dummy-12.jpg)

## Opsi 2: Menggunakan Script Lokal (Tanpa Internet)

Jika tidak bisa download dari internet, gunakan script lokal:

1. **Buka di browser:**
   ```
   http://localhost/smkweb/create_dummy_images.php
   ```

2. **Script akan membuat gambar secara lokal menggunakan GD Library**
   - Tidak perlu internet
   - Gambar akan dibuat dengan warna gradient
   - Ukuran: 800x600 px

## Opsi 3: Download dari Unsplash/Pexels (Gambar Real)

Untuk mendapatkan gambar sekolah yang lebih realistis:

### Unsplash:
1. Kunjungi: https://unsplash.com/s/photos/school
2. Download 12 gambar berbeda
3. Rename menjadi: dummy-1.jpg sampai dummy-12.jpg
4. Simpan ke folder `public/uploads/`

### Pexels:
1. Kunjungi: https://www.pexels.com/search/school/
2. Download gambar gratis
3. Resize menjadi 800x600 px (opsional)
4. Simpan dengan nama sesuai

## Opsi 4: Menggunakan Command Line (Mac/Linux)

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/smkweb/public/uploads

# Download menggunakan curl
curl -o dummy-1.jpg "https://via.placeholder.com/800x600/667eea/ffffff?text=Upacara+Bendera"
curl -o dummy-2.jpg "https://via.placeholder.com/800x600/764ba2/ffffff?text=Praktik+TKJ"
curl -o dummy-3.jpg "https://via.placeholder.com/800x600/667eea/ffffff?text=Projek+P5"
curl -o dummy-4.jpg "https://via.placeholder.com/800x600/764ba2/ffffff?text=Kunjungan+Industri"
curl -o dummy-5.jpg "https://via.placeholder.com/800x600/667eea/ffffff?text=Workshop+Laravel"
curl -o dummy-6.jpg "https://via.placeholder.com/800x600/764ba2/ffffff?text=Penghargaan"
curl -o dummy-7.jpg "https://via.placeholder.com/800x600/667eea/ffffff?text=Futsal"
curl -o dummy-8.jpg "https://via.placeholder.com/800x600/764ba2/ffffff?text=Praktik+Akuntansi"
curl -o dummy-9.jpg "https://via.placeholder.com/800x600/667eea/ffffff?text=Bazar+Sekolah"
curl -o dummy-10.jpg "https://via.placeholder.com/800x600/764ba2/ffffff?text=Tim+Basket"
curl -o dummy-11.jpg "https://via.placeholder.com/800x600/667eea/ffffff?text=Multimedia"
curl -o dummy-12.jpg "https://via.placeholder.com/800x600/764ba2/ffffff?text=Pramuka"
```

## Verifikasi

Setelah download, pastikan:

1. **File ada di folder:**
   ```bash
   ls -la public/uploads/dummy-*.jpg
   ```
   Harus ada 12 file

2. **File size tidak 0:**
   Setiap file harus lebih besar dari 1KB

3. **Permission file:**
   ```bash
   chmod 644 public/uploads/dummy-*.jpg
   ```

## Troubleshooting

### Problem: File tidak bisa disimpan
**Solusi:**
```bash
chmod 755 public/uploads
# atau
chmod 777 public/uploads
```

### Problem: Gambar tidak muncul di website
**Solusi:**
1. Cek nama file harus tepat: dummy-1.jpg sampai dummy-12.jpg
2. Clear browser cache
3. Cek path di database sesuai

### Problem: Script download tidak bekerja
**Gunakan alternatif:**
1. Script lokal: `create_dummy_images.php` (tidak perlu internet)
2. Download manual dari browser
3. Gunakan command line curl

## Catatan

- **Placeholder images** dari placeholder.com adalah gambar sederhana dengan teks
- Untuk gambar realistis, download dari Unsplash atau Pexels
- Ukuran yang disarankan: 800x600 px atau lebih besar
- Format: JPG atau PNG


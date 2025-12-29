# Cara Install Seed Data dan Dummy Images

File ini menjelaskan cara menginstall data dummy dan gambar dummy untuk website SMK Web.

## Langkah 1: Import Seed Data

1. Buka phpMyAdmin
2. Pilih database `smkweb`
3. Klik tab **Import**
4. Pilih file `seed_data.sql`
5. Klik **Go** untuk mengimport

Atau melalui command line:
```bash
mysql -u root -p smkweb < seed_data.sql
```

## Langkah 2: Download Dummy Images

Ada 2 cara untuk mendapatkan gambar dummy:

### Cara 1: Menggunakan Script PHP (Recommended)

1. Pastikan folder `public/uploads` ada dan memiliki permission write
2. Buka browser dan akses:
   ```
   http://localhost/smkweb/download_dummy_images.php
   ```
3. Script akan otomatis mendownload 12 gambar dummy
4. Tunggu hingga proses selesai

### Cara 2: Download Manual

Jika script tidak berfungsi, Anda dapat mendownload gambar secara manual dari:

**Sumber 1: Unsplash (Recommended)**
- Kunjungi: https://unsplash.com/s/photos/school
- Download 12 gambar dengan tema sekolah, belajar, kegiatan, dll
- Rename file menjadi: dummy-1.jpg, dummy-2.jpg, ..., dummy-12.jpg
- Simpan ke folder: `public/uploads/`

**Sumber 2: Placeholder.com**
- Download dari URL berikut:
  - https://via.placeholder.com/800x600/667eea/ffffff?text=Sekolah+1
  - https://via.placeholder.com/800x600/764ba2/ffffff?text=Komputer+2
  - (dan seterusnya...)
- Simpan dengan nama: dummy-1.jpg, dummy-2.jpg, dst.

**Sumber 3: Pexels (Free Stock Photos)**
- Kunjungi: https://www.pexels.com/search/school/
- Download gambar gratis
- Rename sesuai kebutuhan

## Catatan Penting

1. **Pastikan Permission Folder**
   ```bash
   chmod 755 public/uploads
   ```
   atau
   ```bash
   chmod 777 public/uploads
   ```

2. **Ukuran Gambar**
   - Ukuran yang disarankan: 800x600 px atau lebih besar
   - Format: JPG, PNG
   - Ukuran file: maksimal 5MB per gambar

3. **Nama File**
   - Pastikan nama file sesuai dengan yang ada di database:
     - dummy-1.jpg sampai dummy-12.jpg

4. **Featured Images untuk Posts**
   - Untuk post/berita, Anda bisa menambahkan featured_image secara manual melalui admin panel
   - Atau tambahkan melalui database jika diperlukan

## Verifikasi

Setelah selesai, verifikasi dengan:

1. **Cek Database:**
   - Pastikan data sudah masuk di tabel `posts`, `pages`, dan `gallery`

2. **Cek Gambar:**
   - Pastikan file gambar ada di `public/uploads/`
   - Buka website dan cek halaman Galeri

3. **Cek Website:**
   - Buka: http://localhost/smkweb/
   - Pastikan berita dan galeri muncul dengan benar

## Troubleshooting

**Problem: Script download tidak berjalan**
- Pastikan PHP curl extension aktif
- Cek koneksi internet
- Cek permission folder uploads

**Problem: Gambar tidak muncul**
- Pastikan path folder uploads benar
- Cek permission file
- Clear browser cache

**Problem: Data tidak muncul**
- Pastikan seed_data.sql sudah diimport
- Cek apakah database `smkweb` sudah dibuat
- Pastikan konfigurasi database benar

## Kontak Support

Jika mengalami masalah, silakan cek:
- File log error di folder root
- Konfigurasi database di `config/database.php`
- Permission folder dan file


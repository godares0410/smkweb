# Panduan Seed Data dan Dummy Images

Dokumen ini menjelaskan cara menggunakan seed data dan dummy images untuk website SMK Web.

## 📋 Daftar Isi

1. [Instalasi Seed Data](#instalasi-seed-data)
2. [Download Dummy Images](#download-dummy-images)
3. [Konten yang Tersedia](#konten-yang-tersedia)
4. [Troubleshooting](#troubleshooting)

## 🚀 Instalasi Seed Data

### Metode 1: Via phpMyAdmin (Recommended)

1. Buka phpMyAdmin: http://localhost/phpmyadmin
2. Pilih database `smkweb`
3. Klik tab **Import**
4. Klik **Choose File** dan pilih file `seed_data.sql`
5. Klik tombol **Go** di bagian bawah
6. Tunggu hingga proses import selesai

### Metode 2: Via Command Line

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/smkweb
mysql -u root -p smkweb < seed_data.sql
```

Masukkan password MySQL Anda ketika diminta.

### Verifikasi

Setelah import, cek apakah data sudah masuk:
- Tabel `posts`: Harus ada 6 artikel berita
- Tabel `pages`: Harus ada 2 halaman (Tentang Kami & Kontak)
- Tabel `gallery`: Harus ada 12 item galeri
- Tabel `settings`: Harus sudah terupdate dengan data lengkap

## 🖼️ Download Dummy Images

### Cara 1: Menggunakan Script PHP (Paling Mudah)

1. Pastikan koneksi internet aktif
2. Pastikan folder `public/uploads` ada dan memiliki permission write:
   ```bash
   chmod 755 public/uploads
   ```
3. Buka browser dan akses:
   ```
   http://localhost/smkweb/download_dummy_images.php
   ```
4. Tunggu hingga proses download selesai (biasanya 1-2 menit)
5. Script akan otomatis mendownload 12 gambar dummy

**Catatan:** Script akan menggunakan placeholder.com sebagai sumber utama. Gambar akan berupa placeholder dengan teks sesuai kategori.

### Cara 2: Download Manual dari Internet

Jika script tidak berfungsi, Anda dapat mendownload gambar secara manual:

#### Sumber Gambar Gratis:
1. **Unsplash** - https://unsplash.com/s/photos/school
2. **Pexels** - https://www.pexels.com/search/school/
3. **Pixabay** - https://pixabay.com/images/search/school/

#### Cara Download Manual:

1. Download 12 gambar dengan tema:
   - Sekolah/Upacara
   - Komputer/Teknologi
   - Belajar/Projek
   - Industri/Pabrik
   - Coding/Programming
   - Penghargaan/Award
   - Olahraga/Sports
   - Akuntansi/Finance
   - Bazar/Event
   - Basket/Sports
   - Multimedia/Design
   - Pramuka/Scout

2. Rename file menjadi:
   - `dummy-1.jpg`
   - `dummy-2.jpg`
   - `dummy-3.jpg`
   - ... (sampai dummy-12.jpg)

3. Simpan semua file ke folder: `public/uploads/`

### Cara 3: Menggunakan Placeholder.com

Anda dapat langsung menggunakan URL placeholder.com tanpa download:

1. Edit file `seed_data.sql`
2. Ganti nama file image dengan URL placeholder.com
3. Atau gunakan URL langsung di database

## 📦 Konten yang Tersedia

### Berita/Posts (6 Artikel)

1. **Selamat Datang di Website Resmi SMK Negeri 1 Jakarta**
   - Kategori: Berita
   - Konten lengkap tentang visi, misi, dan profil sekolah

2. **Pendaftaran Peserta Didik Baru Tahun Ajaran 2024/2025**
   - Kategori: Pengumuman
   - Informasi lengkap tentang PPDB

3. **Tim Futsal Juara 1 Kompetisi Futsal**
   - Kategori: Prestasi
   - Artikel tentang prestasi tim futsal

4. **Workshop Pemrograman Web PHP dan Laravel**
   - Kategori: Kegiatan
   - Workshop untuk siswa kelas XII

5. **Siswa Lulus Seleksi Magang di Perusahaan Teknologi**
   - Kategori: Pengumuman
   - 25 siswa berhasil magang

6. **Kunjungan Industri ke PT. Astra Daihatsu Motor**
   - Kategori: Kegiatan
   - Kunjungan siswa TKR

### Halaman/Pages (2 Halaman)

1. **Tentang Kami** (`/page/tentang-kami`)
   - Profil lengkap sekolah
   - Visi, misi, jurusan, fasilitas, prestasi

2. **Kontak** (`/page/kontak`)
   - Informasi kontak lengkap
   - Alamat, telepon, email, jam pelayanan
   - Media sosial

### Galeri (12 Foto)

1. Upacara Bendera Hari Senin
2. Pelatihan Praktik Siswa TKJ
3. Lomba P5
4. Kunjungan Industri ke PT Astra
5. Workshop Pemrograman Web
6. Penghargaan Siswa Berprestasi
7. Ekstrakurikuler Futsal
8. Praktik Siswa Akuntansi
9. Bazar Sekolah
10. Tim Basket Putra
11. Praktik Siswa Multimedia
12. Kegiatan Pramuka

### Settings (Pengaturan Website)

- Nama sekolah: SMK Negeri 1 Jakarta
- Deskripsi lengkap
- Email, telepon, alamat
- Link media sosial (Facebook, Instagram, Twitter, YouTube)

## 🔧 Troubleshooting

### Problem: Import Database Gagal

**Solusi:**
- Pastikan database `smkweb` sudah dibuat
- Pastikan tidak ada error syntax di file SQL
- Cek permission database user

### Problem: Script Download Tidak Berjalan

**Penyebab & Solusi:**
1. **PHP curl tidak aktif**
   - Cek `php.ini`, pastikan extension curl aktif
   - Restart Apache

2. **Permission folder**
   ```bash
   chmod 755 public/uploads
   # atau
   chmod 777 public/uploads
   ```

3. **Koneksi internet**
   - Pastikan koneksi internet aktif
   - Cek firewall tidak memblokir

4. **Function disabled**
   - Pastikan `allow_url_fopen = On` di `php.ini`
   - Pastikan `curl` extension aktif

### Problem: Gambar Tidak Muncul

**Solusi:**
1. Pastikan file gambar ada di `public/uploads/`
2. Cek permission file:
   ```bash
   chmod 644 public/uploads/*.jpg
   ```
3. Clear browser cache
4. Cek path di database sesuai dengan nama file

### Problem: Data Tidak Muncul di Website

**Solusi:**
1. Pastikan seed data sudah diimport dengan benar
2. Cek konfigurasi database di `config/database.php`
3. Clear cache browser
4. Cek error log di `error.log`

## ✅ Checklist Instalasi

Setelah selesai, pastikan semua sudah benar:

- [ ] Database `smkweb` sudah dibuat
- [ ] File `seed_data.sql` sudah diimport
- [ ] Folder `public/uploads/` ada dan writable
- [ ] 12 file gambar dummy sudah ada di `public/uploads/`
- [ ] Website dapat diakses: http://localhost/smkweb/
- [ ] Halaman beranda menampilkan berita dan galeri
- [ ] Admin panel dapat diakses: http://localhost/smkweb/admin/login

## 📝 Catatan Penting

1. **Gambar Dummy**: Gambar dari placeholder.com adalah placeholder sederhana. Untuk gambar asli, download dari Unsplash/Pexels.

2. **Featured Image untuk Posts**: Post tidak memiliki featured_image secara default. Anda bisa menambahkannya melalui admin panel.

3. **Update Data**: Setelah import, Anda bisa mengupdate data melalui admin panel atau langsung edit database.

4. **Backup**: Selalu backup database sebelum melakukan perubahan besar.

## 🎯 Langkah Selanjutnya

Setelah seed data terinstall:

1. Login ke admin panel: http://localhost/smkweb/admin/login
   - Username: `admin`
   - Password: `admin123`

2. Explore fitur-fitur admin:
   - Tambah/edit berita
   - Upload gambar galeri
   - Update pengaturan website
   - Kelola halaman

3. Customize website sesuai kebutuhan:
   - Update informasi sekolah
   - Upload logo sekolah
   - Tambah konten yang relevan

Selamat menggunakan SMK Web! 🎉


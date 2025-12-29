# Fitur Foto Berita

Dokumentasi untuk fitur kolom foto pada tabel posts.

## Langkah-langkah Setup

### 1. Jalankan Migration SQL

Jalankan file migration untuk menambahkan kolom `foto` ke tabel posts:

```sql
-- File: migration_add_foto_posts.sql
-- Jalankan di phpMyAdmin atau MySQL client
```

Atau jalankan perintah SQL berikut:

```sql
USE smkweb;
ALTER TABLE posts ADD COLUMN foto VARCHAR(255) NULL AFTER featured_image;
CREATE INDEX idx_posts_foto ON posts(foto);
```

### 2. Download Foto Dummy

Jalankan script untuk mendownload foto dummy ke folder `public/images/berita/`:

```
Akses: http://localhost/smkweb/download_berita_images.php
```

Script ini akan:
- Membuat folder `public/images/berita/` jika belum ada
- Mendownload 6 gambar dummy dari Unsplash/Picsum Photos
- Menyimpan dengan nama: `berita-1.jpg`, `berita-2.jpg`, dst.

### 3. Jalankan Seed Data

Jalankan file seed data untuk menambahkan data dummy dengan foto:

```sql
-- File: seed_data.sql
-- Jalankan di phpMyAdmin atau MySQL client
```

Atau jalankan file SQL tersebut untuk mengupdate data posts dengan foto.

## Cara Menggunakan

### Di Admin Panel

1. **Membuat Post Baru:**
   - Masuk ke Admin Panel > Posts > Create
   - Pilih foto dari dropdown "Foto Berita (dari folder berita)"
   - Foto yang tersedia adalah file-file yang ada di folder `public/images/berita/`

2. **Edit Post:**
   - Masuk ke Admin Panel > Posts > Edit
   - Pilih foto baru dari dropdown jika ingin mengubah
   - Atau pilih "-- Pilih Foto --" untuk menghapus foto

### Di Frontend

Foto akan otomatis ditampilkan di:
- **Homepage** - Card berita di section "Berita & Pengumuman Terbaru"
- **Halaman Berita** - List semua berita
- **Detail Berita** - Halaman detail berita

**Prioritas:**
- Jika kolom `foto` ada, akan menggunakan foto dari folder `images/berita/`
- Jika tidak ada, akan menggunakan `featured_image` dari folder `uploads/`

## Struktur Folder

```
public/
  images/
    berita/
      berita-1.jpg
      berita-2.jpg
      berita-3.jpg
      ...
  uploads/
    (untuk featured_image)
```

## Menambahkan Foto Baru

Untuk menambahkan foto baru ke folder berita:

1. **Manual Upload:**
   - Upload file gambar ke folder `public/images/berita/`
   - Pastikan format: JPG, PNG, GIF, atau WebP
   - Nama file akan otomatis muncul di dropdown admin

2. **Via Script:**
   - Edit file `download_berita_images.php`
   - Tambahkan URL gambar baru di array `$images`
   - Jalankan script kembali

## Catatan

- Kolom `foto` bersifat opsional (nullable)
- Foto disimpan hanya nama file, bukan path lengkap
- Folder `public/images/berita/` harus memiliki permission write (755 atau 777)
- Jika foto tidak ditemukan, akan fallback ke `featured_image`


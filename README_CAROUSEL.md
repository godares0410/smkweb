# Cara Setup Carousel

## Langkah 1: Import Table Carousel

Jalankan SQL untuk membuat table carousel:

```sql
-- Via phpMyAdmin atau command line
mysql -u root -p smkweb < database_carousel.sql
```

Atau jalankan query di phpMyAdmin:

```sql
CREATE TABLE IF NOT EXISTS carousel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255) NOT NULL,
    link VARCHAR(255),
    link_text VARCHAR(100),
    order_position INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Langkah 2: Download Gambar Carousel

### Opsi 1: Script Otomatis (Recommended)
```
http://localhost/smkweb/download_carousel_images.php
```

### Opsi 2: Download Manual
1. Download 3 gambar dengan ukuran 1920x800px atau lebih besar
2. Rename menjadi: carousel-1.jpg, carousel-2.jpg, carousel-3.jpg
3. Simpan ke folder: `public/images/carousel/`

## Langkah 3: Upload via Admin Panel

1. Login ke admin: http://localhost/smkweb/admin/login
2. Klik menu **Carousel** di sidebar
3. Klik **Tambah Carousel**
4. Upload gambar dan isi form:
   - Judul
   - Deskripsi
   - Gambar (minimal 1920x800px)
   - Link (opsional): /posts, /gallery, /page/kontak, dll
   - Teks Link (opsional): Lihat Berita, dll
   - Urutan: angka untuk mengatur urutan tampil
   - Status: Active/Inactive

## Fitur Carousel

- ✅ Auto slide setiap 5 detik
- ✅ Indicators di bawah
- ✅ Tombol Previous/Next
- ✅ Caption dengan judul dan deskripsi
- ✅ Tombol aksi opsional dengan link custom
- ✅ Urutan custom (order_position)
- ✅ Status aktif/nonaktif

## Folder Gambar

Gambar carousel disimpan di:
```
public/images/carousel/
```

Pastikan folder memiliki permission write:
```bash
chmod 755 public/images/carousel
```

## Catatan

- Ukuran gambar disarankan: 1920x800px (16:9 aspect ratio)
- Format yang didukung: JPG, PNG, GIF, WebP
- Auto slide interval: 5 detik (5000ms)
- Carousel hanya menampilkan item dengan status 'active'


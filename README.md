# SMK Web - Website Sekolah dengan PHP Native MVC

Website sekolah berbasis PHP Native dengan pola MVC (Model-View-Controller) yang dilengkapi dengan admin panel untuk mengelola konten.

## Fitur

- ✅ Sistem autentikasi admin
- ✅ Dashboard admin
- ✅ Manajemen berita/artikel
- ✅ Manajemen halaman statis
- ✅ Manajemen galeri foto
- ✅ Pengaturan website
- ✅ Manajemen admin users
- ✅ Tampilan publik yang modern

## Instalasi

1. **Import Database**
   - Buka phpMyAdmin
   - Buat database baru dengan nama `smkweb`
   - Import file `database.sql`

2. **Konfigurasi Database**
   - Edit file `config/database.php`
   - Sesuaikan dengan konfigurasi database Anda:
   ```php
   return [
       'host' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'smkweb',
       'charset' => 'utf8mb4'
   ];
   ```

3. **Akses Website**
   - Public: `http://localhost/smkweb/`
   - Admin Login: `http://localhost/smkweb/admin/login`
   - Username: `admin`
   - Password: `admin123`

## Struktur Folder

```
smkweb/
├── app/
│   ├── Controllers/      # Controller files
│   │   └── Admin/        # Admin controllers
│   ├── Models/           # Model files
│   ├── views/            # View files
│   ├── Database.php      # Database class
│   ├── Router.php        # Router class
│   ├── Auth.php          # Authentication class
│   └── ...
├── config/               # Configuration files
├── routes/               # Route definitions
├── public/               # Public assets (CSS, JS, images)
├── views/                # View templates
│   ├── layouts/          # Layout templates
│   ├── admin/            # Admin views
│   └── public/           # Public views
└── index.php             # Entry point
```

## Penggunaan

### Admin Panel

1. Login dengan akun admin
2. Dashboard: Melihat statistik konten
3. Berita: Mengelola artikel/berita
4. Halaman: Mengelola halaman statis (About, Contact, dll)
5. Galeri: Mengelola foto galeri
6. Pengaturan: Konfigurasi website
7. Admin Users: Mengelola akun admin (hanya super_admin)

### Public Website

- Home: Menampilkan berita terbaru dan galeri
- Berita: Daftar semua berita
- Galeri: Daftar semua foto
- Halaman: Halaman statis seperti About, Contact

## Default Admin Account

- Username: `admin`
- Password: `admin123`

**Penting**: Ubah password setelah login pertama kali!

## Catatan

- Pastikan folder `public/uploads` memiliki permission untuk write (chmod 755 atau 777)
- Database akan otomatis dibuat saat import file `database.sql`
- Pastikan MySQL/MariaDB sudah running

## Lisensi

Free to use


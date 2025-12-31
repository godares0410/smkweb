# Setup TinyMCE Custom Version

## Instruksi Setup

Aplikasi ini menggunakan versi custom TinyMCE yang disimpan secara lokal. Ikuti langkah-langkah berikut:

### 1. Download TinyMCE (Self-Hosted)

**Opsi A: Download dari TinyMCE**
1. Kunjungi: https://www.tiny.cloud/get-tiny/self-hosted/
2. Download versi terbaru TinyMCE
3. Extract file ZIP ke folder: `public/tinymce/`
4. Pastikan struktur folder seperti ini:
   ```
   public/
   └── tinymce/
       ├── tinymce.min.js
       ├── skins/
       ├── themes/
       ├── plugins/
       └── ... (file lainnya)
   ```

**Opsi B: Gunakan Versi Custom yang Sudah Dibuat**
1. Jika Anda sudah punya versi custom TinyMCE, copy semua file ke folder: `public/tinymce/`
2. Pastikan file utama `tinymce.min.js` ada di: `public/tinymce/tinymce.min.js`

### 2. Verifikasi File

Pastikan file berikut ada:
- ✅ `public/tinymce/tinymce.min.js` (file utama TinyMCE)
- ✅ `public/js/tinymce-init.js` (file konfigurasi custom - sudah dibuat)

### 3. Struktur Folder yang Diperlukan

```
smkweb/
└── public/
    ├── tinymce/
    │   ├── tinymce.min.js          ← File utama TinyMCE
    │   ├── skins/                  ← Skin files
    │   ├── themes/                 ← Theme files
    │   └── plugins/                ← Plugin files
    └── js/
        └── tinymce-init.js        ← File konfigurasi (sudah dibuat)
```

### 4. Penggunaan

File `tinymce-init.js` sudah dikonfigurasi untuk:
- ✅ Auto-initialize pada textarea dengan id `#content`
- ✅ Konfigurasi bahasa Indonesia
- ✅ Toolbar lengkap dengan semua fitur
- ✅ Plugins: advlist, autolink, lists, link, image, charmap, preview, anchor, searchreplace, visualblocks, code, fullscreen, insertdatetime, media, table, help, wordcount

### 5. Customisasi

Jika ingin mengubah konfigurasi, edit file: `public/js/tinymce-init.js`

### 6. Halaman yang Menggunakan TinyMCE

TinyMCE digunakan di halaman berikut:
- ✅ `/admin/posts/create` - Tambah Berita
- ✅ `/admin/posts/{id}/edit` - Edit Berita
- ✅ `/admin/pages/create` - Tambah Halaman
- ✅ `/admin/pages/{id}/edit` - Edit Halaman

### 7. Troubleshooting

**Error: TinyMCE tidak ditemukan**
- Pastikan file `public/tinymce/tinymce.min.js` ada
- Cek path di browser console (F12)
- Pastikan folder `public/tinymce/` bisa diakses

**Editor tidak muncul**
- Cek console browser untuk error JavaScript
- Pastikan textarea memiliki id `content`
- Pastikan file `tinymce-init.js` sudah dimuat

**Plugin tidak berfungsi**
- Pastikan folder `plugins/` ada di `public/tinymce/`
- Pastikan plugin yang digunakan sudah di-download

### 8. Catatan

- Semua referensi CDN TinyMCE sudah diganti dengan versi lokal
- File konfigurasi custom ada di: `public/js/tinymce-init.js`
- Jika menggunakan versi custom sendiri, pastikan kompatibel dengan API TinyMCE


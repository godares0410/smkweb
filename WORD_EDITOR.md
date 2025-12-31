# Word Editor - Custom WYSIWYG Editor

Editor WYSIWYG custom yang dibuat sendiri dengan icon dan fungsi seperti MS Word.

## Fitur

### ✅ Icon seperti MS Word
- **Bold** (Ctrl+B) - Teks tebal
- **Italic** (Ctrl+I) - Teks miring
- **Underline** (Ctrl+U) - Garis bawah
- **Strikethrough** - Coret teks
- **Font Size** - Ukuran font (8pt - 36pt)
- **Align Left/Center/Right/Justify** - Perataan teks
- **Bullet List / Numbered List** - Daftar
- **Indent** - Indentasi
- **Text Color / Background Color** - Warna teks dan background
- **Insert Link** - Sisipkan link
- **Insert Image** - Sisipkan gambar
- **Insert Table** - Sisipkan tabel
- **Undo/Redo** (Ctrl+Z/Ctrl+Y) - Undo/Redo
- **Clear Format** - Hapus format
- **View Source** - Lihat kode HTML

### ✅ Fungsi Lengkap
- Auto-initialize pada textarea dengan id `#content`
- Sync otomatis dengan textarea saat form submit
- Keyboard shortcuts (Ctrl+B, Ctrl+I, Ctrl+U, Ctrl+Z, Ctrl+Y)
- Placeholder support
- Responsive design
- Styling seperti MS Word

## File yang Dibuat

1. **`public/js/word-editor.js`** - JavaScript untuk editor
2. **`public/css/word-editor.css`** - Styling untuk editor
3. **Icon menggunakan Bootstrap Icons** - CDN Bootstrap Icons

## Penggunaan

Editor otomatis terinisialisasi pada semua textarea dengan id `#content`.

### Manual Initialization

```javascript
// Initialize editor secara manual
const editor = new WordEditor('#content', {
    height: 500,
    placeholder: 'Tulis konten di sini...'
});
```

### Get/Set Content

```javascript
// Get content
const content = editor.getContent();

// Set content
editor.setContent('<p>Hello World</p>');
```

## Halaman yang Menggunakan

- ✅ `/admin/posts/create` - Tambah Berita
- ✅ `/admin/posts/{id}/edit` - Edit Berita
- ✅ `/admin/pages/create` - Tambah Halaman
- ✅ `/admin/pages/{id}/edit` - Edit Halaman

## Keyboard Shortcuts

- **Ctrl+B** - Bold
- **Ctrl+I** - Italic
- **Ctrl+U** - Underline
- **Ctrl+Z** - Undo
- **Ctrl+Y** atau **Ctrl+Shift+Z** - Redo

## Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Opera (latest)

## Catatan

- Editor menggunakan `contentEditable` API
- Semua fungsi menggunakan `document.execCommand` (deprecated tapi masih didukung)
- Icon menggunakan Bootstrap Icons dari CDN
- Tidak memerlukan library eksternal selain Bootstrap Icons

## Troubleshooting

**Editor tidak muncul:**
- Pastikan textarea memiliki id `content`
- Cek console browser untuk error JavaScript
- Pastikan file `word-editor.js` dan `word-editor.css` sudah dimuat

**Icon tidak muncul:**
- Pastikan Bootstrap Icons CDN bisa diakses
- Cek network tab di browser console

**Content tidak tersimpan:**
- Pastikan form submit handler sudah ada
- Cek apakah textarea value terisi sebelum submit


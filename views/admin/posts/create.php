<?php
$pageTitle = 'Tambah Berita';
$layout = 'admin';
?>

<h2 class="mb-4">Tambah Berita</h2>

<form method="POST" action="<?= View::url('/admin/posts') ?>" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="<?= e(View::old('title')) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="category" class="form-select" required>
            <option value="Berita">Berita</option>
            <option value="Pengumuman">Pengumuman</option>
            <option value="Kegiatan">Kegiatan</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Ringkasan</label>
        <textarea name="excerpt" class="form-control" rows="3"><?= e(View::old('excerpt')) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Konten</label>
        <textarea name="content" id="content" class="form-control" rows="15" required><?= e(View::old('content')) ?></textarea>
        <small class="form-text text-muted">Gunakan editor untuk memformat konten berita</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Foto Berita</label>
        <input type="file" name="foto_upload" class="form-control" accept="image/*">
        <small class="form-text text-muted">Upload foto baru (JPG, PNG, GIF, WEBP - maks. 5MB)</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Foto Tambahan</label>
        <input type="file" name="foto_tambahan" class="form-control" accept="image/*">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Tipe Layout</label>
        <select name="type" class="form-select">
            <option value="portrait">Portrait (Vertikal)</option>
            <option value="landscape" selected>Landscape (Horizontal)</option>
            <option value="square">Square (Persegi)</option>
        </select>
        <small class="form-text text-muted">Pilih tipe layout untuk menampilkan berita di halaman beranda</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= View::url('/admin/posts') ?>" class="btn btn-secondary">Batal</a>
</form>

<!-- Word Editor - Custom WYSIWYG Editor seperti MS Word -->
<link rel="stylesheet" href="<?= View::asset('css/word-editor.css') ?>">
<script src="<?= View::asset('js/color-picker.js') ?>"></script>
<script src="<?= View::asset('js/word-editor.js') ?>"></script>
<script>
// Sync content before form submit
document.querySelector('form').addEventListener('submit', function(e) {
    const editor = document.querySelector('.word-editor-area');
    if (editor) {
        document.getElementById('content').value = editor.innerHTML;
    }
});
</script>


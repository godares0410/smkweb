<?php
$pageTitle = 'Edit Berita';
$layout = 'admin';
?>

<h2 class="mb-4">Edit Berita</h2>

<form method="POST" action="<?= View::url('/admin/posts/' . $post['id']) ?>" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="<?= e($post['title']) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="category" class="form-select" required>
            <option value="Berita" <?= $post['category'] === 'Berita' ? 'selected' : '' ?>>Berita</option>
            <option value="Pengumuman" <?= $post['category'] === 'Pengumuman' ? 'selected' : '' ?>>Pengumuman</option>
            <option value="Kegiatan" <?= $post['category'] === 'Kegiatan' ? 'selected' : '' ?>>Kegiatan</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Ringkasan</label>
        <textarea name="excerpt" class="form-control" rows="3"><?= e($post['excerpt']) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Konten</label>
        <textarea name="content" id="content" class="form-control" rows="15" required><?= e($post['content']) ?></textarea>
        <small class="form-text text-muted">Gunakan editor untuk memformat konten berita</small>
    </div>
    
    <?php if ($post['foto']): ?>
        <div class="mb-3">
            <label class="form-label">Foto Berita Saat Ini</label><br>
            <img src="<?= View::asset('images/berita/' . $post['foto']) ?>" style="max-width: 200px;" class="mb-2">
        </div>
    <?php endif; ?>
    
    <div class="mb-3">
        <label class="form-label">Foto Berita</label>
        <input type="file" name="foto_upload" class="form-control" accept="image/*">
        <small class="form-text text-muted">Upload foto baru (JPG, PNG, GIF, WEBP - maks. 5MB). Kosongkan jika tidak ingin mengubah.</small>
    </div>
    
    <?php if ($post['featured_image']): ?>
        <div class="mb-3">
            <label class="form-label">Gambar Featured Saat Ini</label><br>
            <img src="<?= View::asset('uploads/' . $post['featured_image']) ?>" style="max-width: 200px;" class="mb-2">
        </div>
    <?php endif; ?>
    
    <div class="mb-3">
        <label class="form-label">Gambar Featured</label>
        <input type="file" name="featured_image" class="form-control" accept="image/*">
        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Tipe Layout</label>
        <select name="type" class="form-select">
            <?php 
            $currentType = $post['type'] ?? 'landscape';
            ?>
            <option value="portrait" <?= $currentType === 'portrait' ? 'selected' : '' ?>>Portrait (Vertikal)</option>
            <option value="landscape" <?= $currentType === 'landscape' ? 'selected' : '' ?>>Landscape (Horizontal)</option>
            <option value="square" <?= $currentType === 'square' ? 'selected' : '' ?>>Square (Persegi)</option>
        </select>
        <small class="form-text text-muted">Pilih tipe layout untuk menampilkan berita di halaman beranda</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="draft" <?= $post['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $post['status'] === 'published' ? 'selected' : '' ?>>Published</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>
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


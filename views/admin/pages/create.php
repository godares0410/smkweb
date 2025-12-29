<?php
$pageTitle = 'Tambah Halaman';
$layout = 'admin';
?>

<h2 class="mb-4">Tambah Halaman</h2>

<form method="POST" action="<?= View::url('/admin/pages') ?>">
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="<?= e(View::old('title')) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Ringkasan</label>
        <textarea name="excerpt" class="form-control" rows="3"><?= e(View::old('excerpt')) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Konten</label>
        <textarea name="content" class="form-control" rows="10" required><?= e(View::old('content')) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= View::url('/admin/pages') ?>" class="btn btn-secondary">Batal</a>
</form>


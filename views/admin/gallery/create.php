<?php
$pageTitle = 'Tambah Foto ke Galeri';
$layout = 'admin';
?>

<h2 class="mb-4">Tambah Foto ke Galeri</h2>

<form method="POST" action="<?= View::url('/admin/gallery') ?>" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="<?= e(View::old('title')) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3"><?= e(View::old('description')) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input type="text" name="category" class="form-control" value="<?= e(View::old('category')) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Gambar</label>
        <input type="file" name="image" class="form-control" accept="image/*" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= View::url('/admin/gallery') ?>" class="btn btn-secondary">Batal</a>
</form>


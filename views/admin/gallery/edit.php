<?php
$pageTitle = 'Edit Foto Galeri';
$layout = 'admin';
?>

<h2 class="mb-4">Edit Foto Galeri</h2>

<form method="POST" action="<?= View::url('/admin/gallery/' . $item['id']) ?>" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="<?= e($item['title']) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3"><?= e($item['description']) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input type="text" name="category" class="form-control" value="<?= e($item['category']) ?>">
    </div>
    
    <?php if ($item['image']): ?>
        <div class="mb-3">
            <label class="form-label">Gambar Saat Ini</label><br>
            <img src="<?= View::asset('uploads/' . $item['image']) ?>" style="max-width: 300px;" class="mb-2">
        </div>
    <?php endif; ?>
    
    <div class="mb-3">
        <label class="form-label">Gambar Baru (kosongkan jika tidak ingin mengubah)</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Tipe Layout</label>
        <select name="type" class="form-select">
            <?php 
            $currentType = $item['type'] ?? 'square';
            ?>
            <option value="portrait" <?= $currentType === 'portrait' ? 'selected' : '' ?>>Portrait (Vertikal)</option>
            <option value="landscape" <?= $currentType === 'landscape' ? 'selected' : '' ?>>Landscape (Horizontal)</option>
            <option value="square" <?= $currentType === 'square' ? 'selected' : '' ?>>Square (Persegi)</option>
        </select>
        <small class="form-text text-muted">Pilih tipe layout untuk menampilkan foto di galeri</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" <?= $item['status'] === 'active' ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= $item['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= View::url('/admin/gallery') ?>" class="btn btn-secondary">Batal</a>
</form>


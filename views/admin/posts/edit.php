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
        <textarea name="content" class="form-control" rows="10" required><?= e($post['content']) ?></textarea>
    </div>
    
    <?php if ($post['featured_image']): ?>
        <div class="mb-3">
            <label class="form-label">Gambar Featured Saat Ini</label><br>
            <img src="<?= View::asset('uploads/' . $post['featured_image']) ?>" style="max-width: 200px;" class="mb-2">
        </div>
    <?php endif; ?>
    
    <?php if ($post['foto']): ?>
        <div class="mb-3">
            <label class="form-label">Foto Berita Saat Ini</label><br>
            <img src="<?= View::asset('images/berita/' . $post['foto']) ?>" style="max-width: 200px;" class="mb-2">
        </div>
    <?php endif; ?>
    
    <div class="mb-3">
        <label class="form-label">Gambar Featured Baru (kosongkan jika tidak ingin mengubah)</label>
        <input type="file" name="featured_image" class="form-control" accept="image/*">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Foto Berita (dari folder berita)</label>
        <select name="foto" class="form-select">
            <option value="">-- Pilih Foto --</option>
            <?php 
            $beritaImages = getBeritaImages();
            $currentFoto = $post['foto'] ?? '';
            foreach ($beritaImages as $image): 
            ?>
                <option value="<?= e($image) ?>" <?= $currentFoto === $image ? 'selected' : '' ?>><?= e($image) ?></option>
            <?php endforeach; ?>
        </select>
        <small class="form-text text-muted">Pilih foto dari folder berita yang sudah tersedia. Upload foto baru melalui script download_berita_images.php</small>
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


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
        <textarea name="content" class="form-control" rows="10" required><?= e(View::old('content')) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Gambar Featured</label>
        <input type="file" name="featured_image" class="form-control" accept="image/*">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Foto Berita (dari folder berita)</label>
        <select name="foto" class="form-select">
            <option value="">-- Pilih Foto --</option>
            <?php 
            $beritaImages = getBeritaImages();
            foreach ($beritaImages as $image): 
            ?>
                <option value="<?= e($image) ?>"><?= e($image) ?></option>
            <?php endforeach; ?>
        </select>
        <small class="form-text text-muted">Pilih foto dari folder berita yang sudah tersedia. Upload foto baru melalui script download_berita_images.php</small>
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


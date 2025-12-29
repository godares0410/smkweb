<?php
$pageTitle = 'Tambah Carousel';
$layout = 'admin';
?>

<h2 class="mb-4">Tambah Item Carousel</h2>

<form method="POST" action="<?= View::url('/admin/carousel') ?>" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="<?= e(View::old('title')) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3"><?= e(View::old('description')) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Gambar <span class="text-danger">*</span></label>
        <input type="file" name="image" class="form-control" accept="image/*" required>
        <small class="text-muted">Ukuran disarankan: 1920x800px atau lebih besar. Format: JPG, PNG, GIF, WebP</small>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Link (Opsional)</label>
                <input type="text" name="link" class="form-control" placeholder="/posts atau /page/kontak" value="<?= e(View::old('link')) ?>">
                <small class="text-muted">URL untuk tombol aksi pada carousel</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Teks Link (Opsional)</label>
                <input type="text" name="link_text" class="form-control" placeholder="Lihat Berita" value="<?= e(View::old('link_text')) ?>">
                <small class="text-muted">Teks untuk tombol aksi</small>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Urutan</label>
                <input type="number" name="order_position" class="form-control" value="<?= e(View::old('order_position', 0)) ?>" min="0">
                <small class="text-muted">Urutan tampil (angka lebih kecil muncul lebih dulu)</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= View::url('/admin/carousel') ?>" class="btn btn-secondary">Batal</a>
</form>


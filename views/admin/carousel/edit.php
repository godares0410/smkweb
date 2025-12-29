<?php
$pageTitle = 'Edit Carousel';
$layout = 'admin';
?>

<h2 class="mb-4">Edit Item Carousel</h2>

<form method="POST" action="<?= View::url('/admin/carousel/' . $item['id']) ?>" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="<?= e($item['title']) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3"><?= e($item['description']) ?></textarea>
    </div>
    
    <?php if ($item['image']): ?>
        <div class="mb-3">
            <label class="form-label">Gambar Saat Ini</label><br>
            <img src="<?= View::asset('images/carousel/' . $item['image']) ?>" 
                 style="max-width: 400px; height: auto; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" 
                 class="mb-2">
        </div>
    <?php endif; ?>
    
    <div class="mb-3">
        <label class="form-label">Gambar Baru (kosongkan jika tidak ingin mengubah)</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="text-muted">Ukuran disarankan: 1920x800px atau lebih besar</small>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Link (Opsional)</label>
                <input type="text" name="link" class="form-control" placeholder="/posts atau /page/kontak" value="<?= e($item['link']) ?>">
                <small class="text-muted">URL untuk tombol aksi pada carousel</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Teks Link (Opsional)</label>
                <input type="text" name="link_text" class="form-control" placeholder="Lihat Berita" value="<?= e($item['link_text']) ?>">
                <small class="text-muted">Teks untuk tombol aksi</small>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Urutan</label>
                <input type="number" name="order_position" class="form-control" value="<?= e($item['order_position']) ?>" min="0">
                <small class="text-muted">Urutan tampil (angka lebih kecil muncul lebih dulu)</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" <?= $item['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $item['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= View::url('/admin/carousel') ?>" class="btn btn-secondary">Batal</a>
</form>


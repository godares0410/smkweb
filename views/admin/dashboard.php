<?php
$pageTitle = 'Dashboard';
$layout = 'admin';
?>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Berita</h5>
                <h2><?= $stats['posts'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Berita Published</h5>
                <h2><?= $stats['published_posts'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Halaman</h5>
                <h2><?= $stats['pages'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Galeri</h5>
                <h2><?= $stats['gallery'] ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Berita Terbaru</h5>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPostModal">
                    <i class="bi bi-plus-circle"></i> Tambah Berita
                </button>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentPosts)): ?>
                            <tr><td colspan="4" class="text-center">Belum ada berita</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentPosts as $post): ?>
                                <tr>
                                    <td><?= e($post['title']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $post['status'] === 'published' ? 'success' : 'secondary' ?>">
                                            <?= ucfirst($post['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($post['created_at'])) ?></td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-sm btn-warning" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditPost<?= $post['id'] ?>"
                                                title="Edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Berita -->
<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-height: calc(100% - 1rem);">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPostModalLabel">
                    <i class="bi bi-plus-circle"></i> Tambah Berita Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPostForm" method="POST" action="<?= url('/admin/posts') ?>" enctype="multipart/form-data" style="display: flex; flex-direction: column; height: 100%;">
                <input type="hidden" name="from_dashboard" value="1">
                <div class="modal-body" style="flex: 1; overflow-y: auto;">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category" class="form-select" required>
                            <option value="Berita">Berita</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Kegiatan">Kegiatan</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="excerpt" class="form-control" rows="3" placeholder="Ringkasan singkat berita..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Konten <span class="text-danger">*</span></label>
                        <textarea name="content" id="modalContent" class="form-control" rows="10" required placeholder="Tulis konten berita di sini..."></textarea>
                        <small class="form-text text-muted">Gunakan editor untuk memformat konten berita</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Gambar Featured</label>
                        <input type="file" name="featured_image" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Format: JPG, PNG, GIF (maks. 5MB)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Foto Berita</label>
                        <div class="mb-2">
                            <input type="file" name="foto_upload" class="form-control" accept="image/*" id="addPostFotoUpload">
                            <small class="form-text text-muted">Upload foto baru (JPG, PNG, GIF - maks. 5MB)</small>
                        </div>
                        <div class="text-muted mb-2" style="font-size: 0.9em;">ATAU</div>
                        <select name="foto" class="form-select" id="addPostFotoSelect">
                            <option value="">-- Pilih Foto yang Sudah Ada --</option>
                            <?php 
                            $beritaImages = getBeritaImages();
                            foreach ($beritaImages as $image): 
                            ?>
                                <option value="<?= e($image) ?>"><?= e($image) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">Pilih foto dari folder berita yang sudah tersedia</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipe Layout</label>
                            <select name="type" class="form-select">
                                <option value="portrait">Portrait (Vertikal)</option>
                                <option value="landscape" selected>Landscape (Horizontal)</option>
                                <option value="square">Square (Persegi)</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- TinyMCE Editor for Modal -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
// Initialize TinyMCE when modal is shown
document.getElementById('addPostModal').addEventListener('shown.bs.modal', function () {
    if (!tinymce.get('modalContent')) {
        tinymce.init({
            selector: '#modalContent',
            height: 400,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help | code',
            content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
            language: 'id',
            branding: false,
            promotion: false
        });
    }
});

// Clean up TinyMCE when modal is hidden
document.getElementById('addPostModal').addEventListener('hidden.bs.modal', function () {
    if (tinymce.get('modalContent')) {
        tinymce.get('modalContent').remove();
    }
    // Reset form
    document.getElementById('addPostForm').reset();
});

// Handle form submission
document.getElementById('addPostForm').addEventListener('submit', function(e) {
    // Update TinyMCE content before submit
    if (tinymce.get('modalContent')) {
        tinymce.get('modalContent').save();
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    
    // Form will submit normally, server will handle redirect
});
</script>

<?php if (!empty($recentPosts)): ?>
    <?php foreach ($recentPosts as $post): ?>
<!-- Modal Edit Berita <?= $post['id'] ?> -->
<div class="modal fade" id="modalEditPost<?= $post['id'] ?>" tabindex="-1" aria-labelledby="modalEditPostLabel<?= $post['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-height: calc(100% - 1rem);">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditPostLabel<?= $post['id'] ?>">
                    <i class="bi bi-pencil"></i> Edit Berita
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?= url('/admin/posts/' . $post['id']) ?>" enctype="multipart/form-data" id="editPostForm<?= $post['id'] ?>" style="display: flex; flex-direction: column; height: 100%;">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="from_dashboard" value="1">
                
                <div class="modal-body" style="flex: 1; overflow-y: auto;">
                    <?php if ($post['featured_image']): ?>
                        <div class="mb-3">
                            <label class="form-label">Gambar Featured Saat Ini</label><br>
                            <img src="<?= View::asset('uploads/' . $post['featured_image']) ?>" 
                                 style="max-width: 200px; max-height: 200px; object-fit: cover;" 
                                 class="mb-2 rounded border">
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($post['foto']): ?>
                        <div class="mb-3">
                            <label class="form-label">Foto Berita Saat Ini</label><br>
                            <img src="<?= View::asset('images/berita/' . $post['foto']) ?>" 
                                 style="max-width: 200px; max-height: 200px; object-fit: cover;" 
                                 class="mb-2 rounded border">
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="<?= e($post['title']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category" class="form-select" required>
                            <option value="Berita" <?= $post['category'] === 'Berita' ? 'selected' : '' ?>>Berita</option>
                            <option value="Pengumuman" <?= $post['category'] === 'Pengumuman' ? 'selected' : '' ?>>Pengumuman</option>
                            <option value="Kegiatan" <?= $post['category'] === 'Kegiatan' ? 'selected' : '' ?>>Kegiatan</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="excerpt" class="form-control" rows="3"><?= e($post['excerpt'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Konten <span class="text-danger">*</span></label>
                        <textarea name="content" id="editPostContent<?= $post['id'] ?>" class="form-control" rows="15" required><?= e($post['content']) ?></textarea>
                        <small class="form-text text-muted">Gunakan editor untuk memformat konten berita</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Gambar Featured Baru</label>
                        <input type="file" name="featured_image" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah. Format: JPG, PNG, GIF (maks. 5MB)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Foto Berita</label>
                        <div class="mb-2">
                            <input type="file" name="foto_upload" class="form-control" accept="image/*" id="editPostFotoUpload<?= $post['id'] ?>">
                            <small class="form-text text-muted">Upload foto baru (JPG, PNG, GIF - maks. 5MB). Kosongkan jika tidak ingin mengubah.</small>
                        </div>
                        <div class="text-muted mb-2" style="font-size: 0.9em;">ATAU</div>
                        <select name="foto" class="form-select" id="editPostFotoSelect<?= $post['id'] ?>">
                            <option value="">-- Pilih Foto yang Sudah Ada --</option>
                            <?php 
                            $beritaImages = getBeritaImages();
                            $currentFoto = $post['foto'] ?? '';
                            foreach ($beritaImages as $image): 
                            ?>
                                <option value="<?= e($image) ?>" <?= $currentFoto === $image ? 'selected' : '' ?>><?= e($image) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">Pilih foto dari folder berita yang sudah tersedia</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipe Layout</label>
                            <select name="type" class="form-select">
                                <?php $currentType = $post['type'] ?? 'landscape'; ?>
                                <option value="portrait" <?= $currentType === 'portrait' ? 'selected' : '' ?>>Portrait (Vertikal)</option>
                                <option value="landscape" <?= $currentType === 'landscape' ? 'selected' : '' ?>>Landscape (Horizontal)</option>
                                <option value="square" <?= $currentType === 'square' ? 'selected' : '' ?>>Square (Persegi)</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="draft" <?= $post['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= $post['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Initialize TinyMCE for this specific modal when it's shown
document.getElementById('modalEditPost<?= $post['id'] ?>').addEventListener('shown.bs.modal', function () {
    if (!tinymce.get('editPostContent<?= $post['id'] ?>')) {
        tinymce.init({
            selector: '#editPostContent<?= $post['id'] ?>',
            height: 400,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help | code',
            content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
            language: 'id',
            branding: false,
            promotion: false
        });
    }
});

// Clean up TinyMCE when modal is hidden
document.getElementById('modalEditPost<?= $post['id'] ?>').addEventListener('hidden.bs.modal', function () {
    if (tinymce.get('editPostContent<?= $post['id'] ?>')) {
        tinymce.get('editPostContent<?= $post['id'] ?>').remove();
    }
});

// Handle form submission
document.getElementById('editPostForm<?= $post['id'] ?>').addEventListener('submit', function(e) {
    // Update TinyMCE content before submit
    if (tinymce.get('editPostContent<?= $post['id'] ?>')) {
        tinymce.get('editPostContent<?= $post['id'] ?>').save();
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    }
});
</script>
    <?php endforeach; ?>
<?php endif; ?>

<style>
/* Fix Modal Scroll - Like absensi project */
.modal-dialog-scrollable {
    max-height: calc(100% - 1rem);
}

.modal-dialog-scrollable .modal-content {
    max-height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.modal-dialog-scrollable .modal-body {
    overflow-y: auto !important;
    overflow-x: hidden;
    flex: 1 1 auto;
    max-height: calc(100vh - 200px);
    padding: 1rem;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
}

.modal-dialog-scrollable .modal-header,
.modal-dialog-scrollable .modal-footer {
    flex-shrink: 0;
}

/* Ensure modal is scrollable on smaller screens */
@media (max-height: 700px) {
    .modal-dialog-scrollable .modal-body {
        max-height: calc(100vh - 150px);
    }
}

@media (max-width: 768px) {
    .modal-dialog-scrollable .modal-body {
        max-height: calc(100vh - 180px);
    }
}

/* Fix for TinyMCE in modal - ensure it doesn't break scroll */
.modal-body .tox-tinymce {
    max-height: 400px;
    overflow: hidden;
}

.modal-body .tox .tox-edit-area__iframe {
    max-height: 400px;
}

/* Ensure form inside modal doesn't break scroll */
.modal-dialog-scrollable form {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 0;
}

.modal-dialog-scrollable form .modal-body {
    flex: 1;
    min-height: 0;
    overflow-y: auto !important;
}

.modal-dialog-scrollable form .modal-footer {
    flex-shrink: 0;
}
</style>


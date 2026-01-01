<?php
$pageTitle = 'Kelola Galeri';
$layout = 'admin';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-images"></i> Kelola Galeri</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateGallery">
        <i class="bi bi-plus-circle"></i> Tambah Foto
    </button>
</div>

<div class="row">
    <?php if (empty($gallery)): ?>
        <div class="col-12 text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <p class="text-muted mt-3">Belum ada foto di galeri</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateGallery">
                <i class="bi bi-plus-circle"></i> Tambah Foto Pertama
            </button>
        </div>
    <?php else: ?>
        <?php foreach ($gallery as $item): ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="<?= View::asset('uploads/' . $item['image']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5><?= e($item['title']) ?></h5>
                        <button onclick="openEditModal(<?= $item['id'] ?>)" class="btn btn-sm btn-warning">Edit</button>
                        <button onclick="deleteGallery(<?= $item['id'] ?>)" class="btn btn-sm btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Modal Create Gallery -->
<div class="modal fade" id="modalCreateGallery" tabindex="-1" aria-labelledby="modalCreateGalleryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateGalleryLabel">Tambah Foto ke Galeri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCreateGallery" method="POST" action="<?= View::url('/admin/gallery') ?>" enctype="multipart/form-data">
                <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="create_title" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="create_description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" id="create_category" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Gambar <span class="text-danger">*</span></label>
                        <input type="file" name="image" id="create_image" class="form-control" accept="image/*" required>
                        <small class="form-text text-muted">Format: JPG, PNG, GIF (Max 5MB)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tipe Layout</label>
                        <select name="type" id="create_type" class="form-select">
                            <option value="portrait">Portrait (Vertikal)</option>
                            <option value="landscape">Landscape (Horizontal)</option>
                            <option value="square" selected>Square (Persegi)</option>
                        </select>
                        <small class="form-text text-muted">Pilih tipe layout untuk menampilkan foto di galeri</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="create_status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Gallery -->
<div class="modal fade" id="modalEditGallery" tabindex="-1" aria-labelledby="modalEditGalleryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditGalleryLabel">Edit Foto Galeri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditGallery" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" id="edit_category" class="form-control">
                    </div>
                    
                    <div id="edit_current_image" class="mb-3" style="display: none;">
                        <label class="form-label">Gambar Saat Ini</label><br>
                        <img id="edit_image_preview" src="" style="max-width: 300px;" class="mb-2">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Gambar Baru</label>
                        <input type="file" name="image" id="edit_image" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tipe Layout</label>
                        <select name="type" id="edit_type" class="form-select">
                            <option value="portrait">Portrait (Vertikal)</option>
                            <option value="landscape">Landscape (Horizontal)</option>
                            <option value="square">Square (Persegi)</option>
                        </select>
                        <small class="form-text text-muted">Pilih tipe layout untuk menampilkan foto di galeri</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Ensure modal body is scrollable */
.modal-dialog-scrollable .modal-body {
    max-height: calc(100vh - 250px);
    overflow-y: auto;
    overflow-x: hidden;
}

.modal-dialog-scrollable {
    max-height: calc(100vh - 1rem);
}

.modal-dialog-scrollable .modal-content {
    max-height: 100%;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.modal-dialog-scrollable .modal-body {
    overflow-y: auto;
    flex: 1 1 auto;
}

.modal-body {
    scroll-behavior: smooth;
}
</style>

<script>
// Handle create form submission
document.addEventListener('DOMContentLoaded', function() {
    const modalCreate = document.getElementById('modalCreateGallery');
    const modalEdit = document.getElementById('modalEditGallery');
    
    modalCreate.addEventListener('hidden.bs.modal', function() {
        document.getElementById('formCreateGallery').reset();
    });
    
    // Handle create form submission
    document.getElementById('formCreateGallery').addEventListener('submit', function(e) {
        e.preventDefault();
        submitCreateForm();
    });
    
    // Handle edit form submission
    document.getElementById('formEditGallery').addEventListener('submit', function(e) {
        e.preventDefault();
        submitEditForm();
    });
});

function submitCreateForm() {
    const form = document.getElementById('formCreateGallery');
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            location.reload();
        } else {
            return response.json().then(data => {
                alert(data.message || 'Gagal menyimpan foto');
            }).catch(() => {
                alert('Gagal menyimpan foto');
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan foto');
    });
}

function submitEditForm() {
    const form = document.getElementById('formEditGallery');
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            location.reload();
        } else {
            return response.json().then(data => {
                alert(data.message || 'Gagal mengupdate foto');
            }).catch(() => {
                alert('Gagal mengupdate foto');
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate foto');
    });
}

function openEditModal(id) {
    fetch('<?= View::url('/admin/gallery/') ?>' + id + '/edit?json=1', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.item) {
            const item = data.item;
            
            // Set form action
            document.getElementById('formEditGallery').action = '<?= View::url('/admin/gallery/') ?>' + id;
            
            // Fill form fields
            document.getElementById('edit_title').value = item.title || '';
            document.getElementById('edit_description').value = item.description || '';
            document.getElementById('edit_category').value = item.category || '';
            document.getElementById('edit_type').value = item.type || 'square';
            document.getElementById('edit_status').value = item.status || 'active';
            
            // Handle current image
            if (item.image) {
                document.getElementById('edit_current_image').style.display = 'block';
                document.getElementById('edit_image_preview').src = '<?= View::asset('uploads/') ?>' + item.image;
            } else {
                document.getElementById('edit_current_image').style.display = 'none';
            }
            
            // Reset file input
            document.getElementById('edit_image').value = '';
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('modalEditGallery'));
            modal.show();
        } else {
            alert('Gagal memuat data foto');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memuat data foto');
    });
}

function deleteGallery(id) {
    if (!confirm('Yakin ingin menghapus foto ini?')) return;
    
    fetch('<?= View::url('/admin/gallery/') ?>' + id, {
        method: 'DELETE',
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) location.reload();
        else alert(data.message || 'Gagal menghapus');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menghapus foto');
    });
}
</script>

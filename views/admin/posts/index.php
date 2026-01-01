<?php
$pageTitle = 'Kelola Berita';
$layout = 'admin';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-newspaper"></i> Kelola Berita</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreatePost">
        <i class="bi bi-plus-circle"></i> Tambah Berita
    </button>
</div>

<!-- Search and Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= View::url('/admin/posts') ?>" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Cari Berita</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Cari berdasarkan judul..." 
                       value="<?= e(Request::get('search', '')) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    <option value="Berita" <?= Request::get('category') === 'Berita' ? 'selected' : '' ?>>Berita</option>
                    <option value="Pengumuman" <?= Request::get('category') === 'Pengumuman' ? 'selected' : '' ?>>Pengumuman</option>
                    <option value="Kegiatan" <?= Request::get('category') === 'Kegiatan' ? 'selected' : '' ?>>Kegiatan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="published" <?= Request::get('status') === 'published' ? 'selected' : '' ?>>Published</option>
                    <option value="draft" <?= Request::get('status') === 'draft' ? 'selected' : '' ?>>Draft</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <?php if (Request::get('search') || Request::get('category') || Request::get('status')): ?>
                        <a href="<?= View::url('/admin/posts') ?>" class="btn btn-secondary">
                            <i class="bi bi-x"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Posts Table -->
<div class="card">
    <div class="card-body">
        <?php if (empty($posts)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada berita</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreatePost">
                    <i class="bi bi-plus-circle"></i> Tambah Berita Pertama
                </button>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="30%">Judul</th>
                            <th width="10%">Kategori</th>
                            <th width="10%">Tipe</th>
                            <th width="10%">Status</th>
                            <th width="15%">Tanggal</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $index => $post): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($post['foto'] || $post['foto_tambahan']): ?>
                                            <?php 
                                            $imageFile = $post['foto'] ?? $post['foto_tambahan'];
                                            $imagePath = 'images/berita/' . $imageFile;
                                            ?>
                                            <img src="<?= View::asset($imagePath) ?>" 
                                                 alt="<?= e($post['title']) ?>" 
                                                 class="me-2 rounded" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php endif; ?>
                                        <div>
                                            <strong><?= e($post['title']) ?></strong>
                                            <?php if ($post['excerpt']): ?>
                                                <br><small class="text-muted"><?= e(substr($post['excerpt'], 0, 50)) ?><?= strlen($post['excerpt']) > 50 ? '...' : '' ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= e($post['category']) ?></span>
                                </td>
                                <td>
                                    <?php 
                                    $type = $post['type'] ?? 'landscape';
                                    $typeLabels = [
                                        'portrait' => ['label' => 'Portrait', 'class' => 'bg-primary'],
                                        'landscape' => ['label' => 'Landscape', 'class' => 'bg-success'],
                                        'square' => ['label' => 'Square', 'class' => 'bg-warning']
                                    ];
                                    $typeInfo = $typeLabels[$type] ?? $typeLabels['landscape'];
                                    ?>
                                    <span class="badge <?= $typeInfo['class'] ?>"><?= $typeInfo['label'] ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $post['status'] === 'published' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($post['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        <i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($post['created_at'])) ?><br>
                                        <i class="bi bi-eye"></i> <?= number_format($post['views'] ?? 0) ?> views
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <?php if ($post['status'] === 'published'): ?>
                                            <a href="<?= View::url('/post/' . $post['slug']) ?>" 
                                               target="_blank" 
                                               class="btn btn-outline-primary" 
                                               title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        <button onclick="openEditModal(<?= $post['id'] ?>)" 
                                                class="btn btn-outline-warning" 
                                                title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button onclick="deletePost(<?= $post['id'] ?>, '<?= e(addslashes($post['title'])) ?>')" 
                                                class="btn btn-outline-danger" 
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3 text-muted">
                <small>Total: <?= count($posts) ?> berita</small>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Create Post -->
<div class="modal fade" id="modalCreatePost" tabindex="-1" aria-labelledby="modalCreatePostLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreatePostLabel">Tambah Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCreatePost" method="POST" action="<?= View::url('/admin/posts') ?>" enctype="multipart/form-data">
                <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="create_title" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category" id="create_category" class="form-select" required>
                            <option value="Berita">Berita</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Kegiatan">Kegiatan</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="excerpt" id="create_excerpt" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Konten <span class="text-danger">*</span></label>
                        <textarea name="content" id="create_content" class="form-control" rows="15" required></textarea>
                        <small class="form-text text-muted">Gunakan editor untuk memformat konten berita</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Foto Berita</label>
                        <input type="file" name="foto_upload" id="create_foto_upload" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Upload foto baru (JPG, PNG, GIF, WEBP - maks. 5MB)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Foto Tambahan</label>
                        <input type="file" name="foto_tambahan" id="create_foto_tambahan" class="form-control" accept="image/*">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tipe Layout</label>
                        <select name="type" id="create_type" class="form-select">
                            <option value="portrait">Portrait (Vertikal)</option>
                            <option value="landscape" selected>Landscape (Horizontal)</option>
                            <option value="square">Square (Persegi)</option>
                        </select>
                        <small class="form-text text-muted">Pilih tipe layout untuk menampilkan berita di halaman beranda</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="create_status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
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

<!-- Modal Edit Post -->
<div class="modal fade" id="modalEditPost" tabindex="-1" aria-labelledby="modalEditPostLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditPostLabel">Edit Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditPost" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category" id="edit_category" class="form-select" required>
                            <option value="Berita">Berita</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Kegiatan">Kegiatan</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="excerpt" id="edit_excerpt" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Konten <span class="text-danger">*</span></label>
                        <textarea name="content" id="edit_content" class="form-control" rows="15" required></textarea>
                        <small class="form-text text-muted">Gunakan editor untuk memformat konten berita</small>
                    </div>
                    
                    <div id="edit_current_foto" class="mb-3" style="display: none;">
                        <label class="form-label">Foto Berita Saat Ini</label><br>
                        <img id="edit_foto_preview" src="" style="max-width: 200px;" class="mb-2">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Foto Berita</label>
                        <input type="file" name="foto_upload" id="edit_foto_upload" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Upload foto baru (JPG, PNG, GIF, WEBP - maks. 5MB). Kosongkan jika tidak ingin mengubah.</small>
                    </div>
                    
                    <div id="edit_current_foto_tambahan" class="mb-3" style="display: none;">
                        <label class="form-label">Foto Tambahan Saat Ini</label><br>
                        <img id="edit_foto_tambahan_preview" src="" style="max-width: 200px;" class="mb-2">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Foto Tambahan</label>
                        <input type="file" name="foto_tambahan" id="edit_foto_tambahan" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tipe Layout</label>
                        <select name="type" id="edit_type" class="form-select">
                            <option value="portrait">Portrait (Vertikal)</option>
                            <option value="landscape">Landscape (Horizontal)</option>
                            <option value="square">Square (Persegi)</option>
                        </select>
                        <small class="form-text text-muted">Pilih tipe layout untuk menampilkan berita di halaman beranda</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
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

<!-- Word Editor - Custom WYSIWYG Editor seperti MS Word -->
<link rel="stylesheet" href="<?= View::asset('css/word-editor.css') ?>">
<script src="<?= View::asset('js/color-picker.js') ?>"></script>
<script src="<?= View::asset('js/word-editor.js') ?>"></script>

<style>
/* Ensure modal body is scrollable */
.modal-dialog-scrollable .modal-body {
    max-height: calc(100vh - 250px);
    overflow-y: auto;
    overflow-x: hidden;
}

/* Fix for modal content height */
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

/* Smooth scrolling */
.modal-body {
    scroll-behavior: smooth;
}
</style>

<script>
let wordEditorCreate = null;
let wordEditorEdit = null;

// Initialize word editor when modal is shown
document.addEventListener('DOMContentLoaded', function() {
    const modalCreate = document.getElementById('modalCreatePost');
    const modalEdit = document.getElementById('modalEditPost');
    
    modalCreate.addEventListener('shown.bs.modal', function() {
        initWordEditor('create_content', 'create');
    });
    
    modalCreate.addEventListener('hidden.bs.modal', function() {
        syncEditorContent('create_content');
        document.getElementById('formCreatePost').reset();
        // Clean up editor on next show
        setTimeout(function() {
            const textarea = document.getElementById('create_content');
            if (textarea) {
                const wrapper = textarea.closest('.word-editor-wrapper');
                if (wrapper) {
                    const editorArea = wrapper.querySelector('.word-editor-area');
                    if (editorArea) {
                        textarea.value = editorArea.innerHTML;
                    }
                    textarea.style.display = '';
                    wrapper.replaceWith(textarea);
                    textarea.value = '';
                }
            }
            wordEditorCreate = null;
        }, 300);
    });
    
    modalEdit.addEventListener('shown.bs.modal', function() {
        initWordEditor('edit_content', 'edit');
    });
    
    modalEdit.addEventListener('hidden.bs.modal', function() {
        syncEditorContent('edit_content');
        // Clean up editor on next show
        setTimeout(function() {
            const textarea = document.getElementById('edit_content');
            if (textarea) {
                const wrapper = textarea.closest('.word-editor-wrapper');
                if (wrapper) {
                    const editorArea = wrapper.querySelector('.word-editor-area');
                    if (editorArea) {
                        textarea.value = editorArea.innerHTML;
                    }
                    textarea.style.display = '';
                    wrapper.replaceWith(textarea);
                }
            }
            wordEditorEdit = null;
        }, 300);
    });
    
    // Handle create form submission
    document.getElementById('formCreatePost').addEventListener('submit', function(e) {
        e.preventDefault();
        submitCreateForm();
    });
    
    // Handle edit form submission
    document.getElementById('formEditPost').addEventListener('submit', function(e) {
        e.preventDefault();
        submitEditForm();
    });
});

function initWordEditor(textareaId, type) {
    // Wait a bit for modal to fully render
    setTimeout(function() {
        const textarea = document.getElementById(textareaId);
        if (!textarea) return;
        
        // Check if editor already initialized
        if (textarea.closest('.word-editor-wrapper')) {
            return;
        }
        
        // Initialize word editor using WordEditor class
        if (typeof window.WordEditor !== 'undefined') {
            try {
                const editor = new window.WordEditor('#' + textareaId);
                if (type === 'create') {
                    wordEditorCreate = editor;
                } else {
                    wordEditorEdit = editor;
                }
            } catch (e) {
                console.error('Error initializing WordEditor:', e);
            }
        } else {
            console.error('WordEditor class not found');
        }
    }, 200);
}

function syncEditorContent(textareaId) {
    const textarea = document.getElementById(textareaId);
    if (textarea) {
        const wrapper = textarea.closest('.word-editor-wrapper');
        if (wrapper) {
            const editorArea = wrapper.querySelector('.word-editor-area');
            if (editorArea) {
                textarea.value = editorArea.innerHTML;
            }
        }
    }
}

function submitCreateForm() {
    syncEditorContent('create_content');
    
    const form = document.getElementById('formCreatePost');
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
                alert(data.message || 'Gagal menyimpan berita');
            }).catch(() => {
                alert('Gagal menyimpan berita');
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan berita');
    });
}

function submitEditForm() {
    syncEditorContent('edit_content');
    
    const form = document.getElementById('formEditPost');
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
                alert(data.message || 'Gagal mengupdate berita');
            }).catch(() => {
                alert('Gagal mengupdate berita');
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate berita');
    });
}

function openEditModal(id) {
    fetch('<?= View::url('/admin/posts/') ?>' + id + '/edit?json=1', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.post) {
            const post = data.post;
            
            // Set form action
            document.getElementById('formEditPost').action = '<?= View::url('/admin/posts/') ?>' + id;
            
            // Fill form fields
            document.getElementById('edit_title').value = post.title || '';
            document.getElementById('edit_category').value = post.category || 'Berita';
            document.getElementById('edit_excerpt').value = post.excerpt || '';
            document.getElementById('edit_content').value = post.content || '';
            document.getElementById('edit_type').value = post.type || 'landscape';
            document.getElementById('edit_status').value = post.status || 'draft';
            
            // Handle current photos
            if (post.foto) {
                document.getElementById('edit_current_foto').style.display = 'block';
                document.getElementById('edit_foto_preview').src = '<?= View::asset('images/berita/') ?>' + post.foto;
            } else {
                document.getElementById('edit_current_foto').style.display = 'none';
            }
            
            if (post.foto_tambahan) {
                document.getElementById('edit_current_foto_tambahan').style.display = 'block';
                document.getElementById('edit_foto_tambahan_preview').src = '<?= View::asset('images/berita/') ?>' + post.foto_tambahan;
            } else {
                document.getElementById('edit_current_foto_tambahan').style.display = 'none';
            }
            
            // Reset file inputs
            document.getElementById('edit_foto_upload').value = '';
            document.getElementById('edit_foto_tambahan').value = '';
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('modalEditPost'));
            modal.show();
        } else {
            alert('Gagal memuat data berita');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memuat data berita');
    });
}

function deletePost(id, title) {
    if (!confirm('Yakin ingin menghapus berita "' + title + '"?')) return;
    
    fetch('<?= View::url('/admin/posts/') ?>' + id, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Gagal menghapus');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menghapus berita');
    });
}
</script>

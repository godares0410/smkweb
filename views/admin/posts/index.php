<?php
$pageTitle = 'Kelola Berita';
$layout = 'admin';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-newspaper"></i> Kelola Berita</h2>
    <a href="<?= View::url('/admin/posts/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Berita
    </a>
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
                <a href="<?= View::url('/admin/posts/create') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Berita Pertama
                </a>
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
                                        <a href="<?= View::url('/admin/posts/' . $post['id'] . '/edit') ?>" 
                                           class="btn btn-outline-warning" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
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

<script>
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


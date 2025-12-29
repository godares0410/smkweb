<?php
$pageTitle = 'Kelola Berita';
$layout = 'admin';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kelola Berita</h2>
    <a href="<?= View::url('/admin/posts/create') ?>" class="btn btn-primary">Tambah Berita</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($posts)): ?>
            <tr><td colspan="5" class="text-center">Belum ada berita</td></tr>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= e($post['title']) ?></td>
                    <td><?= e($post['category']) ?></td>
                    <td>
                        <span class="badge bg-<?= $post['status'] === 'published' ? 'success' : 'secondary' ?>">
                            <?= ucfirst($post['status']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($post['created_at'])) ?></td>
                    <td>
                        <a href="<?= View::url('/admin/posts/' . $post['id'] . '/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                        <button onclick="deletePost(<?= $post['id'] ?>)" class="btn btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
function deletePost(id) {
    if (!confirm('Yakin ingin menghapus berita ini?')) return;
    
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
    });
}
</script>


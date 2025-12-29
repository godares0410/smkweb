<?php
$pageTitle = 'Kelola Halaman';
$layout = 'admin';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kelola Halaman</h2>
    <a href="<?= View::url('/admin/pages/create') ?>" class="btn btn-primary">Tambah Halaman</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($pages)): ?>
            <tr><td colspan="5" class="text-center">Belum ada halaman</td></tr>
        <?php else: ?>
            <?php foreach ($pages as $page): ?>
                <tr>
                    <td><?= e($page['title']) ?></td>
                    <td><?= e($page['slug']) ?></td>
                    <td>
                        <span class="badge bg-<?= $page['status'] === 'published' ? 'success' : 'secondary' ?>">
                            <?= ucfirst($page['status']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($page['created_at'])) ?></td>
                    <td>
                        <a href="<?= View::url('/admin/pages/' . $page['id'] . '/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                        <button onclick="deletePage(<?= $page['id'] ?>)" class="btn btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
function deletePage(id) {
    if (!confirm('Yakin ingin menghapus halaman ini?')) return;
    fetch('<?= View::url('/admin/pages/') ?>' + id, {
        method: 'DELETE',
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    }).then(r => r.json()).then(data => {
        if (data.success) location.reload();
        else alert(data.message || 'Gagal menghapus');
    });
}
</script>


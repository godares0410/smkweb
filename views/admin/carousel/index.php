<?php
$pageTitle = 'Kelola Carousel';
$layout = 'admin';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kelola Carousel</h2>
    <a href="<?= View::url('/admin/carousel/create') ?>" class="btn btn-primary">Tambah Carousel</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th width="80">Gambar</th>
            <th>Judul</th>
            <th width="100">Urutan</th>
            <th width="100">Status</th>
            <th width="200">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($carousel)): ?>
            <tr><td colspan="5" class="text-center">Belum ada item carousel</td></tr>
        <?php else: ?>
            <?php foreach ($carousel as $item): ?>
                <tr>
                    <td>
                        <?php if ($item['image']): ?>
                            <img src="<?= View::asset('images/carousel/' . $item['image']) ?>" 
                                 alt="<?= e($item['title']) ?>" 
                                 style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td><?= e($item['title']) ?></td>
                    <td><?= e($item['order_position']) ?></td>
                    <td>
                        <span class="badge bg-<?= $item['status'] === 'active' ? 'success' : 'secondary' ?>">
                            <?= ucfirst($item['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= View::url('/admin/carousel/' . $item['id'] . '/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                        <button onclick="deleteCarousel(<?= $item['id'] ?>)" class="btn btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
function deleteCarousel(id) {
    if (!confirm('Yakin ingin menghapus item carousel ini?')) return;
    
    fetch('<?= View::url('/admin/carousel/') ?>' + id, {
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


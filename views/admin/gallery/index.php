<?php
$pageTitle = 'Kelola Galeri';
$layout = 'admin';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kelola Galeri</h2>
    <a href="<?= View::url('/admin/gallery/create') ?>" class="btn btn-primary">Tambah Foto</a>
</div>

<div class="row">
    <?php if (empty($gallery)): ?>
        <div class="col-12 text-center">Belum ada foto di galeri</div>
    <?php else: ?>
        <?php foreach ($gallery as $item): ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="<?= View::asset('uploads/' . $item['image']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5><?= e($item['title']) ?></h5>
                        <a href="<?= View::url('/admin/gallery/' . $item['id'] . '/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                        <button onclick="deleteGallery(<?= $item['id'] ?>)" class="btn btn-sm btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
function deleteGallery(id) {
    if (!confirm('Yakin ingin menghapus foto ini?')) return;
    fetch('<?= View::url('/admin/gallery/') ?>' + id, {
        method: 'DELETE',
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    }).then(r => r.json()).then(data => {
        if (data.success) location.reload();
        else alert(data.message || 'Gagal menghapus');
    });
}
</script>


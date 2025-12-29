<?php
$pageTitle = 'Kelola Admin';
$layout = 'admin';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kelola Admin</h2>
    <a href="<?= View::url('/admin/users/create') ?>" class="btn btn-primary">Tambah Admin</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($admins)): ?>
            <tr><td colspan="5" class="text-center">Belum ada admin</td></tr>
        <?php else: ?>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?= e($admin['username']) ?></td>
                    <td><?= e($admin['email']) ?></td>
                    <td><?= e($admin['name']) ?></td>
                    <td><span class="badge bg-info"><?= e($admin['role']) ?></span></td>
                    <td>
                        <a href="<?= View::url('/admin/users/' . $admin['id'] . '/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                        <?php if ($admin['id'] != Auth::id()): ?>
                            <button onclick="deleteUser(<?= $admin['id'] ?>)" class="btn btn-sm btn-danger">Hapus</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
function deleteUser(id) {
    if (!confirm('Yakin ingin menghapus admin ini?')) return;
    fetch('<?= View::url('/admin/users/') ?>' + id, {
        method: 'DELETE',
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    }).then(r => r.json()).then(data => {
        if (data.success) location.reload();
        else alert(data.message || 'Gagal menghapus');
    });
}
</script>


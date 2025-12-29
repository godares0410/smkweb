<?php
$pageTitle = 'Edit Admin';
$layout = 'admin';
?>

<h2 class="mb-4">Edit Admin</h2>

<form method="POST" action="<?= View::url('/admin/users/' . $admin['id']) ?>">
    <input type="hidden" name="_method" value="PUT">
    
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="<?= e($admin['email']) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" required value="<?= e($admin['name']) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Password Baru (kosongkan jika tidak ingin mengubah)</label>
        <input type="password" name="password" class="form-control">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select">
            <option value="admin" <?= $admin['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="super_admin" <?= $admin['role'] === 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= View::url('/admin/users') ?>" class="btn btn-secondary">Batal</a>
</form>


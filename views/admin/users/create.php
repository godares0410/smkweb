<?php
$pageTitle = 'Tambah Admin';
$layout = 'admin';
?>

<h2 class="mb-4">Tambah Admin</h2>

<form method="POST" action="<?= View::url('/admin/users') ?>">
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required value="<?= e(View::old('username')) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="<?= e(View::old('email')) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" required value="<?= e(View::old('name')) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select">
            <option value="admin">Admin</option>
            <option value="super_admin">Super Admin</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= View::url('/admin/users') ?>" class="btn btn-secondary">Batal</a>
</form>


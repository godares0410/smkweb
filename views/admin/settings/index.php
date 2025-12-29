<?php
$pageTitle = 'Pengaturan';
$layout = 'admin';
?>

<h2 class="mb-4">Pengaturan Website</h2>

<form method="POST" action="<?= View::url('/admin/settings') ?>">
    <div class="mb-3">
        <label class="form-label">Nama Website</label>
        <input type="text" name="site_name" class="form-control" value="<?= e($settings['site_name'] ?? '') ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Deskripsi Website</label>
        <textarea name="site_description" class="form-control" rows="3"><?= e($settings['site_description'] ?? '') ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="site_email" class="form-control" value="<?= e($settings['site_email'] ?? '') ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Telepon</label>
        <input type="text" name="site_phone" class="form-control" value="<?= e($settings['site_phone'] ?? '') ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="site_address" class="form-control" rows="2"><?= e($settings['site_address'] ?? '') ?></textarea>
    </div>
    
    <h5 class="mt-4 mb-3">Media Sosial</h5>
    
    <div class="mb-3">
        <label class="form-label">Facebook URL</label>
        <input type="url" name="facebook_url" class="form-control" value="<?= e($settings['facebook_url'] ?? '') ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Twitter URL</label>
        <input type="url" name="twitter_url" class="form-control" value="<?= e($settings['twitter_url'] ?? '') ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Instagram URL</label>
        <input type="url" name="instagram_url" class="form-control" value="<?= e($settings['instagram_url'] ?? '') ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">YouTube URL</label>
        <input type="url" name="youtube_url" class="form-control" value="<?= e($settings['youtube_url'] ?? '') ?>">
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
</form>


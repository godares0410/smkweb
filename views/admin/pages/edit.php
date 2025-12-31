<?php
$pageTitle = 'Edit Halaman';
$layout = 'admin';
?>

<h2 class="mb-4">Edit Halaman</h2>

<form method="POST" action="<?= View::url('/admin/pages/' . $page['id']) ?>">
    <input type="hidden" name="_method" value="PUT">
    
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="<?= e($page['title']) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Ringkasan</label>
        <textarea name="excerpt" class="form-control" rows="3"><?= e($page['excerpt']) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Konten</label>
        <textarea name="content" id="content" class="form-control" rows="10" required><?= e($page['content']) ?></textarea>
        <small class="form-text text-muted">Gunakan editor untuk memformat konten halaman</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="draft" <?= $page['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $page['status'] === 'published' ? 'selected' : '' ?>>Published</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= View::url('/admin/pages') ?>" class="btn btn-secondary">Batal</a>
</form>

<!-- Word Editor - Custom WYSIWYG Editor seperti MS Word -->
<link rel="stylesheet" href="<?= View::asset('css/word-editor.css') ?>">
<script src="<?= View::asset('js/color-picker.js') ?>"></script>
<script src="<?= View::asset('js/word-editor.js') ?>"></script>
<script>
// Sync content before form submit
document.querySelector('form').addEventListener('submit', function(e) {
    const editor = document.querySelector('.word-editor-area');
    if (editor) {
        document.getElementById('content').value = editor.innerHTML;
    }
});
</script>


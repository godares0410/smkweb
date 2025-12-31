<?php
$pageTitle = 'Tambah Halaman';
$layout = 'admin';
?>

<h2 class="mb-4">Tambah Halaman</h2>

<form method="POST" action="<?= View::url('/admin/pages') ?>">
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required value="<?= e(View::old('title')) ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Ringkasan</label>
        <textarea name="excerpt" class="form-control" rows="3"><?= e(View::old('excerpt')) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Konten</label>
        <textarea name="content" id="content" class="form-control" rows="10" required><?= e(View::old('content')) ?></textarea>
        <small class="form-text text-muted">Gunakan editor untuk memformat konten halaman</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
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


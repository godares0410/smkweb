<?php
$pageTitle = $post['title'];
?>

<article class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1><?= e($post['title']) ?></h1>
                <p class="text-muted">
                    <i class="bi bi-calendar"></i> <?= date('d F Y', strtotime($post['created_at'])) ?>
                    <?php if ($post['category']): ?>
                        | <i class="bi bi-tag"></i> <?= e($post['category']) ?>
                    <?php endif; ?>
                </p>
                
                <?php 
                // Prioritaskan foto, jika tidak ada gunakan featured_image
                $imageFile = $post['foto'] ?? $post['featured_image'] ?? null;
                if ($imageFile): 
                    // Cek apakah foto ada di folder berita atau uploads
                    $imagePath = $post['foto'] ? 'images/berita/' . $imageFile : 'uploads/' . $imageFile;
                ?>
                    <img src="<?= View::asset($imagePath) ?>" class="img-fluid mb-4" alt="<?= e($post['title']) ?>">
                <?php endif; ?>
                
                <div class="content">
                    <?= $post['content'] ?>
                </div>
                
                <div class="mt-4">
                    <a href="<?= View::url('/posts') ?>" class="btn btn-outline-primary">Kembali ke Daftar Berita</a>
                </div>
            </div>
        </div>
    </div>
</article>


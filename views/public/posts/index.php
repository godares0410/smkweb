<?php
$pageTitle = 'Berita';
?>

<section class="py-5">
    <div class="container">
        <h1 class="mb-4">Berita & Artikel</h1>
        <div class="row">
            <?php if (empty($posts)): ?>
                <div class="col-12">
                    <p class="text-muted">Belum ada berita.</p>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <?php 
                            // Prioritaskan foto, jika tidak ada gunakan foto_tambahan
                            $imageFile = $post['foto'] ?? $post['foto_tambahan'] ?? null;
                            if ($imageFile): 
                                // Semua foto disimpan di folder images/berita
                                $imagePath = 'images/berita/' . $imageFile;
                            ?>
                                <img src="<?= View::asset($imagePath) ?>" class="card-img-top" alt="<?= e($post['title']) ?>" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= e($post['title']) ?></h5>
                                <p class="text-muted small"><?= date('d F Y', strtotime($post['created_at'])) ?></p>
                                <p class="card-text"><?= e($post['excerpt'] ?? substr(strip_tags($post['content']), 0, 150)) ?>...</p>
                                <a href="<?= View::url('/post/' . $post['slug']) ?>" class="btn btn-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>


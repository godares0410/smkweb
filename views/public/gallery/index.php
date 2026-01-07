<?php
$pageTitle = 'Galeri Foto';
?>

<section class="py-5">
    <div class="container">
        <h1 class="mb-4">Galeri Foto</h1>
        <div class="row">
            <?php if (empty($gallery)): ?>
                <div class="col-12">
                    <p class="text-muted">Belum ada foto di galeri.</p>
                </div>
            <?php else: ?>
                <?php foreach ($gallery as $item): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0 transition-hover">
                            <img src="<?= View::asset('images/galeri/' . $item['image']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= e($item['title']) ?>" 
                                 style="height: 300px; object-fit: cover; cursor: pointer;"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#lightboxModal" 
                                 data-bs-src="<?= View::asset('images/galeri/' . $item['image']) ?>"
                                 data-bs-title="<?= e($item['title']) ?>"
                                 data-bs-description="<?= e($item['description']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= e($item['title']) ?></h5>
                                <?php if ($item['description']): ?>
                                    <p class="card-text"><?= e($item['description']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>


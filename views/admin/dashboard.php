<?php
$pageTitle = 'Dashboard';
$layout = 'admin';
?>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Berita</h5>
                <h2><?= $stats['posts'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Berita Published</h5>
                <h2><?= $stats['published_posts'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Halaman</h5>
                <h2><?= $stats['pages'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Galeri</h5>
                <h2><?= $stats['gallery'] ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Berita Terbaru</h5>
                <div class="btn-group">
                    <a href="<?= url('/admin/posts') ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-list"></i> Kelola Berita
                    </a>
                    <a href="<?= url('/admin/posts/create') ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Berita
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($recentPosts)): ?>
                    <div class="text-center py-4">
                        <i class="bi bi-inbox display-4 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada berita</p>
                        <a href="<?= url('/admin/posts/create') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Berita Pertama
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentPosts as $post): ?>
                                    <tr>
                                        <td>
                                            <strong><?= e($post['title']) ?></strong>
                                            <?php if ($post['excerpt']): ?>
                                                <br><small class="text-muted"><?= e(substr($post['excerpt'], 0, 60)) ?><?= strlen($post['excerpt']) > 60 ? '...' : '' ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?= e($post['category']) ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= $post['status'] === 'published' ? 'success' : 'secondary' ?>">
                                                <?= ucfirst($post['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small>
                                                <i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <?php if ($post['status'] === 'published'): ?>
                                                    <a href="<?= url('/post/' . $post['slug']) ?>" 
                                                       target="_blank" 
                                                       class="btn btn-outline-primary" 
                                                       title="Lihat">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?= url('/admin/posts/' . $post['id'] . '/edit') ?>" 
                                                   class="btn btn-outline-warning" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 text-center">
                        <a href="<?= url('/admin/posts') ?>" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-right"></i> Lihat Semua Berita
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



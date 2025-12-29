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
                <a href="<?= View::url('/admin/posts/create') ?>" class="btn btn-sm btn-primary">Tambah Berita</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentPosts)): ?>
                            <tr><td colspan="4" class="text-center">Belum ada berita</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentPosts as $post): ?>
                                <tr>
                                    <td><?= e($post['title']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $post['status'] === 'published' ? 'success' : 'secondary' ?>">
                                            <?= ucfirst($post['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($post['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= View::url('/admin/posts/' . $post['id'] . '/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


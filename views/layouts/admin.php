<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admin Panel') ?> - SMK Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= View::asset('css/admin.css') ?>">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-dark text-white p-3" style="min-width: 250px; min-height: 100vh;">
            <h4 class="mb-4">Admin Panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="<?= View::url('/admin/dashboard') ?>">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="<?= View::url('/admin/posts') ?>">
                        <i class="bi bi-newspaper"></i> Berita
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="<?= View::url('/admin/pages') ?>">
                        <i class="bi bi-file-text"></i> Halaman
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="<?= View::url('/admin/gallery') ?>">
                        <i class="bi bi-images"></i> Galeri
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="<?= View::url('/admin/carousel') ?>">
                        <i class="bi bi-sliders"></i> Carousel
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="<?= View::url('/admin/settings') ?>">
                        <i class="bi bi-gear"></i> Pengaturan
                    </a>
                </li>
                <?php if (Auth::isAdmin()): ?>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="<?= View::url('/admin/users') ?>">
                        <i class="bi bi-people"></i> Admin Users
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item mb-2">
                    <form method="POST" action="<?= View::url('/admin/logout') ?>" class="d-inline">
                        <button type="submit" class="nav-link text-white bg-transparent border-0 w-100 text-start">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Top Bar -->
            <nav class="navbar navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0"><?= e($pageTitle ?? 'Admin Panel') ?></span>
                    <a href="<?= View::url('/') ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> Lihat Website
                    </a>
                </div>
            </nav>

            <!-- Content Area -->
            <div class="p-4">
                <?php if ($flash = View::flash('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= e($flash) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($flash = View::flash('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= e($flash) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?= $content ?? '' ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= View::asset('js/admin.js') ?>"></script>
</body>
</html>


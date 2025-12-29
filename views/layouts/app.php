<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'SMK Web') ?> - <?= e($settings['site_name'] ?? 'SMK Web') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= View::asset('css/style.css') ?>?v=<?= time() ?>">
</head>
<body>
    <!-- Navigation -->
    <header>
        <div class="navbar">
            <div class="logo">
                <a href="<?= View::url('/') ?>"><?= e($settings['site_name'] ?? 'SMK Web') ?></a>
            </div>
            <ul class="links">
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#berita">Berita</a></li>
                <li><a href="#galeri">Galeri</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
            <?php if (Auth::check()): ?>
                <a href="<?= View::url('/admin/dashboard') ?>" class="action_btn">Admin</a>
            <?php else: ?>
                <a href="<?= View::url('/admin/login') ?>" class="action_btn">Login</a>
            <?php endif; ?>
            <div class="toggle_btn">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
        <div class="dropdown_menu">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#berita">Berita</a></li>
            <li><a href="#galeri">Galeri</a></li>
            <li><a href="#kontak">Kontak</a></li>
            <?php if (Auth::check()): ?>
                <a href="<?= View::url('/admin/dashboard') ?>" class="action_btn">Admin</a>
            <?php else: ?>
                <a href="<?= View::url('/admin/login') ?>" class="action_btn">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="footer-modern">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title mb-3">
                        <i class="bi bi-mortarboard-fill me-2"></i><?= e($settings['site_name'] ?? 'SMK Web') ?>
                    </h5>
                    <p class="text-muted"><?= e($settings['site_description'] ?? 'Website Sekolah Menengah Kejuruan') ?></p>
                    <?php if (!empty($settings['site_address'])): ?>
                        <p class="text-muted mb-2">
                            <i class="bi bi-geo-alt me-2"></i><?= e($settings['site_address']) ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-subtitle mb-3">Navigasi</h6>
                    <ul class="footer-links">
                        <li><a href="<?= View::url('/') ?>">Beranda</a></li>
                        <li><a href="<?= View::url('/posts') ?>">Berita</a></li>
                        <li><a href="<?= View::url('/gallery') ?>">Galeri</a></li>
                        <li><a href="<?= View::url('/page/kontak') ?>">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-subtitle mb-3">Kontak</h6>
                    <ul class="footer-contact">
                        <?php if (!empty($settings['site_email'])): ?>
                            <li><i class="bi bi-envelope me-2"></i><?= e($settings['site_email']) ?></li>
                        <?php endif; ?>
                        <?php if (!empty($settings['site_phone'])): ?>
                            <li><i class="bi bi-telephone me-2"></i><?= e($settings['site_phone']) ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-subtitle mb-3">Ikuti Kami</h6>
                    <div class="social-links">
                        <?php if (!empty($settings['facebook_url'])): ?>
                            <a href="<?= e($settings['facebook_url']) ?>" target="_blank" class="social-link" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['instagram_url'])): ?>
                            <a href="<?= e($settings['instagram_url']) ?>" target="_blank" class="social-link" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['twitter_url'])): ?>
                            <a href="<?= e($settings['twitter_url']) ?>" target="_blank" class="social-link" title="Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['youtube_url'])): ?>
                            <a href="<?= e($settings['youtube_url']) ?>" target="_blank" class="social-link" title="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-muted mb-0">
                        &copy; <?= date('Y') ?> <?= e($settings['site_name'] ?? 'SMK Web') ?>. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= View::asset('js/main.js') ?>"></script>
</body>
</html>


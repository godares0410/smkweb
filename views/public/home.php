<?php
$pageTitle = 'Beranda';
?>

<!-- Carousel Section -->
<div id="beranda">
<?php if (!empty($carouselItems)): ?>
<div id="heroCarousel" class="carousel slide carousel-hero" data-bs-ride="carousel" data-bs-interval="5000">
    <!-- Indicators -->
    <div class="carousel-indicators">
        <?php foreach ($carouselItems as $index => $item): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" 
                    class="<?= $index === 0 ? 'active' : '' ?>" 
                    aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                    aria-label="Slide <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
    </div>

    <!-- Carousel Items -->
    <div class="carousel-inner">
        <?php foreach ($carouselItems as $index => $item): ?>
            <?php 
            $imageUrl = View::asset('images/carousel/' . $item['image']);
            $title = $item['title'] ?? '';
            $description = $item['description'] ?? '';
            $link = $item['link'] ?? '';
            $linkText = $item['link_text'] ?? '';
            ?>
            <?php if (!empty($item['image'])): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="carousel-image-wrapper">
                        <img src="<?= e($imageUrl) ?>" class="d-block w-100" alt="<?= e($title) ?>">
                    </div>
                    <div class="carousel-caption">
                        <div class="carousel-content">
                            <h2 class="carousel-title"><?= e($title) ?></h2>
                            <?php if (!empty($description)): ?>
                                <p class="carousel-text d-none d-md-block"><?= e(substr(strip_tags($description), 0, 150)) ?><?= strlen(strip_tags($description)) > 150 ? '...' : '' ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Previous/Next Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php else: ?>
<!-- Hero Section (Fallback jika tidak ada carousel) -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h1 class="hero-title animate-fade-in"><?= e($settings['site_name'] ?? 'SMK Web') ?></h1>
                <p class="hero-subtitle animate-fade-in-delay"><?= e($settings['site_description'] ?? 'Membangun Generasi Unggul Berkarakter dan Berkompetensi') ?></p>
                <div class="hero-buttons animate-fade-in-delay-2">
                    <a href="<?= View::url('/posts') ?>" class="btn btn-light btn-lg me-3">
                        <i class="bi bi-newspaper"></i> Lihat Berita
                    </a>
                    <a href="<?= View::url('/gallery') ?>" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-images"></i> Galeri Foto
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="currentColor"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="currentColor"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="currentColor"></path>
        </svg>
    </div>
</section>
<?php endif; ?>
</div>

<!-- Features Section -->
<section id="features" class="features-section py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <h4>Pendidikan Berkualitas</h4>
                    <p class="text-muted">Menyediakan pendidikan yang berkualitas dengan kurikulum terbaru</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <h4>Prestasi Gemilang</h4>
                    <p class="text-muted">Mencetak siswa berprestasi di berbagai bidang kompetisi</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4>Guru Berpengalaman</h4>
                    <p class="text-muted">Didukung oleh tenaga pendidik yang berpengalaman dan profesional</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Posts -->
<section id="berita" class="posts-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Berita & Pengumuman Terbaru</h2>
            <p class="section-subtitle text-muted">Informasi terkini dari sekolah kami</p>
        </div>
        <div class="row g-4">
            <?php if (empty($posts)): ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada berita untuk ditampilkan.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <article class="news-card">
                            <a href="<?= View::url('/post/' . $post['slug']) ?>" class="text-decoration-none">
                                <?php 
                                // Prioritaskan foto, jika tidak ada gunakan featured_image
                                $imageFile = $post['foto'] ?? $post['featured_image'] ?? null;
                                if ($imageFile): 
                                    // Cek apakah foto ada di folder berita atau uploads
                                    $imagePath = $post['foto'] ? 'images/berita/' . $imageFile : 'uploads/' . $imageFile;
                                ?>
                                    <div class="news-card-image">
                                        <img src="<?= View::asset($imagePath) ?>" alt="<?= e($post['title']) ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="news-card-body">
                                    <div class="news-card-meta">
                                        <span class="badge"><?= e($post['category']) ?></span>
                                        <span class="text-muted">
                                            <i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($post['created_at'])) ?>
                                        </span>
                                    </div>
                                    <h5 class="news-card-title">
                                        <?= e($post['title']) ?>
                                    </h5>
                                    <p class="news-card-text"><?= e($post['excerpt'] ?? substr(strip_tags($post['content']), 0, 120)) ?></p>
                                    <span class="news-card-link">
                                        Baca selengkapnya <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section id="galeri" class="gallery-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Galeri Kegiatan</h2>
            <p class="section-subtitle text-muted">Momen-momen terbaik dari kegiatan sekolah</p>
        </div>
        <div class="row g-3">
            <?php if (empty($gallery)): ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-image display-1 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada foto di galeri.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php 
                $displayGallery = array_slice($gallery, 0, 6); // Show only 6 items
                foreach ($displayGallery as $item): 
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-item">
                            <img src="<?= View::asset('uploads/' . $item['image']) ?>" alt="<?= e($item['title']) ?>">
                            <div class="gallery-overlay">
                                <div class="gallery-content">
                                    <h5><?= e($item['title']) ?></h5>
                                    <?php if ($item['description']): ?>
                                        <p><?= e(substr($item['description'], 0, 80)) ?>...</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Kontak Section -->
<section id="kontak" class="cta-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-10 mx-auto">
                <div class="text-center mb-5">
                    <h2 class="section-title text-white">Hubungi Kami</h2>
                    <p class="section-subtitle text-white-50">Kami siap membantu menjawab pertanyaan Anda</p>
                </div>
                <div class="row g-4">
                    <?php if (!empty($settings['site_address'])): ?>
                        <div class="col-md-4 text-center text-white">
                            <div class="contact-item">
                                <i class="bi bi-geo-alt-fill display-4 mb-3"></i>
                                <h5>Alamat</h5>
                                <p><?= e($settings['site_address']) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($settings['site_email'])): ?>
                        <div class="col-md-4 text-center text-white">
                            <div class="contact-item">
                                <i class="bi bi-envelope-fill display-4 mb-3"></i>
                                <h5>Email</h5>
                                <p><a href="mailto:<?= e($settings['site_email']) ?>" class="text-white text-decoration-none"><?= e($settings['site_email']) ?></a></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($settings['site_phone'])): ?>
                        <div class="col-md-4 text-center text-white">
                            <div class="contact-item">
                                <i class="bi bi-telephone-fill display-4 mb-3"></i>
                                <h5>Telepon</h5>
                                <p><a href="tel:<?= e($settings['site_phone']) ?>" class="text-white text-decoration-none"><?= e($settings['site_phone']) ?></a></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


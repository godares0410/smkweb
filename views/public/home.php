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

<!-- Featured Posts with Dynamic Masonry Layout -->
<section id="berita" class="posts-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Berita & Pengumuman Terbaru</h2>
            <p class="section-subtitle text-muted">Informasi terkini dari sekolah kami</p>
        </div>
        
        <?php if (empty($posts)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada berita untuk ditampilkan.</p>
            </div>
        <?php else: ?>
            <!-- Dynamic Masonry Grid -->
            <div class="news-masonry-grid">
                <?php foreach ($posts as $index => $post): 
                    // Get type from database, default to landscape if not set
                    $type = $post['type'] ?? 'landscape';
                    
                    // Map type to layout class
                    $layoutClassMap = [
                        'portrait' => 'portrait-tall',
                        'landscape' => 'landscape-wide',
                        'square' => 'standard'
                    ];
                    $layoutClass = $layoutClassMap[$type] ?? 'standard';
                    
                    // Get image file
                    $imageFile = $post['foto'] ?? $post['foto_tambahan'] ?? null;
                    $imagePath = $imageFile ? 'images/berita/' . $imageFile : null;
                ?>
                    <article class="news-masonry-item <?= $layoutClass ?>" data-type="<?= e($type) ?>">
                        <a href="<?= View::url('/post/' . $post['slug']) ?>" class="news-masonry-link">
                            <div class="news-masonry-card">
                                <?php if ($imageFile): ?>
                                    <div class="news-masonry-image">
                                        <img src="<?= View::asset($imagePath) ?>" alt="<?= e($post['title']) ?>">
                                        <div class="news-masonry-overlay"></div>
                                    </div>
                                <?php endif; ?>
                                <div class="news-masonry-content">
                                    <div class="news-masonry-meta">
                                        <span class="badge bg-primary"><?= e($post['category']) ?></span>
                                        <span class="news-date">
                                            <i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($post['created_at'])) ?>
                                        </span>
                                    </div>
                                    <h3 class="news-masonry-title">
                                        <?= e($post['title']) ?>
                                    </h3>
                                    <p class="news-masonry-excerpt">
                                        <?= e($post['excerpt'] ?? substr(strip_tags($post['content']), 0, 120)) ?>
                                    </p>
                                    <span class="news-read-more">
                                        Baca selengkapnya <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Gallery Section with Modern Collage -->
<section id="galeri" class="gallery-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Galeri Kegiatan</h2>
            <p class="section-subtitle text-muted">Momen-momen terbaik dari kegiatan sekolah</p>
        </div>
        
        <?php if (empty($gallery)): ?>
            <div class="text-center py-5">
                <i class="bi bi-image display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada foto di galeri.</p>
            </div>
        <?php else: ?>
            <!-- Modern Collage Grid -->
            <div class="gallery-collage-grid">
                <?php 
                $displayGallery = array_slice($gallery, 0, 12);
                foreach ($displayGallery as $index => $item): 
                    // Get type from database, default to square if not set
                    $type = $item['type'] ?? 'square';
                    
                    // Map type to layout class
                    $layoutClassMap = [
                        'portrait' => 'portrait',
                        'landscape' => 'landscape',
                        'square' => 'square'
                    ];
                    $layoutClass = $layoutClassMap[$type] ?? 'square';
                ?>
                    <div class="gallery-collage-item <?= $layoutClass ?>" data-type="<?= e($type) ?>" data-aos="fade-up" data-aos-delay="<?= $index * 50 ?>">
                        <div class="gallery-collage-card" 
                             data-bs-toggle="modal" 
                             data-bs-target="#lightboxModal" 
                             data-bs-src="<?= View::asset('images/galeri/' . $item['image']) ?>" 
                             data-bs-title="<?= e($item['title']) ?>" 
                             data-bs-description="<?= e($item['description']) ?>">
                            <img src="<?= View::asset('images/galeri/' . $item['image']) ?>" alt="<?= e($item['title']) ?>">
                            <div class="gallery-collage-overlay">
                                <div class="gallery-collage-content">
                                    <div class="gallery-icon">
                                        <i class="bi bi-zoom-in"></i>
                                    </div>
                                    <h5 class="gallery-title"><?= e($item['title']) ?></h5>
                                    <?php if (!empty($item['description'])): ?>
                                        <p class="gallery-description"><?= e(substr($item['description'], 0, 100)) ?><?= strlen($item['description']) > 100 ? '...' : '' ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- View All Button -->
            <div class="text-center mt-5">
                <a href="<?= View::url('/gallery') ?>" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-images me-2"></i> Lihat Semua Galeri
                </a>
            </div>
        <?php endif; ?>
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

<style>
/* ===========================
   NEWS MASONRY GRID STYLES
   =========================== */
.news-masonry-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    grid-auto-flow: dense;
}

/* Layout Variations Based on Type */
.news-masonry-item.portrait-tall {
    grid-row: span 2;
}

.news-masonry-item.landscape-wide {
    grid-column: span 2;
}

.news-masonry-item.standard {
    grid-column: span 1;
    grid-row: span 1;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .news-masonry-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .news-masonry-item.landscape-wide {
        grid-column: span 2;
    }
}

@media (max-width: 768px) {
    .news-masonry-grid {
        grid-template-columns: 1fr;
    }
    
    .news-masonry-item.portrait-tall,
    .news-masonry-item.landscape-wide {
        grid-column: span 1;
        grid-row: span 1;
    }
}

/* Card Styles */
.news-masonry-link {
    display: block;
    text-decoration: none;
    color: inherit;
    height: 100%;
}

.news-masonry-card {
    position: relative;
    height: 100%;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
}

.news-masonry-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
}

/* Image Container */
.news-masonry-image {
    position: relative;
    width: 100%;
    padding-bottom: 60%;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Image Aspect Ratios Based on Type */
.portrait-tall .news-masonry-image {
    padding-bottom: 120%;
}

.landscape-wide .news-masonry-image {
    padding-bottom: 45%;
}

.standard .news-masonry-image {
    padding-bottom: 65%;
}

.news-masonry-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.news-masonry-card:hover .news-masonry-image img {
    transform: scale(1.08);
}

.news-masonry-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.news-masonry-card:hover .news-masonry-overlay {
    opacity: 1;
}

/* Content Area */
.news-masonry-content {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Content Padding Based on Type */
.standard .news-masonry-content {
    padding: 24px;
}

/* Meta Information */
.news-masonry-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

.news-masonry-meta .badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 20px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.news-date {
    font-size: 0.875rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Title */
.news-masonry-title {
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 12px;
    color: #1a1a1a;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Title Sizes Based on Type */
.portrait-tall .news-masonry-title {
    font-size: 1.4rem;
}

.landscape-wide .news-masonry-title {
    font-size: 1.3rem;
}

.standard .news-masonry-title {
    font-size: 1.25rem;
}

/* Excerpt */
.news-masonry-excerpt {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #6c757d;
    margin-bottom: 16px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex: 1;
}

/* Excerpt Based on Type */
.portrait-tall .news-masonry-excerpt {
    -webkit-line-clamp: 4;
}

.landscape-wide .news-masonry-excerpt {
    -webkit-line-clamp: 3;
}

.standard .news-masonry-excerpt {
    -webkit-line-clamp: 2;
}

/* Read More Link */
.news-read-more {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #667eea;
    font-weight: 600;
    font-size: 0.9rem;
    transition: gap 0.3s ease;
}

/* Read More Link */

.news-masonry-card:hover .news-read-more {
    gap: 10px;
}

.news-read-more i {
    transition: transform 0.3s ease;
}

.news-masonry-card:hover .news-read-more i {
    transform: translateX(4px);
}

/* ===========================
   GALLERY COLLAGE STYLES
   =========================== */

.gallery-collage-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    grid-auto-flow: dense;
}

/* Gallery Layout Variations Based on Type */
.gallery-collage-item.portrait {
    grid-column: span 1;
    grid-row: span 2;
}

.gallery-collage-item.landscape {
    grid-column: span 2;
    grid-row: span 1;
}

.gallery-collage-item.square {
    grid-column: span 1;
    grid-row: span 1;
}

/* Responsive Gallery Grid */
@media (max-width: 1200px) {
    .gallery-collage-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .gallery-collage-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .gallery-collage-item.landscape {
        grid-column: span 2;
    }
}

@media (max-width: 576px) {
    .gallery-collage-grid {
        grid-template-columns: 1fr;
    }
    
    .gallery-collage-item.portrait,
    .gallery-collage-item.landscape {
        grid-column: span 1;
        grid-row: span 1;
    }
}

/* Gallery Card Styles */
.gallery-collage-card {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 200px;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.gallery-collage-card:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    z-index: 10;
}

.gallery-collage-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.gallery-collage-card:hover img {
    transform: scale(1.1);
}

/* Gallery Overlay */
.gallery-collage-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        to bottom,
        rgba(0, 0, 0, 0) 0%,
        rgba(0, 0, 0, 0.3) 50%,
        rgba(0, 0, 0, 0.9) 100%
    );
    opacity: 0;
    transition: opacity 0.4s ease;
    display: flex;
    align-items: flex-end;
}

.gallery-collage-card:hover .gallery-collage-overlay {
    opacity: 1;
}

/* Gallery Content */
.gallery-collage-content {
    padding: 24px;
    width: 100%;
    transform: translateY(20px);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.gallery-collage-card:hover .gallery-collage-content {
    transform: translateY(0);
}

.gallery-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    transition: all 0.3s ease;
}

.gallery-collage-card:hover .gallery-icon {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.gallery-icon i {
    font-size: 1.5rem;
    color: #fff;
}

.gallery-title {
    color: #fff;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 8px;
    line-height: 1.3;
}

.gallery-description {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0;
}

/* Small items: Hide description */
.gallery-collage-item.square .gallery-description {
    display: none;
}

.gallery-collage-item.square .gallery-title {
    font-size: 0.95rem;
}

.gallery-collage-item.square .gallery-collage-content {
    padding: 16px;
}

/* Gallery Content Based on Type */
.gallery-collage-item.landscape .gallery-title {
    font-size: 1.2rem;
}

.gallery-collage-item.portrait .gallery-title {
    font-size: 1.1rem;
}

</style>
-- Add Carousel Table
USE smkweb;

-- Table: carousel
CREATE TABLE IF NOT EXISTS carousel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255) NOT NULL,
    link VARCHAR(255),
    link_text VARCHAR(100),
    order_position INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample carousel items
INSERT INTO carousel (title, description, image, link, link_text, order_position, status) VALUES
('Selamat Datang di SMK Negeri 1 Jakarta', 'Membangun Generasi Unggul Berkarakter dan Berkompetensi', 'carousel-1.jpg', '/posts', 'Lihat Berita', 1, 'active'),
('Pendaftaran Siswa Baru 2024/2025', 'Segera daftarkan diri Anda untuk menjadi bagian dari keluarga besar SMK Negeri 1 Jakarta', '/page/tentang-kami', 'Tentang Kami', 2, 'active'),
('Prestasi Gemilang di Berbagai Kompetisi', 'Tim sekolah kami terus meraih prestasi di tingkat regional dan nasional', '/gallery', 'Lihat Galeri', 3, 'active');


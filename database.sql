-- Database: smkweb
-- Membuat database jika belum ada
CREATE DATABASE IF NOT EXISTS smkweb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE smkweb;

-- Table: admins
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'super_admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pages (Halaman statis seperti About, Contact, dll)
CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT,
    excerpt TEXT,
    meta_title VARCHAR(255),
    meta_description TEXT,
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: posts (Berita/Artikel)
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT,
    excerpt TEXT,
    featured_image VARCHAR(255),
    category VARCHAR(100),
    author_id INT,
    meta_title VARCHAR(255),
    meta_description TEXT,
    status ENUM('draft', 'published') DEFAULT 'draft',
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES admins(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: gallery (Galeri foto)
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: settings (Pengaturan umum website)
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) NOT NULL UNIQUE,
    `value` TEXT,
    type VARCHAR(50) DEFAULT 'text',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- Insert default admin user (username: admin, password: admin123)
-- Password hash: password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO admins (username, email, password, name, role) VALUES
('admin', 'admin@smkweb.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'super_admin');

-- Insert default settings
INSERT INTO settings (`key`, `value`, type) VALUES
('site_name', 'SMK Web', 'text'),
('site_description', 'Website Sekolah Menengah Kejuruan', 'text'),
('site_email', 'info@smkweb.local', 'text'),
('site_phone', '+62 123 456 7890', 'text'),
('site_address', 'Jl. Contoh No. 123, Kota, Provinsi', 'text'),
('facebook_url', '', 'text'),
('twitter_url', '', 'text'),
('instagram_url', '', 'text'),
('youtube_url', '', 'text');

-- Insert sample pages
INSERT INTO pages (title, slug, content, status) VALUES
('Tentang Kami', 'tentang-kami', '<h2>Selamat Datang di SMK Web</h2><p>Ini adalah halaman tentang kami.</p>', 'published'),
('Kontak', 'kontak', '<h2>Hubungi Kami</h2><p>Silakan hubungi kami melalui informasi di bawah ini.</p>', 'published');

-- Insert sample posts
INSERT INTO posts (title, slug, content, excerpt, category, author_id, status) VALUES
('Selamat Datang di Website SMK', 'selamat-datang-di-website-smk', '<p>Ini adalah artikel pertama di website SMK.</p>', 'Artikel pertama kami', 'Berita', 1, 'published'),
('Pendaftaran Siswa Baru', 'pendaftaran-siswa-baru', '<p>Informasi tentang pendaftaran siswa baru tahun ajaran 2024/2025.</p>', 'Informasi pendaftaran', 'Pengumuman', 1, 'published');


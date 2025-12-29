<?php
/**
 * Script untuk setup folder berita dan set permission
 * Jalankan script ini sekali sebelum menggunakan download_berita_images.php
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Setup Berita Folder</title>";
echo "<style>body{font-family:Arial;padding:20px;max-width:800px;margin:0 auto;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";
echo "</head><body>";
echo "<h1>Setup Folder Berita</h1>";
echo "<hr>";

// Path folder
$imagesDir = __DIR__ . '/public/images';
$beritaDir = __DIR__ . '/public/images/berita';

$success = true;
$messages = [];

// 1. Buat folder images jika belum ada
if (!is_dir($imagesDir)) {
    if (mkdir($imagesDir, 0777, true)) {
        $messages[] = "<p class='success'>✓ Folder <code>public/images</code> berhasil dibuat</p>";
        @chmod($imagesDir, 0777);
    } else {
        $messages[] = "<p class='error'>✗ Gagal membuat folder <code>public/images</code></p>";
        $success = false;
    }
} else {
    $messages[] = "<p class='info'>Folder <code>public/images</code> sudah ada</p>";
    // Update permission ke 777 untuk memastikan bisa ditulis
    if (@chmod($imagesDir, 0777)) {
        $messages[] = "<p class='success'>✓ Permission folder <code>public/images</code> diupdate ke 777</p>";
    }
}

// 2. Buat folder berita jika belum ada
if (!is_dir($beritaDir)) {
    if (mkdir($beritaDir, 0777, true)) {
        $messages[] = "<p class='success'>✓ Folder <code>public/images/berita</code> berhasil dibuat</p>";
        @chmod($beritaDir, 0777);
    } else {
        $messages[] = "<p class='error'>✗ Gagal membuat folder <code>public/images/berita</code></p>";
        $success = false;
    }
} else {
    $messages[] = "<p class='info'>Folder <code>public/images/berita</code> sudah ada</p>";
    // Update permission ke 777 untuk memastikan bisa ditulis
    if (@chmod($beritaDir, 0777)) {
        $messages[] = "<p class='success'>✓ Permission folder <code>public/images/berita</code> diupdate ke 777</p>";
    }
}

// 3. Cek apakah folder writable
if (is_dir($beritaDir)) {
    if (is_writable($beritaDir)) {
        $messages[] = "<p class='success'>✓ Folder <code>public/images/berita</code> dapat ditulis (writable)</p>";
    } else {
        $messages[] = "<p class='error'>✗ Folder <code>public/images/berita</code> TIDAK dapat ditulis</p>";
        $messages[] = "<p class='info'><strong>Solusi:</strong> Jalankan perintah berikut di terminal:</p>";
        $messages[] = "<pre style='background:#f0f0f0;padding:10px;border-radius:5px;'>chmod 755 " . escapeshellarg($beritaDir) . "</pre>";
        $messages[] = "<p class='info'>Atau jika masih gagal, coba:</p>";
        $messages[] = "<pre style='background:#f0f0f0;padding:10px;border-radius:5px;'>chmod 777 " . escapeshellarg($beritaDir) . "</pre>";
        $success = false;
    }
}

// Tampilkan semua pesan
foreach ($messages as $message) {
    echo $message;
}

echo "<hr>";

if ($success) {
    echo "<h2 class='success'>✓ Setup Berhasil!</h2>";
    echo "<p>Folder berita sudah siap digunakan. Silakan lanjutkan ke:</p>";
    echo "<p><a href='download_berita_images.php' class='btn' style='display:inline-block;padding:10px 20px;background:#2563eb;color:white;text-decoration:none;border-radius:5px;'>Download Foto Berita</a></p>";
} else {
    echo "<h2 class='error'>⚠ Ada Masalah</h2>";
    echo "<p>Silakan perbaiki masalah permission di atas, lalu refresh halaman ini.</p>";
}

// Test write dengan membuat file test
if (is_dir($beritaDir) && is_writable($beritaDir)) {
    $testFile = $beritaDir . '/.test_write';
    if (@file_put_contents($testFile, 'test')) {
        unlink($testFile);
        echo "<p class='success'>✓ Test write berhasil: folder dapat digunakan untuk menyimpan file</p>";
    } else {
        echo "<p class='error'>✗ Test write gagal: folder tidak dapat digunakan untuk menyimpan file</p>";
    }
}

echo "<hr>";
echo "<p><a href='index.php'>Kembali ke Website</a> | <a href='admin/login'>Login Admin</a></p>";
echo "</body></html>";
?>


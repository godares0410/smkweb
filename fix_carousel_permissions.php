<?php
/**
 * Script untuk memperbaiki permission folder carousel
 */

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Fix Carousel Permissions</title>";
echo "<style>body{font-family:Arial;padding:20px;max-width:600px;margin:0 auto;} .success{color:green;} .error{color:red;}</style>";
echo "</head><body>";
echo "<h1>Fix Carousel Folder Permissions</h1>";

$carouselDir = __DIR__ . '/public/images/carousel/';

// Buat folder jika belum ada
if (!is_dir($carouselDir)) {
    if (mkdir($carouselDir, 0777, true)) {
        echo "<p class='success'>✓ Folder carousel berhasil dibuat</p>";
    } else {
        echo "<p class='error'>✗ Gagal membuat folder carousel</p>";
        echo "</body></html>";
        exit;
    }
}

// Cek permission saat ini
$currentPerms = fileperms($carouselDir);
$currentPermsOct = substr(sprintf('%o', $currentPerms), -4);

echo "<p>Permission saat ini: <strong>{$currentPermsOct}</strong></p>";

// Coba ubah permission
if (@chmod($carouselDir, 0777)) {
    echo "<p class='success'>✓ Permission berhasil diubah ke 777</p>";
} else {
    echo "<p class='error'>✗ Gagal mengubah permission secara otomatis</p>";
    echo "<p>Silakan jalankan manual via terminal:</p>";
    echo "<pre>chmod 777 public/images/carousel</pre>";
    echo "</body></html>";
    exit;
}

// Verifikasi apakah folder bisa ditulis
if (is_writable($carouselDir)) {
    echo "<p class='success'>✓ Folder <strong>carousel</strong> sekarang dapat ditulis</p>";
    
    // Test write
    $testFile = $carouselDir . 'test_write.txt';
    if (@file_put_contents($testFile, 'test')) {
        @unlink($testFile);
        echo "<p class='success'>✓ Test write berhasil</p>";
        echo "<p class='success'><strong>Permission sudah benar! Anda bisa menjalankan script download carousel images sekarang.</strong></p>";
    } else {
        echo "<p class='error'>✗ Test write gagal</p>";
    }
} else {
    echo "<p class='error'>✗ Folder masih tidak dapat ditulis</p>";
    echo "<p>Silakan jalankan via terminal dengan sudo:</p>";
    echo "<pre>sudo chmod -R 777 public/images/carousel</pre>";
}

echo "<hr>";
echo "<h3>Langkah Selanjutnya</h3>";
echo "<ul>";
echo "<li><a href='download_carousel_images.php'>Download gambar carousel</a></li>";
echo "<li><a href='admin/login'>Login Admin untuk upload carousel</a></li>";
echo "<li><a href='index.php'>Kembali ke Website</a></li>";
echo "</ul>";

echo "</body></html>";
?>


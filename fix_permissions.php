<?php
/**
 * Script untuk memperbaiki permission folder uploads
 * Jalankan script ini jika ada masalah permission
 */

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Fix Permissions</title>";
echo "<style>body{font-family:Arial;padding:20px;max-width:600px;margin:0 auto;} .success{color:green;} .error{color:red;}</style>";
echo "</head><body>";
echo "<h1>Fix Folder Permissions</h1>";

$uploadDir = __DIR__ . '/public/uploads/';

// Buat folder jika belum ada
if (!is_dir($uploadDir)) {
    if (mkdir($uploadDir, 0777, true)) {
        echo "<p class='success'>✓ Folder uploads berhasil dibuat</p>";
    } else {
        echo "<p class='error'>✗ Gagal membuat folder uploads</p>";
        echo "</body></html>";
        exit;
    }
}

// Cek permission saat ini
$currentPerms = fileperms($uploadDir);
$currentPermsOct = substr(sprintf('%o', $currentPerms), -4);

echo "<p>Permission saat ini: <strong>{$currentPermsOct}</strong></p>";

// Coba ubah permission ke 755
if (@chmod($uploadDir, 0755)) {
    echo "<p class='success'>✓ Permission berhasil diubah ke 755</p>";
} else {
    echo "<p class='error'>✗ Gagal mengubah permission (coba dengan 777)...</p>";
    // Coba dengan 777
    if (@chmod($uploadDir, 0777)) {
        echo "<p class='success'>✓ Permission berhasil diubah ke 777</p>";
    } else {
        echo "<p class='error'>✗ Gagal mengubah permission secara otomatis</p>";
        echo "<p>Silakan jalankan manual via terminal:</p>";
        echo "<pre>chmod 755 public/uploads</pre>";
        echo "<p>atau</p>";
        echo "<pre>chmod 777 public/uploads</pre>";
        echo "</body></html>";
        exit;
    }
}

// Verifikasi apakah folder bisa ditulis
if (is_writable($uploadDir)) {
    echo "<p class='success'>✓ Folder <strong>uploads</strong> sekarang dapat ditulis</p>";
    
    // Test write
    $testFile = $uploadDir . 'test_write.txt';
    if (@file_put_contents($testFile, 'test')) {
        @unlink($testFile);
        echo "<p class='success'>✓ Test write berhasil</p>";
        echo "<p class='success'><strong>Permission sudah benar! Anda bisa menjalankan script download gambar sekarang.</strong></p>";
    } else {
        echo "<p class='error'>✗ Test write gagal</p>";
        echo "<p>Masalah masih ada. Coba jalankan via terminal:</p>";
        echo "<pre>sudo chmod -R 777 public/uploads</pre>";
    }
} else {
    echo "<p class='error'>✗ Folder masih tidak dapat ditulis</p>";
    echo "<p>Silakan jalankan via terminal dengan sudo:</p>";
    echo "<pre>sudo chmod -R 777 public/uploads</pre>";
}

echo "<hr>";
echo "<h3>Langkah Selanjutnya</h3>";
echo "<ul>";
echo "<li><a href='create_dummy_images.php'>Buat gambar dummy lokal (Recommended)</a></li>";
echo "<li><a href='download_dummy_images.php'>Download gambar dari internet</a></li>";
echo "<li><a href='index.php'>Kembali ke Website</a></li>";
echo "</ul>";

echo "</body></html>";
?>


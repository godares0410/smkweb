<?php
/**
 * Script alternatif: Membuat gambar dummy secara lokal menggunakan GD Library
 * Script ini TIDAK memerlukan koneksi internet
 */

// Cek GD Library
if (!function_exists('imagecreate')) {
    die("Error: GD Library tidak tersedia. Silakan aktifkan extension GD di php.ini\n");
}

// Direktori upload
$uploadDir = __DIR__ . '/public/uploads/';

// Buat direktori jika belum ada
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Error: Tidak bisa membuat folder uploads.\n");
    }
}

// Cek apakah folder writable
if (!is_writable($uploadDir)) {
    die("Error: Folder uploads tidak bisa ditulis. Jalankan: chmod 755 public/uploads\n");
}

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Create Dummy Images</title>";
echo "<style>body{font-family:Arial;padding:20px;max-width:800px;margin:0 auto;} .success{color:green;}</style>";
echo "</head><body>";
echo "<h1>Membuat Dummy Images Lokal</h1>";
echo "<p>Script ini akan membuat gambar dummy secara lokal tanpa memerlukan internet.</p><hr>";

$images = [
    ['name' => 'dummy-1.jpg', 'text' => 'Upacara Bendera', 'color' => [102, 126, 234]],
    ['name' => 'dummy-2.jpg', 'text' => 'Praktik TKJ', 'color' => [118, 75, 162]],
    ['name' => 'dummy-3.jpg', 'text' => 'Projek P5', 'color' => [102, 126, 234]],
    ['name' => 'dummy-4.jpg', 'text' => 'Kunjungan Industri', 'color' => [118, 75, 162]],
    ['name' => 'dummy-5.jpg', 'text' => 'Workshop Laravel', 'color' => [102, 126, 234]],
    ['name' => 'dummy-6.jpg', 'text' => 'Penghargaan', 'color' => [118, 75, 162]],
    ['name' => 'dummy-7.jpg', 'text' => 'Futsal', 'color' => [102, 126, 234]],
    ['name' => 'dummy-8.jpg', 'text' => 'Praktik Akuntansi', 'color' => [118, 75, 162]],
    ['name' => 'dummy-9.jpg', 'text' => 'Bazar Sekolah', 'color' => [102, 126, 234]],
    ['name' => 'dummy-10.jpg', 'text' => 'Tim Basket', 'color' => [118, 75, 162]],
    ['name' => 'dummy-11.jpg', 'text' => 'Multimedia', 'color' => [102, 126, 234]],
    ['name' => 'dummy-12.jpg', 'text' => 'Pramuka', 'color' => [118, 75, 162]],
];

$width = 800;
$height = 600;
$success = 0;
$skipped = 0;

foreach ($images as $img) {
    $filePath = $uploadDir . $img['name'];
    
    // Skip jika file sudah ada
    if (file_exists($filePath) && filesize($filePath) > 0) {
        echo "<p class='info'>File <strong>{$img['name']}</strong> sudah ada, melewati...</p>";
        $skipped++;
        continue;
    }
    
    echo "<p>Membuat <strong>{$img['name']}</strong>...</p>";
    
    // Buat image
    $image = imagecreatetruecolor($width, $height);
    
    // Allocate colors
    $bgColor = imagecolorallocate($image, $img['color'][0], $img['color'][1], $img['color'][2]);
    $textColor = imagecolorallocate($image, 255, 255, 255);
    $shadowColor = imagecolorallocate($image, 0, 0, 0);
    
    // Fill background dengan gradient
    imagefill($image, 0, 0, $bgColor);
    
    // Buat gradient effect (simple)
    for ($i = 0; $i < $height; $i++) {
        $ratio = $i / $height;
        $r = min(255, $img['color'][0] + ($ratio * 20));
        $g = min(255, $img['color'][1] + ($ratio * 20));
        $b = min(255, $img['color'][2] + ($ratio * 20));
        $gradColor = imagecolorallocate($image, $r, $g, $b);
        imageline($image, 0, $i, $width, $i, $gradColor);
    }
    
    // Cek apakah font tersedia
    $fontPath = __DIR__ . '/arial.ttf'; // Coba cari font TrueType
    $useTTF = file_exists($fontPath);
    
    if ($useTTF && function_exists('imagettftext')) {
        // Gunakan TrueType font jika tersedia
        $fontSize = 48;
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $img['text']);
        $textWidth = $bbox[4] - $bbox[0];
        $textHeight = $bbox[5] - $bbox[1];
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2 + $textHeight;
        
        // Text shadow
        imagettftext($image, $fontSize, 0, $x + 3, $y + 3, $shadowColor, $fontPath, $img['text']);
        // Text
        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $img['text']);
    } else {
        // Gunakan built-in font
        $fontSize = 5;
        $textWidth = imagefontwidth($fontSize) * strlen($img['text']);
        $textHeight = imagefontheight($fontSize);
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;
        
        // Text shadow
        imagestring($image, $fontSize, $x + 2, $y + 2, $img['text'], $shadowColor);
        // Text
        imagestring($image, $fontSize, $x, $y, $img['text'], $textColor);
    }
    
    // Simpan sebagai JPEG
    if (imagejpeg($image, $filePath, 90)) {
        echo "<p class='success'>✓ Berhasil membuat {$img['name']}</p>";
        $success++;
    } else {
        echo "<p style='color:red;'>✗ Gagal membuat {$img['name']}</p>";
    }
    
    imagedestroy($image);
}

echo "<hr>";
echo "<h2>Ringkasan</h2>";
echo "<p class='success'><strong>Berhasil:</strong> {$success} gambar</p>";
if ($skipped > 0) {
    echo "<p class='info'><strong>Dilewati:</strong> {$skipped} gambar (sudah ada)</p>";
}
echo "<p class='success'><strong>✓ Proses selesai! Total gambar tersedia: " . ($success + $skipped) . "</strong></p>";
echo "<p><a href='index.php'>Kembali ke Website</a> | <a href='admin/login'>Login Admin</a></p>";
echo "</body></html>";
?>


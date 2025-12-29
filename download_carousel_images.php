<?php
/**
 * Script untuk download gambar carousel dummy
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

$uploadDir = __DIR__ . '/public/images/carousel/';

if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Error: Tidak bisa membuat folder carousel.\n");
    }
}

if (!is_writable($uploadDir)) {
    // Try to fix permission
    @chmod($uploadDir, 0777);
    if (!is_writable($uploadDir)) {
        die("Error: Folder carousel tidak bisa ditulis. Silakan jalankan: chmod 777 public/images/carousel\n");
    }
}

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Download Carousel Images</title>";
echo "<style>body{font-family:Arial;padding:20px;max-width:800px;margin:0 auto;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";
echo "</head><body>";
echo "<h1>Download Carousel Images</h1>";
echo "<p>Sedang mendownload gambar carousel...</p>";
echo "<hr>";

// URL gambar carousel - menggunakan placeholder.com
$images = [
    ['url' => 'https://via.placeholder.com/1920x800/667eea/ffffff?text=Selamat+Datang', 'name' => 'carousel-1.jpg'],
    ['url' => 'https://via.placeholder.com/1920x800/764ba2/ffffff?text=Pendaftaran+PPDB+2024', 'name' => 'carousel-2.jpg'],
    ['url' => 'https://via.placeholder.com/1920x800/667eea/ffffff?text=Prestasi+Gemilang', 'name' => 'carousel-3.jpg'],
];

function downloadWithCurl($url, $filePath) {
    if (!function_exists('curl_init')) {
        return false;
    }
    
    $ch = curl_init($url);
    $fp = fopen($filePath, 'wb');
    
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    fclose($fp);
    
    if ($error) {
        return ['success' => false, 'error' => $error];
    }
    
    return ['success' => ($result && $httpCode == 200), 'httpCode' => $httpCode];
}

function createDummyCarouselImage($filePath, $text, $width = 1920, $height = 800) {
    if (!function_exists('imagecreate')) {
        return false;
    }
    
    $bgColor = [102, 126, 234]; // #667eea
    
    $img = imagecreatetruecolor($width, $height);
    $bg = imagecolorallocate($img, $bgColor[0], $bgColor[1], $bgColor[2]);
    $textColor = imagecolorallocate($img, 255, 255, 255);
    
    imagefill($img, 0, 0, $bg);
    
    // Gradient effect
    for ($i = 0; $i < $height; $i++) {
        $ratio = $i / $height;
        $r = min(255, $bgColor[0] + ($ratio * 20));
        $g = min(255, $bgColor[1] + ($ratio * 20));
        $b = min(255, $bgColor[2] + ($ratio * 20));
        $gradColor = imagecolorallocate($img, $r, $g, $b);
        imageline($img, 0, $i, $width, $i, $gradColor);
    }
    
    $fontSize = 5;
    $textWidth = imagefontwidth($fontSize) * strlen($text);
    $textHeight = imagefontheight($fontSize);
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    imagestring($img, $fontSize, $x, $y, $text, $textColor);
    
    $result = imagejpeg($img, $filePath, 90);
    imagedestroy($img);
    
    return $result;
}

$success = 0;
$failed = 0;
$hasCurl = function_exists('curl_init');
$hasGD = function_exists('imagecreate');

echo "<p class='info'>Extension: " . ($hasCurl ? "cURL ✓ " : "cURL ✗ ") . ($hasGD ? "GD ✓" : "GD ✗") . "</p><hr>";

foreach ($images as $img) {
    $filePath = $uploadDir . $img['name'];
    
    if (file_exists($filePath) && filesize($filePath) > 0) {
        echo "<p class='info'>File <strong>{$img['name']}</strong> sudah ada, melewati...</p>";
        continue;
    }
    
    echo "<p>Downloading <strong>{$img['name']}</strong>...</p>";
    flush();
    
    $downloaded = false;
    
    if ($hasCurl) {
        $result = downloadWithCurl($img['url'], $filePath);
        if ($result && $result['success'] && file_exists($filePath) && filesize($filePath) > 1000) {
            echo "<p class='success'>✓ Berhasil download {$img['name']}</p>";
            $downloaded = true;
            $success++;
        } else {
            if (file_exists($filePath)) unlink($filePath);
        }
    }
    
    if (!$downloaded && $hasGD) {
        $text = str_replace(['carousel-', '.jpg', '-'], ['', '', ' '], $img['name']);
        if (createDummyCarouselImage($filePath, $text)) {
            echo "<p class='success'>✓ Berhasil membuat {$img['name']} (GD)</p>";
            $downloaded = true;
            $success++;
        }
    }
    
    if (!$downloaded) {
        echo "<p class='error'>✗ Gagal download {$img['name']}</p>";
        $failed++;
    }
    
    usleep(500000);
}

echo "<hr><h2>Ringkasan</h2>";
echo "<p class='success'><strong>Berhasil:</strong> {$success} gambar</p>";
if ($failed > 0) {
    echo "<p class='error'><strong>Gagal:</strong> {$failed} gambar</p>";
}
echo "<p><a href='index.php'>Kembali ke Website</a></p>";
echo "</body></html>";
?>


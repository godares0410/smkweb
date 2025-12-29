<?php
/**
 * Script untuk download gambar dummy dari placeholder services
 * Jalankan script ini sekali untuk mendownload semua gambar dummy
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set time limit
set_time_limit(300);

// Direktori upload
$uploadDir = __DIR__ . '/public/uploads/';

// Buat direktori jika belum ada
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Error: Tidak bisa membuat folder uploads. Pastikan permission folder public/ adalah 755 atau 777.\n");
    }
}

// Cek apakah folder writable
if (!is_writable($uploadDir)) {
    die("Error: Folder uploads tidak bisa ditulis. Jalankan: chmod 755 public/uploads\n");
}

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Download Dummy Images</title>";
echo "<style>body{font-family:Arial;padding:20px;max-width:800px;margin:0 auto;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";
echo "</head><body>";
echo "<h1>Download Dummy Images</h1>";
echo "<p>Sedang mendownload gambar dummy...</p>";
echo "<hr>";

// URL gambar dummy - menggunakan placeholder.com sebagai primary
$images = [
    ['url' => 'https://via.placeholder.com/800x600/667eea/ffffff?text=Upacara+Bendera', 'name' => 'dummy-1.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/764ba2/ffffff?text=Praktik+TKJ', 'name' => 'dummy-2.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/667eea/ffffff?text=Projek+P5', 'name' => 'dummy-3.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/764ba2/ffffff?text=Kunjungan+Industri', 'name' => 'dummy-4.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/667eea/ffffff?text=Workshop+Laravel', 'name' => 'dummy-5.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/764ba2/ffffff?text=Penghargaan', 'name' => 'dummy-6.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/667eea/ffffff?text=Futsal', 'name' => 'dummy-7.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/764ba2/ffffff?text=Praktik+Akuntansi', 'name' => 'dummy-8.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/667eea/ffffff?text=Bazar+Sekolah', 'name' => 'dummy-9.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/764ba2/ffffff?text=Tim+Basket', 'name' => 'dummy-10.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/667eea/ffffff?text=Multimedia', 'name' => 'dummy-11.jpg'],
    ['url' => 'https://via.placeholder.com/800x600/764ba2/ffffff?text=Pramuka', 'name' => 'dummy-12.jpg'],
];

// Alternative: Picsum Photos
$imagesPicsum = [
    ['url' => 'https://picsum.photos/800/600?random=1', 'name' => 'dummy-1.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=2', 'name' => 'dummy-2.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=3', 'name' => 'dummy-3.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=4', 'name' => 'dummy-4.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=5', 'name' => 'dummy-5.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=6', 'name' => 'dummy-6.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=7', 'name' => 'dummy-7.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=8', 'name' => 'dummy-8.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=9', 'name' => 'dummy-9.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=10', 'name' => 'dummy-10.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=11', 'name' => 'dummy-11.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=12', 'name' => 'dummy-12.jpg'],
];

// Function untuk download dengan cURL
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
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
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

// Function untuk download dengan file_get_contents
function downloadWithFileGetContents($url, $filePath) {
    if (!ini_get('allow_url_fopen')) {
        return false;
    }
    
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n",
            'timeout' => 30,
            'follow_location' => 1,
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ]
    ]);
    
    $data = @file_get_contents($url, false, $context);
    
    if ($data === false) {
        return false;
    }
    
    return file_put_contents($filePath, $data) !== false;
}

// Function untuk create dummy image
function createDummyImage($filePath, $text, $width = 800, $height = 600) {
    // Cek apakah GD library tersedia
    if (!function_exists('imagecreate')) {
        return false;
    }
    
    $bgColor = [102, 126, 234]; // #667eea
    $textColor = [255, 255, 255];
    
    $img = imagecreatetruecolor($width, $height);
    $bg = imagecolorallocate($img, $bgColor[0], $bgColor[1], $bgColor[2]);
    $text = imagecolorallocate($img, $textColor[0], $textColor[1], $textColor[2]);
    
    imagefill($img, 0, 0, $bg);
    
    // Tambahkan teks (perlu font, jika tidak ada gunakan built-in font)
    $fontSize = 5;
    $textWidth = imagefontwidth($fontSize) * strlen($text);
    $textHeight = imagefontheight($fontSize);
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    imagestring($img, $fontSize, $x, $y, $text, $text);
    
    $result = imagejpeg($img, $filePath, 85);
    imagedestroy($img);
    
    return $result;
}

$success = 0;
$failed = 0;
$skipped = 0;

// Cek extension yang tersedia
$hasCurl = function_exists('curl_init');
$hasFileGetContents = ini_get('allow_url_fopen');
$hasGD = function_exists('imagecreate');

echo "<p class='info'>Extension tersedia: ";
echo ($hasCurl ? "cURL ✓ " : "cURL ✗ ");
echo ($hasFileGetContents ? "file_get_contents ✓ " : "file_get_contents ✗ ");
echo ($hasGD ? "GD ✓ " : "GD ✗ ");
echo "</p><hr>";

// Loop untuk setiap gambar
foreach ($images as $img) {
    $filePath = $uploadDir . $img['name'];
    $fileName = $img['name'];
    
    // Skip jika file sudah ada
    if (file_exists($filePath) && filesize($filePath) > 0) {
        echo "<p class='info'>File <strong>{$fileName}</strong> sudah ada, melewati...</p>";
        $skipped++;
        continue;
    }
    
    echo "<p>Downloading <strong>{$fileName}</strong>...</p>";
    flush();
    ob_flush();
    
    $downloaded = false;
    $lastError = '';
    
    // Method 1: Coba dengan cURL
    if ($hasCurl) {
        $result = downloadWithCurl($img['url'], $filePath);
        if ($result && $result['success'] && file_exists($filePath) && filesize($filePath) > 1000) {
            echo "<p class='success'>✓ Berhasil download {$fileName} (cURL)</p>";
            $downloaded = true;
            $success++;
        } else {
            if (file_exists($filePath)) unlink($filePath);
            if (isset($result['error'])) {
                $lastError = $result['error'];
            }
        }
    }
    
    // Method 2: Coba dengan file_get_contents jika cURL gagal
    if (!$downloaded && $hasFileGetContents) {
        if (downloadWithFileGetContents($img['url'], $filePath) && file_exists($filePath) && filesize($filePath) > 1000) {
            echo "<p class='success'>✓ Berhasil download {$fileName} (file_get_contents)</p>";
            $downloaded = true;
            $success++;
        } else {
            if (file_exists($filePath)) unlink($filePath);
        }
    }
    
    // Method 3: Coba dengan Picsum Photos sebagai alternatif
    if (!$downloaded) {
        $picsumIndex = array_search($fileName, array_column($imagesPicsum, 'name'));
        if ($picsumIndex !== false && $hasCurl) {
            echo "<p class='info'>Mencoba sumber alternatif untuk {$fileName}...</p>";
            $result = downloadWithCurl($imagesPicsum[$picsumIndex]['url'], $filePath);
            if ($result && $result['success'] && file_exists($filePath) && filesize($filePath) > 1000) {
                echo "<p class='success'>✓ Berhasil download {$fileName} (Picsum Photos)</p>";
                $downloaded = true;
                $success++;
            } else {
                if (file_exists($filePath)) unlink($filePath);
            }
        }
    }
    
    // Method 4: Buat dummy image dengan GD jika semua gagal
    if (!$downloaded && $hasGD) {
        $text = str_replace(['.jpg', 'dummy-', '-'], ['', '', ' '], $fileName);
        if (createDummyImage($filePath, $text)) {
            echo "<p class='success'>✓ Berhasil membuat dummy image {$fileName} (GD Library)</p>";
            $downloaded = true;
            $success++;
        }
    }
    
    // Jika semua method gagal
    if (!$downloaded) {
        echo "<p class='error'>✗ Gagal download {$fileName}";
        if ($lastError) {
            echo " - Error: {$lastError}";
        }
        echo "</p>";
        $failed++;
    }
    
    // Delay kecil
    usleep(500000); // 0.5 detik
}

echo "<hr>";
echo "<h2>Ringkasan</h2>";
echo "<p class='success'><strong>Berhasil:</strong> {$success} gambar</p>";
if ($skipped > 0) {
    echo "<p class='info'><strong>Dilewati:</strong> {$skipped} gambar (sudah ada)</p>";
}
if ($failed > 0) {
    echo "<p class='error'><strong>Gagal:</strong> {$failed} gambar</p>";
}

if ($success > 0 || $skipped > 0) {
    echo "<p class='success'><strong>✓ Proses selesai! Total gambar tersedia: " . ($success + $skipped) . "</strong></p>";
    echo "<p><a href='index.php'>Kembali ke Website</a> | <a href='admin/login'>Login Admin</a></p>";
} else {
    echo "<p class='error'><strong>⚠ Tidak ada gambar yang berhasil didownload.</strong></p>";
    echo "<h3>Solusi:</h3>";
    echo "<ul>";
    echo "<li>Pastikan koneksi internet aktif</li>";
    echo "<li>Pastikan folder <code>public/uploads</code> memiliki permission write (chmod 755 atau 777)</li>";
    echo "<li>Cek apakah cURL atau file_get_contents aktif di PHP</li>";
    echo "<li>Download manual dari: <a href='https://via.placeholder.com/800x600/667eea/ffffff?text=Image' target='_blank'>placeholder.com</a></li>";
    echo "</ul>";
}

echo "</body></html>";
?>

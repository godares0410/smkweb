<?php
/**
 * Script untuk download gambar berita dummy ke folder images/berita
 * Jalankan script ini sekali untuk mendownload semua gambar berita dummy
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set time limit
set_time_limit(300);

// Direktori untuk menyimpan gambar berita
$imagesDir = __DIR__ . '/public/images';
$beritaDir = __DIR__ . '/public/images/berita/';

// Buat direktori images jika belum ada
if (!is_dir($imagesDir)) {
    if (!mkdir($imagesDir, 0777, true)) {
        echo "<p class='error'>Error: Tidak bisa membuat folder <code>public/images</code>. Pastikan permission folder <code>public/</code> adalah 755 atau 777.</p>";
        echo "<p><a href='setup_berita_folder.php'>Klik di sini untuk setup folder otomatis</a></p>";
        echo "</body></html>";
        exit;
    }
    @chmod($imagesDir, 0777);
}

// Buat direktori berita jika belum ada
if (!is_dir($beritaDir)) {
    if (!mkdir($beritaDir, 0777, true)) {
        echo "<p class='error'>Error: Tidak bisa membuat folder <code>public/images/berita</code>. Pastikan permission folder <code>public/images/</code> adalah 755 atau 777.</p>";
        echo "<p><a href='setup_berita_folder.php'>Klik di sini untuk setup folder otomatis</a></p>";
        echo "</body></html>";
        exit;
    }
    @chmod($beritaDir, 0777);
}

// Pastikan folder writable, coba ubah permission jika perlu
if (!is_writable($beritaDir)) {
    // Coba ubah permission ke 777
    @chmod($beritaDir, 0777);
    
    // Cek lagi
    if (!is_writable($beritaDir)) {
        echo "<p class='error'>Error: Folder <code>public/images/berita</code> tidak bisa ditulis setelah mencoba mengubah permission.</p>";
        echo "<p class='info'><strong>Solusi Manual:</strong></p>";
        echo "<ul>";
        echo "<li>Jalankan perintah di terminal: <code>chmod 777 " . htmlspecialchars($beritaDir) . "</code></li>";
        echo "<li>Atau jalankan: <a href='setup_berita_folder.php'>setup_berita_folder.php</a></li>";
        echo "</ul>";
        echo "</body></html>";
        exit;
    }
}

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Download Berita Images</title>";
echo "<style>body{font-family:Arial;padding:20px;max-width:800px;margin:0 auto;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";
echo "</head><body>";
echo "<h1>Download Berita Images</h1>";
echo "<p>Sedang mendownload gambar berita dummy...</p>";
echo "<hr>";

// URL gambar berita dummy - menggunakan Unsplash sebagai sumber
$images = [
    ['url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop', 'name' => 'berita-1.jpg'], // Education
    ['url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&h=600&fit=crop', 'name' => 'berita-2.jpg'], // School
    ['url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop', 'name' => 'berita-3.jpg'], // Sports
    ['url' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop', 'name' => 'berita-4.jpg'], // Workshop
    ['url' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=800&h=600&fit=crop', 'name' => 'berita-5.jpg'], // Industry
    ['url' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=800&h=600&fit=crop', 'name' => 'berita-6.jpg'], // Meeting
];

// Alternative: Picsum Photos sebagai fallback
$imagesPicsum = [
    ['url' => 'https://picsum.photos/800/600?random=101', 'name' => 'berita-1.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=102', 'name' => 'berita-2.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=103', 'name' => 'berita-3.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=104', 'name' => 'berita-4.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=105', 'name' => 'berita-5.jpg'],
    ['url' => 'https://picsum.photos/800/600?random=106', 'name' => 'berita-6.jpg'],
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

// Function untuk create dummy image dengan GD
function createDummyImage($filePath, $text, $width = 800, $height = 600) {
    if (!function_exists('imagecreate')) {
        return false;
    }
    
    $bgColor = [37, 99, 235]; // #2563eb (primary color)
    $textColor = [255, 255, 255];
    
    $img = imagecreatetruecolor($width, $height);
    $bg = imagecolorallocate($img, $bgColor[0], $bgColor[1], $bgColor[2]);
    $text = imagecolorallocate($img, $textColor[0], $textColor[1], $textColor[2]);
    
    imagefill($img, 0, 0, $bg);
    
    // Tambahkan teks
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
    $filePath = $beritaDir . $img['name'];
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
        $text = str_replace(['.jpg', 'berita-', '-'], ['', '', ' '], $fileName);
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
    echo "<li>Pastikan folder <code>public/images/berita</code> memiliki permission write (chmod 755 atau 777)</li>";
    echo "<li>Cek apakah cURL atau file_get_contents aktif di PHP</li>";
    echo "</ul>";
}

echo "</body></html>";
?>


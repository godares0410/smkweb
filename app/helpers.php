<?php

function getBasePath() {
    static $basePath = null;
    
    if ($basePath !== null) {
        return $basePath;
    }
    
    if (file_exists(__DIR__ . '/../config/app.php')) {
        $config = require __DIR__ . '/../config/app.php';
        if (isset($config['url'])) {
            $url = parse_url($config['url'], PHP_URL_PATH);
            if ($url && $url !== '/') {
                $basePath = rtrim($url, '/');
                return $basePath;
            }
        }
    }
    
    if (isset($_SERVER['SCRIPT_NAME'])) {
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptDir === '/' || $scriptDir === '\\') {
            $basePath = '';
        } else {
            $basePath = $scriptDir;
        }
    } else {
        $basePath = '/smkweb';
    }
    
    return $basePath;
}

function asset($path) {
    $path = ltrim($path, '/');
    $basePath = getBasePath();
    return $basePath . '/public/' . $path;
}

function url($path = '') {
    $basePath = getBasePath();
    return $basePath . ($path ? '/' . ltrim($path, '/') : '');
}

function route($name, $params = []) {
    return url($name);
}

function auth() {
    return Auth::user();
}

function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function old($key, $default = '') {
    return $_SESSION['old'][$key] ?? $default;
}

function flash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}

function errors() {
    return $_SESSION['flash']['errors'] ?? [];
}

function hasErrors() {
    return !empty($_SESSION['flash']['errors'] ?? []);
}

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function getBeritaImages() {
    $beritaDir = __DIR__ . '/../public/images/berita/';
    $images = [];
    
    if (is_dir($beritaDir)) {
        $files = scandir($beritaDir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && is_file($beritaDir . $file)) {
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $images[] = $file;
                }
            }
        }
        sort($images);
    }
    
    return $images;
}


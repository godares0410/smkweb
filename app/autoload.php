<?php

spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/';
    
    // Try direct file first (for classes like Router, Auth, etc.)
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return;
    }
    
    // For controller classes, check if we're in admin route
    // If so, try Admin folder first to avoid loading wrong controller
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
    $uri = parse_url($requestUri, PHP_URL_PATH);
    $isAdminRoute = strpos($uri, '/admin/') === 0;
    
    // Try Controllers folder (handle namespaces)
    if ($isAdminRoute && strpos($class, 'Controller') !== false) {
        // For admin routes, try Admin folder first
        $adminFile = $baseDir . 'Controllers/Admin/' . str_replace('\\', '/', $class) . '.php';
        if (file_exists($adminFile)) {
            require $adminFile;
            return;
        }
    }
    
    $file = $baseDir . 'Controllers/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return;
    }
    
    // Try Models folder
    $file = $baseDir . 'Models/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return;
    }
});

// Load core classes first
require __DIR__ . '/Database.php';
require __DIR__ . '/Auth.php';
require __DIR__ . '/Router.php';
require __DIR__ . '/View.php';
require __DIR__ . '/Request.php';
require __DIR__ . '/Response.php';

// Load helpers
require __DIR__ . '/helpers.php';


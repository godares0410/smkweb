<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Start output buffering
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if (!$isAjax) {
    ob_start();
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load autoloader
require_once __DIR__ . '/app/autoload.php';

// Load routes
$router = require __DIR__ . '/routes/web.php';

// Define AJAX flag globally
define('IS_AJAX', $isAjax);

// Dispatch request
try {
    $router->dispatch();
} catch (Exception $e) {
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    
    error_log("Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    
    if ($isAjax) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false, 
            'message' => 'Internal Server Error: ' . $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(500);
        echo "<h1>500 Internal Server Error</h1>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
        echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    }
    exit;
}


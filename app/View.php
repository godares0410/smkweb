<?php

class View {
    public static function render($view, $data = []) {
        $viewFile = __DIR__ . '/../views/' . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewFile)) {
            die("View not found: {$view}");
        }
        
        // Load settings if not already provided (for layout access)
        if (!isset($data['settings'])) {
            try {
                $settingModel = new Setting();
                $data['settings'] = $settingModel->getAll();
            } catch (Exception $e) {
                $data['settings'] = [];
            }
        }
        
        // Set default layout if not specified in data
        $layoutName = $data['layout'] ?? 'app';
        $noLayout = $data['noLayout'] ?? false;
        
        // Check if layout is needed
        if (!$noLayout) {
            // Extract data so variables are available in view
            extract($data);
            // Initialize layout variable (may be overridden in view)
            $layout = $layoutName;
            
            // Capture view output - view can set $layout variable
            ob_start();
            include $viewFile;
            $content = ob_get_clean();
            
            // Use layout set in view if it was changed
            $finalLayout = $layout;
            $layoutPath = __DIR__ . '/../views/layouts/' . $finalLayout . '.php';
            
            if (file_exists($layoutPath)) {
                extract($data);
                include $layoutPath;
            } else {
                echo $content;
            }
        } else {
            extract($data);
            include $viewFile;
        }
    }

    public static function asset($path) {
        $basePath = self::getBasePath();
        return $basePath . '/public/' . ltrim($path, '/');
    }

    public static function url($path = '') {
        $basePath = self::getBasePath();
        return $basePath . ($path ? '/' . ltrim($path, '/') : '');
    }
    
    private static function getBasePath() {
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

    public static function csrf() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function old($key, $default = '') {
        return $_SESSION['old'][$key] ?? $default;
    }

    public static function flash($key) {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }
}


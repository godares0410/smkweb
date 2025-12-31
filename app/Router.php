<?php

class Router {
    private $routes = [];
    private $middleware = [];

    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    public function delete($path, $handler) {
        $this->addRoute('DELETE', $path, $handler);
    }

    public function put($path, $handler) {
        $this->addRoute('PUT', $path, $handler);
    }

    private function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function middleware($name, $callback) {
        $this->middleware[$name] = $callback;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        
        // Handle method override for PUT/DELETE (like absensi)
        if ($method === 'POST') {
            // Check both $_POST and php://input for _method (in case of file uploads)
            if (isset($_POST['_method'])) {
                $method = strtoupper($_POST['_method']);
            } elseif (isset($_REQUEST['_method'])) {
                $method = strtoupper($_REQUEST['_method']);
            }
        }
        
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = parse_url($requestUri, PHP_URL_PATH);
        if ($uri === false) {
            $uri = '/';
        }
        
        // Get base path dynamically
        $basePath = $this->getBasePath();
        if ($basePath && $basePath !== '/') {
            $uri = str_replace($basePath, '', $uri);
        }
        $uri = $uri ?: '/';
        
        // Debug logging for AJAX requests and form submissions
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        $isFormSubmit = $method === 'POST' || $method === 'PUT';
        
        if ($isAjax || $isFormSubmit) {
            error_log("=== ROUTER DISPATCH ===");
            error_log("REQUEST_URI = " . $requestUri);
            error_log("PARSED URI = " . parse_url($requestUri, PHP_URL_PATH));
            error_log("BASE PATH  = " . ($basePath ?: '(empty)'));
            error_log("FINAL URI  = " . $uri);
            error_log("METHOD     = " . $method);
            error_log("_POST _method = " . ($_POST['_method'] ?? 'N/A'));
            error_log("Total routes: " . count($this->routes));
        }

        foreach ($this->routes as $routeIndex => $route) {
            if ($route['method'] === $method) {
                $pattern = $this->convertToRegex($route['path']);
                if ($isAjax) {
                    error_log("Checking route #$routeIndex: {$route['method']} {$route['path']} -> Pattern: $pattern");
                }
                if (preg_match($pattern, $uri, $matches)) {
                    if ($isAjax) {
                        error_log("✓ Route MATCHED: {$route['method']} {$route['path']}");
                        error_log("✓✓✓ Route MATCHED ✓✓✓");
                        error_log("Route Path: {$route['path']}");
                        error_log("Controller: " . ($route['handler']['controller'] ?? 'Closure'));
                        error_log("Action: " . ($route['handler']['action'] ?? 'N/A'));
                        error_log("Matches: " . print_r($matches, true));
                    }
                    array_shift($matches);
                    
                    $handler = $route['handler'];
                    
                    // If handler is a Closure, execute it directly
                    if ($handler instanceof Closure) {
                        call_user_func_array($handler, $matches);
                        return;
                    }
                    
                    // Check middleware
                    if (isset($handler['middleware'])) {
                        foreach ($handler['middleware'] as $mw) {
                            if (isset($this->middleware[$mw])) {
                                $middlewareResult = $this->middleware[$mw]();
                                if ($middlewareResult === false) {
                                    if ($isAjax) {
                                        error_log("Middleware $mw blocked the request");
                                    }
                                    return; // Middleware blocked the request
                                }
                            }
                        }
                    }
                    
                    $controller = $handler['controller'];
                    $action = $handler['action'];
                    
                    // Determine if this is an admin route
                    $isAdminRoute = strpos($uri, '/admin/') === 0;
                    $controllerFile = null;
                    
                    // For admin routes, ALWAYS try Admin folder first
                    if ($isAdminRoute) {
                        $controllerFile = __DIR__ . '/Controllers/Admin/' . $controller . '.php';
                        if (file_exists($controllerFile)) {
                            // Unset/clear any previously loaded class with same name
                            // Then require the Admin version
                            require_once $controllerFile;
                        } else {
                            // Fallback to regular controllers if Admin doesn't exist
                            $controllerFile = __DIR__ . '/Controllers/' . $controller . '.php';
                            if (file_exists($controllerFile)) {
                                require_once $controllerFile;
                            }
                        }
                    } else {
                        // For public routes, use regular controllers
                        $controllerFile = __DIR__ . '/Controllers/' . $controller . '.php';
                        if (file_exists($controllerFile)) {
                            require_once $controllerFile;
                        }
                    }
                    
                    // Check if controller class exists
                    if (!class_exists($controller)) {
                        if ($isAjax) {
                            error_log("Controller class '$controller' not found. File: " . ($controllerFile ?? 'N/A'));
                        }
                        continue; // Skip to next route
                    }
                    
                    // Instantiate controller
                    $controllerInstance = new $controller();
                    if (method_exists($controllerInstance, $action)) {
                        if ($isAjax) {
                            error_log("Calling controller method: $controller::$action");
                        }
                        
                        // Clear any output buffers before calling controller method
                        while (ob_get_level() > 0) {
                            ob_end_clean();
                        }
                        
                        call_user_func_array([$controllerInstance, $action], $matches);
                        return;
                    } else {
                        if ($isAjax) {
                            error_log("Method $action does not exist in $controller");
                        }
                    }
                }
            }
        }

        // Check if this is an AJAX request
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if ($isAjax) {
            error_log("=== NO ROUTE MATCHED ===");
            error_log("Method: $method, URI: $uri");
            error_log("Available routes for $method:");
            foreach ($this->routes as $r) {
                if ($r['method'] === $method) {
                    error_log("  - {$r['path']}");
                }
            }
            error_log("========================");
            
            // Clear output buffers
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            
            http_response_code(404);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => '404 Not Found - Route tidak ditemukan']);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    private function convertToRegex($path) {
        $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
    
    /**
     * Get base path of the application
     * Uses the same logic as helpers.php getBasePath() for consistency
     */
    private function getBasePath() {
        // Use the global getBasePath() function if available
        if (function_exists('getBasePath')) {
            return getBasePath();
        }
        
        // Fallback to same logic as helpers.php
        static $basePath = null;
        
        if ($basePath !== null) {
            return $basePath;
        }
        
        // Try to get from config first
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
        
        // Auto-detect from SCRIPT_NAME
        if (isset($_SERVER['SCRIPT_NAME'])) {
            $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
            if ($scriptDir === '/' || $scriptDir === '\\') {
                $basePath = '';
            } else {
                $basePath = $scriptDir;
            }
        } else {
            // Fallback to /smkweb for localhost
            $basePath = '/smkweb';
        }
        
        return $basePath;
    }
}


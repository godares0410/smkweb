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
        
        // Handle method override for PUT/DELETE
        if ($method === 'POST') {
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
        
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                $pattern = $this->convertToRegex($route['path']);
                if (preg_match($pattern, $uri, $matches)) {
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
                                    return;
                                }
                            }
                        }
                    }
                    
                    $controller = $handler['controller'];
                    $action = $handler['action'];
                    
                    // Try to load controller if not already loaded
                    if (!class_exists($controller)) {
                        // Try Admin namespace first
                        $controllerFile = __DIR__ . '/Controllers/Admin/' . $controller . '.php';
                        if (file_exists($controllerFile)) {
                            require $controllerFile;
                        } else {
                            // Try regular controllers
                            $controllerFile = __DIR__ . '/Controllers/' . $controller . '.php';
                            if (file_exists($controllerFile)) {
                                require $controllerFile;
                            }
                        }
                    }
                    
                    if (class_exists($controller)) {
                        $controllerInstance = new $controller();
                        if (method_exists($controllerInstance, $action)) {
                            // Clear any output buffers before calling controller method
                            while (ob_get_level() > 0) {
                                ob_end_clean();
                            }
                            
                            call_user_func_array([$controllerInstance, $action], $matches);
                            return;
                        }
                    }
                }
            }
        }

        // 404 Not Found
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if ($isAjax) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            http_response_code(404);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => '404 Not Found']);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    private function convertToRegex($path) {
        $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
    
    private function getBasePath() {
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
}


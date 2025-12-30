<?php

require_once __DIR__ . '/../app/autoload.php';

Auth::start();

$router = new Router();

// Middleware
$router->middleware('auth', function() {
    if (!Auth::check()) {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if ($isAjax) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            http_response_code(401);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => 'Unauthorized. Please login.'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        
        Response::redirect(url('/admin/login'));
        return false;
    }
    return true;
});

// Public Routes
$router->get('/', [
    'controller' => 'HomeController',
    'action' => 'index'
]);

$router->get('/post/{slug}', [
    'controller' => 'PostController',
    'action' => 'show'
]);

$router->get('/posts', [
    'controller' => 'HomeController',
    'action' => 'redirectToBerita'
]);

$router->get('/page/kontak', [
    'controller' => 'HomeController',
    'action' => 'redirectToKontak'
]);

$router->get('/page/{slug}', [
    'controller' => 'PageController',
    'action' => 'show'
]);

$router->get('/gallery', [
    'controller' => 'HomeController',
    'action' => 'redirectToGaleri'
]);

// Admin Routes - Auth
$router->get('/admin/login', [
    'controller' => 'AuthController',
    'action' => 'showLoginForm'
]);

$router->post('/admin/login', [
    'controller' => 'AuthController',
    'action' => 'login'
]);

$router->post('/admin/logout', [
    'controller' => 'AuthController',
    'action' => 'logout',
    'middleware' => ['auth']
]);

// Admin Routes - Dashboard
$router->get('/admin/dashboard', [
    'controller' => 'DashboardController',
    'action' => 'index',
    'middleware' => ['auth']
]);

// Admin Routes - Posts (RESTful Resource Routes)
// Urutan penting: route yang lebih spesifik harus didefinisikan lebih dulu

// Index - GET /admin/posts
$router->get('/admin/posts', [
    'controller' => 'PostController',
    'action' => 'index',
    'middleware' => ['auth']
]);

// Create - GET /admin/posts/create (harus sebelum {id})
$router->get('/admin/posts/create', [
    'controller' => 'PostController',
    'action' => 'create',
    'middleware' => ['auth']
]);

// Store - POST /admin/posts
$router->post('/admin/posts', [
    'controller' => 'PostController',
    'action' => 'store',
    'middleware' => ['auth']
]);

// Edit - GET /admin/posts/{id}/edit (harus sebelum {id})
$router->get('/admin/posts/{id}/edit', [
    'controller' => 'PostController',
    'action' => 'edit',
    'middleware' => ['auth']
]);

// Update - POST /admin/posts/{id} (harus sebelum GET {id} untuk menghindari konflik)
$router->post('/admin/posts/{id}', [
    'controller' => 'PostController',
    'action' => 'update',
    'middleware' => ['auth']
]);

// Update - PUT/PATCH /admin/posts/{id} (untuk method override)
$router->put('/admin/posts/{id}', [
    'controller' => 'PostController',
    'action' => 'update',
    'middleware' => ['auth']
]);

// Show - GET /admin/posts/{id} (untuk API/JSON response) - HARUS TERAKHIR
$router->get('/admin/posts/{id}', [
    'controller' => 'PostController',
    'action' => 'show',
    'middleware' => ['auth']
]);

// Destroy - DELETE /admin/posts/{id}
$router->delete('/admin/posts/{id}', [
    'controller' => 'PostController',
    'action' => 'destroy',
    'middleware' => ['auth']
]);

// Admin Routes - Pages
$router->get('/admin/pages', [
    'controller' => 'PageController',
    'action' => 'index',
    'middleware' => ['auth']
]);

$router->get('/admin/pages/create', [
    'controller' => 'PageController',
    'action' => 'create',
    'middleware' => ['auth']
]);

$router->post('/admin/pages', [
    'controller' => 'PageController',
    'action' => 'store',
    'middleware' => ['auth']
]);

$router->get('/admin/pages/{id}/edit', [
    'controller' => 'PageController',
    'action' => 'edit',
    'middleware' => ['auth']
]);

$router->post('/admin/pages/{id}', [
    'controller' => 'PageController',
    'action' => 'update',
    'middleware' => ['auth']
]);

$router->put('/admin/pages/{id}', [
    'controller' => 'PageController',
    'action' => 'update',
    'middleware' => ['auth']
]);

$router->delete('/admin/pages/{id}', [
    'controller' => 'PageController',
    'action' => 'delete',
    'middleware' => ['auth']
]);

// Admin Routes - Gallery
$router->get('/admin/gallery', [
    'controller' => 'GalleryController',
    'action' => 'index',
    'middleware' => ['auth']
]);

$router->get('/admin/gallery/create', [
    'controller' => 'GalleryController',
    'action' => 'create',
    'middleware' => ['auth']
]);

$router->post('/admin/gallery', [
    'controller' => 'GalleryController',
    'action' => 'store',
    'middleware' => ['auth']
]);

$router->get('/admin/gallery/{id}/edit', [
    'controller' => 'GalleryController',
    'action' => 'edit',
    'middleware' => ['auth']
]);

$router->post('/admin/gallery/{id}', [
    'controller' => 'GalleryController',
    'action' => 'update',
    'middleware' => ['auth']
]);

$router->put('/admin/gallery/{id}', [
    'controller' => 'GalleryController',
    'action' => 'update',
    'middleware' => ['auth']
]);

$router->delete('/admin/gallery/{id}', [
    'controller' => 'GalleryController',
    'action' => 'delete',
    'middleware' => ['auth']
]);

// Admin Routes - Carousel
$router->get('/admin/carousel', [
    'controller' => 'CarouselController',
    'action' => 'index',
    'middleware' => ['auth']
]);

$router->get('/admin/carousel/create', [
    'controller' => 'CarouselController',
    'action' => 'create',
    'middleware' => ['auth']
]);

$router->post('/admin/carousel', [
    'controller' => 'CarouselController',
    'action' => 'store',
    'middleware' => ['auth']
]);

$router->get('/admin/carousel/{id}/edit', [
    'controller' => 'CarouselController',
    'action' => 'edit',
    'middleware' => ['auth']
]);

$router->post('/admin/carousel/{id}', [
    'controller' => 'CarouselController',
    'action' => 'update',
    'middleware' => ['auth']
]);

$router->put('/admin/carousel/{id}', [
    'controller' => 'CarouselController',
    'action' => 'update',
    'middleware' => ['auth']
]);

$router->delete('/admin/carousel/{id}', [
    'controller' => 'CarouselController',
    'action' => 'delete',
    'middleware' => ['auth']
]);

// Admin Routes - Settings
$router->get('/admin/settings', [
    'controller' => 'SettingController',
    'action' => 'index',
    'middleware' => ['auth']
]);

$router->post('/admin/settings', [
    'controller' => 'SettingController',
    'action' => 'update',
    'middleware' => ['auth']
]);

// Admin Routes - Users
$router->get('/admin/users', [
    'controller' => 'AdminUserController',
    'action' => 'index',
    'middleware' => ['auth']
]);

$router->get('/admin/users/create', [
    'controller' => 'AdminUserController',
    'action' => 'create',
    'middleware' => ['auth']
]);

$router->post('/admin/users', [
    'controller' => 'AdminUserController',
    'action' => 'store',
    'middleware' => ['auth']
]);

$router->get('/admin/users/{id}/edit', [
    'controller' => 'AdminUserController',
    'action' => 'edit',
    'middleware' => ['auth']
]);

$router->post('/admin/users/{id}', [
    'controller' => 'AdminUserController',
    'action' => 'update',
    'middleware' => ['auth']
]);

$router->put('/admin/users/{id}', [
    'controller' => 'AdminUserController',
    'action' => 'update',
    'middleware' => ['auth']
]);

$router->delete('/admin/users/{id}', [
    'controller' => 'AdminUserController',
    'action' => 'delete',
    'middleware' => ['auth']
]);

return $router;


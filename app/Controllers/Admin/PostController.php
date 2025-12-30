<?php



class PostController extends Controller {
    private $postModel;

    public function __construct() {
        $this->postModel = new Post();
    }

    public function index() {
        $filters = [
            'search' => Request::get('search', ''),
            'category' => Request::get('category', ''),
            'status' => Request::get('status', '')
        ];
        
        $posts = $this->postModel->getAll($filters);
        $this->view('admin.posts.index', ['posts' => $posts]);
    }

    public function create() {
        $this->view('admin.posts.create');
    }

    public function store() {
        $data = [
            'title' => Request::post('title'),
            'slug' => $this->generateSlug(Request::post('title')),
            'content' => Request::post('content'),
            'excerpt' => Request::post('excerpt'),
            'category' => Request::post('category'),
            'author_id' => Auth::id(),
            'type' => Request::post('type', 'landscape'),
            'status' => Request::post('status', 'draft')
        ];

        // Handle file upload
        if (Request::file('featured_image')) {
            $uploadResult = $this->uploadImage(Request::file('featured_image'));
            if ($uploadResult) {
                $data['featured_image'] = $uploadResult;
            }
        }

        // Handle foto berita - priority: upload > select
        if (Request::file('foto_upload')) {
            $uploadResult = $this->uploadFotoBerita(Request::file('foto_upload'));
            if ($uploadResult) {
                $data['foto'] = $uploadResult;
            }
        } elseif (Request::post('foto')) {
            $data['foto'] = Request::post('foto');
        }

        $this->postModel->create($data);
        
        // Redirect back to dashboard if submitted from modal
        $redirectUrl = Request::post('from_dashboard') 
            ? url('/admin/dashboard') 
            : url('/admin/posts');
        
        Response::with('success', 'Post berhasil dibuat')->redirect($redirectUrl);
    }

    public function edit($id) {
        $post = $this->postModel->findById($id);
        if (!$post) {
            // Check if it's a JSON request
            if (Request::isAjax() || Request::get('json') || Request::get('format') === 'json') {
                $this->json(['success' => false, 'message' => 'Post tidak ditemukan'], 404);
                return;
            }
            Response::with('error', 'Post tidak ditemukan')->redirect(url('/admin/posts'));
            return;
        }
        
        // Return JSON if requested (for modal)
        if (Request::isAjax() || Request::get('json') || Request::get('format') === 'json') {
            $this->json(['success' => true, 'post' => $post]);
            return;
        }
        
        $this->view('admin.posts.edit', ['post' => $post]);
    }

    /**
     * Display the specified resource (Laravel-style show method)
     * Returns JSON if AJAX request, otherwise redirects
     */
    public function show($id) {
        // Debug logging
        error_log("show() method called with ID: " . $id);
        error_log("ID type: " . gettype($id));
        
        $post = $this->postModel->findById((int)$id);
        
        error_log("Post found: " . ($post ? 'yes' : 'no'));
        
        if (!$post) {
            error_log("Post not found for ID: " . $id);
            if (Request::isAjax() || Request::wantsJson()) {
                $this->json(['success' => false, 'message' => 'Post tidak ditemukan'], 404);
                return;
            }
            Response::with('error', 'Post tidak ditemukan')->redirect(url('/admin/posts'));
            return;
        }
        
        // Return JSON for AJAX/API requests (for modal)
        if (Request::isAjax() || Request::wantsJson()) {
            error_log("Returning JSON for post ID: " . $id);
            $this->json(['success' => true, 'post' => $post]);
            return;
        }
        
        // For regular requests, redirect to edit page
        Response::redirect(url('/admin/posts/' . $id . '/edit'));
    }

    public function update($id) {
        $post = $this->postModel->findById($id);
        if (!$post) {
            Response::with('error', 'Post tidak ditemukan')->redirect(url('/admin/posts'));
            return;
        }

        $data = [
            'title' => Request::post('title'),
            'slug' => $this->generateSlug(Request::post('title'), $id),
            'content' => Request::post('content'),
            'excerpt' => Request::post('excerpt'),
            'category' => Request::post('category'),
            'type' => Request::post('type', 'landscape'),
            'status' => Request::post('status', 'draft')
        ];

        // Handle file upload
        if (Request::file('featured_image')) {
            $uploadResult = $this->uploadImage(Request::file('featured_image'));
            if ($uploadResult) {
                // Delete old image
                if ($post['featured_image']) {
                    $oldPath = __DIR__ . '/../../public/uploads/' . $post['featured_image'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $data['featured_image'] = $uploadResult;
            }
        }

        // Handle foto berita - priority: upload > select
        if (Request::file('foto_upload')) {
            $uploadResult = $this->uploadFotoBerita(Request::file('foto_upload'));
            if ($uploadResult) {
                $data['foto'] = $uploadResult;
            }
        } elseif (Request::post('foto') !== null) {
            $data['foto'] = Request::post('foto') ?: null;
        }

        $this->postModel->update($id, $data);
        
        // Redirect back to dashboard if submitted from modal
        $redirectUrl = Request::post('from_dashboard') 
            ? url('/admin/dashboard') 
            : url('/admin/posts');
        
        Response::with('success', 'Post berhasil diupdate')->redirect($redirectUrl);
    }

    /**
     * Remove the specified resource (Laravel-style destroy method)
     */
    public function destroy($id) {
        return $this->delete($id);
    }

    public function delete($id) {
        $post = $this->postModel->findById($id);
        if (!$post) {
            if (Request::isAjax()) {
                $this->json(['success' => false, 'message' => 'Post tidak ditemukan'], 404);
                return;
            }
            Response::with('error', 'Post tidak ditemukan')->redirect(url('/admin/posts'));
            return;
        }

        // Delete image
        if ($post['featured_image']) {
            $imagePath = __DIR__ . '/../../public/uploads/' . $post['featured_image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->postModel->delete($id);
        
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'Post berhasil dihapus']);
            return;
        }
        Response::with('success', 'Post berhasil dihapus')->redirect(url('/admin/posts'));
    }

    private function generateSlug($title, $excludeId = null) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Check if slug exists
        $existing = $this->postModel->findBySlug($slug);
        if ($existing && $existing['id'] != $excludeId) {
            $slug .= '-' . time();
        }
        
        return $slug;
    }

    private function uploadImage($file) {
        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return null;
        }

        $filename = uniqid() . '.' . $ext;
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        }

        return null;
    }

    private function uploadFotoBerita($file) {
        $uploadDir = __DIR__ . '/../../public/images/berita/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return null;
        }

        // Check file size (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return null;
        }

        // Generate unique filename: berita-{timestamp}-{random}.{ext}
        $filename = 'berita-' . time() . '-' . uniqid() . '.' . $ext;
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        }

        return null;
    }
}


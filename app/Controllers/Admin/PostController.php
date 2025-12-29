<?php



class PostController extends Controller {
    private $postModel;

    public function __construct() {
        $this->postModel = new Post();
    }

    public function index() {
        $posts = $this->postModel->getAll();
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

        // Handle foto berita
        if (Request::post('foto')) {
            $data['foto'] = Request::post('foto');
        }

        $this->postModel->create($data);
        Response::with('success', 'Post berhasil dibuat')->redirect(url('/admin/posts'));
    }

    public function edit($id) {
        $post = $this->postModel->findById($id);
        if (!$post) {
            Response::with('error', 'Post tidak ditemukan')->redirect(url('/admin/posts'));
            return;
        }
        $this->view('admin.posts.edit', ['post' => $post]);
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

        // Handle foto berita
        if (Request::post('foto') !== null) {
            $data['foto'] = Request::post('foto') ?: null;
        }

        $this->postModel->update($id, $data);
        Response::with('success', 'Post berhasil diupdate')->redirect(url('/admin/posts'));
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
}


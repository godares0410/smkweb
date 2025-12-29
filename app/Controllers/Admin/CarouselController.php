<?php

class CarouselController extends Controller {
    private $carouselModel;

    public function __construct() {
        $this->carouselModel = new Carousel();
    }

    public function index() {
        $carousel = $this->carouselModel->getAll();
        $this->view('admin.carousel.index', ['carousel' => $carousel]);
    }

    public function create() {
        $this->view('admin.carousel.create');
    }

    public function store() {
        $imageFile = Request::file('image');
        if (!$imageFile || $imageFile['error'] !== UPLOAD_ERR_OK) {
            Response::with('error', 'Gambar harus diupload')
                ->withInput(Request::post())
                ->redirect(url('/admin/carousel/create'));
            return;
        }

        $uploadResult = $this->uploadImage($imageFile);
        if (!$uploadResult) {
            Response::with('error', 'Gagal mengupload gambar')
                ->withInput(Request::post())
                ->redirect(url('/admin/carousel/create'));
            return;
        }

        $data = [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
            'image' => $uploadResult,
            'link' => Request::post('link', ''),
            'link_text' => Request::post('link_text', ''),
            'order_position' => Request::post('order_position', 0),
            'status' => Request::post('status', 'active')
        ];

        $this->carouselModel->create($data);
        Response::with('success', 'Item carousel berhasil ditambahkan')->redirect(url('/admin/carousel'));
    }

    public function edit($id) {
        $item = $this->carouselModel->findById($id);
        if (!$item) {
            Response::with('error', 'Item tidak ditemukan')->redirect(url('/admin/carousel'));
            return;
        }
        $this->view('admin.carousel.edit', ['item' => $item]);
    }

    public function update($id) {
        $item = $this->carouselModel->findById($id);
        if (!$item) {
            Response::with('error', 'Item tidak ditemukan')->redirect(url('/admin/carousel'));
            return;
        }

        $data = [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
            'link' => Request::post('link', ''),
            'link_text' => Request::post('link_text', ''),
            'order_position' => Request::post('order_position', 0),
            'status' => Request::post('status', 'active')
        ];

        // Handle new image upload
        if (Request::file('image') && Request::file('image')['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadImage(Request::file('image'));
            if ($uploadResult) {
                // Delete old image
                if ($item['image']) {
                    $oldPath = __DIR__ . '/../../public/images/carousel/' . $item['image'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $data['image'] = $uploadResult;
            }
        }

        $this->carouselModel->update($id, $data);
        Response::with('success', 'Item carousel berhasil diupdate')->redirect(url('/admin/carousel'));
    }

    public function delete($id) {
        $item = $this->carouselModel->findById($id);
        if (!$item) {
            if (Request::isAjax()) {
                $this->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
                return;
            }
            Response::with('error', 'Item tidak ditemukan')->redirect(url('/admin/carousel'));
            return;
        }

        // Delete image
        if ($item['image']) {
            $imagePath = __DIR__ . '/../../public/images/carousel/' . $item['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->carouselModel->delete($id);
        
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'Item carousel berhasil dihapus']);
            return;
        }
        Response::with('success', 'Item carousel berhasil dihapus')->redirect(url('/admin/carousel'));
    }

    private function uploadImage($file) {
        $uploadDir = __DIR__ . '/../../public/images/carousel/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Ensure directory is writable
        if (!is_writable($uploadDir)) {
            @chmod($uploadDir, 0777);
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return null;
        }

        $filename = 'carousel-' . uniqid() . '.' . $ext;
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        }

        return null;
    }
}


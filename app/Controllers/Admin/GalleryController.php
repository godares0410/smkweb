<?php

class GalleryController extends Controller {
    private $galleryModel;

    public function __construct() {
        $this->galleryModel = new Gallery();
    }

    public function index() {
        $gallery = $this->galleryModel->getAll();
        $this->view('admin.gallery.index', ['gallery' => $gallery]);
    }

    public function create() {
        $this->view('admin.gallery.create');
    }

    public function store() {
        $imageFile = Request::file('image');
        if (!$imageFile || $imageFile['error'] !== UPLOAD_ERR_OK) {
            Response::with('error', 'Gambar harus diupload')
                ->withInput(Request::post())
                ->redirect(url('/admin/gallery/create'));
            return;
        }

        $uploadResult = $this->uploadImage($imageFile);
        if (!$uploadResult) {
            Response::with('error', 'Gagal mengupload gambar')
                ->withInput(Request::post())
                ->redirect(url('/admin/gallery/create'));
            return;
        }

        $data = [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
            'image' => $uploadResult,
            'category' => Request::post('category'),
            'status' => Request::post('status', 'active')
        ];

        $this->galleryModel->create($data);
        Response::with('success', 'Gambar berhasil ditambahkan')->redirect(url('/admin/gallery'));
    }

    public function edit($id) {
        $item = $this->galleryModel->findById($id);
        if (!$item) {
            Response::with('error', 'Item tidak ditemukan')->redirect(url('/admin/gallery'));
            return;
        }
        $this->view('admin.gallery.edit', ['item' => $item]);
    }

    public function update($id) {
        $item = $this->galleryModel->findById($id);
        if (!$item) {
            Response::with('error', 'Item tidak ditemukan')->redirect(url('/admin/gallery'));
            return;
        }

        $data = [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
            'category' => Request::post('category'),
            'status' => Request::post('status', 'active')
        ];

        // Handle new image upload
        if (Request::file('image') && Request::file('image')['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->uploadImage(Request::file('image'));
            if ($uploadResult) {
                // Delete old image
                if ($item['image']) {
                    $oldPath = __DIR__ . '/../../public/uploads/' . $item['image'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $data['image'] = $uploadResult;
            }
        }

        $this->galleryModel->update($id, $data);
        Response::with('success', 'Item berhasil diupdate')->redirect(url('/admin/gallery'));
    }

    public function delete($id) {
        $item = $this->galleryModel->findById($id);
        if (!$item) {
            if (Request::isAjax()) {
                $this->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
                return;
            }
            Response::with('error', 'Item tidak ditemukan')->redirect(url('/admin/gallery'));
            return;
        }

        // Delete image
        if ($item['image']) {
            $imagePath = __DIR__ . '/../../public/uploads/' . $item['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->galleryModel->delete($id);
        
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'Item berhasil dihapus']);
            return;
        }
        Response::with('success', 'Item berhasil dihapus')->redirect(url('/admin/gallery'));
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


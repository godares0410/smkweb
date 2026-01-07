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
        $data = [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
            'link' => Request::post('link', ''),
            'link_text' => Request::post('link_text', ''),
            'order_position' => Request::post('order_position', 0),
            'status' => Request::post('status', 'active')
        ];

        // Handle image upload
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $file = $_FILES['image'];
            
            // Check upload error
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'File terlalu besar (melebihi upload_max_filesize)',
                    UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (melebihi MAX_FILE_SIZE)',
                    UPLOAD_ERR_PARTIAL => 'File hanya ter-upload sebagian',
                    UPLOAD_ERR_NO_FILE => 'Tidak ada file yang di-upload',
                    UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan',
                    UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                    UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh extension'
                ];
                $errorMsg = $errorMessages[$file['error']] ?? 'Error upload tidak diketahui: ' . $file['error'];
                
                Response::with('error', $errorMsg)->withInput(Request::post())->redirect(url('/admin/carousel/create'));
                return;
            }
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file['type'], $allowedTypes) || !in_array($extension, $allowedExtensions)) {
                Response::with('error', 'Format file tidak didukung. Gunakan JPEG, PNG, GIF, atau WEBP')->withInput(Request::post())->redirect(url('/admin/carousel/create'));
                return;
            }
            
            // Validate file size (max 5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                Response::with('error', 'Ukuran file terlalu besar. Maksimal 5MB')->withInput(Request::post())->redirect(url('/admin/carousel/create'));
                return;
            }
            
            $uploadResult = $this->uploadImage($file);
            if ($uploadResult) {
                $data['image'] = $uploadResult;
            } else {
                 Response::with('error', 'Gagal mengupload gambar')->withInput(Request::post())->redirect(url('/admin/carousel/create'));
                 return;
            }
        } else {
             Response::with('error', 'Gambar harus diupload')->withInput(Request::post())->redirect(url('/admin/carousel/create'));
             return;
        }

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

        // Handle image upload
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $file = $_FILES['image'];
            
             // Check upload error
            if ($file['error'] !== UPLOAD_ERR_OK) {
                 $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'File terlalu besar (melebihi upload_max_filesize)',
                    UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (melebihi MAX_FILE_SIZE)',
                    UPLOAD_ERR_PARTIAL => 'File hanya ter-upload sebagian',
                    UPLOAD_ERR_NO_FILE => 'Tidak ada file yang di-upload',
                    UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan',
                    UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                    UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh extension'
                ];
                $errorMsg = $errorMessages[$file['error']] ?? 'Error upload tidak diketahui: ' . $file['error'];
                
                Response::with('error', $errorMsg)->redirect(url('/admin/carousel/' . $id . '/edit'));
                return;
            }

             // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file['type'], $allowedTypes) || !in_array($extension, $allowedExtensions)) {
                Response::with('error', 'Format file tidak didukung. Gunakan JPEG, PNG, GIF, atau WEBP')->redirect(url('/admin/carousel/' . $id . '/edit'));
                return;
            }
             
            // Validate file size (max 5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                Response::with('error', 'Ukuran file terlalu besar. Maksimal 5MB')->redirect(url('/admin/carousel/' . $id . '/edit'));
                return;
            }

            // Delete old image
            if (!empty($item['image'])) {
                $this->deleteOldPhoto($item['image']);
            }
            
            $uploadResult = $this->uploadImage($file);
            if ($uploadResult) {
                $data['image'] = $uploadResult;
            } else {
                 Response::with('error', 'Gagal mengupload gambar')->redirect(url('/admin/carousel/' . $id . '/edit'));
                 return;
            }
        }

        $this->carouselModel->update($id, $data);
        Response::with('success', 'Item carousel berhasil diupdate')->redirect(url('/admin/carousel'));
    }

    public function destroy($id) {
        return $this->delete($id);
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
        if (!empty($item['image'])) {
            $this->deleteOldPhoto($item['image']);
        }

        $this->carouselModel->delete($id);
        
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'Item carousel berhasil dihapus']);
            return;
        }
        Response::with('success', 'Item carousel berhasil dihapus')->redirect(url('/admin/carousel'));
    }

    private function getCarouselImagePath() {
        $relativePath = __DIR__ . '/../../../public/images/carousel/';
        $absolutePath = realpath($relativePath);
        if (!$absolutePath) {
            $basePath = realpath(__DIR__ . '/../../../public/images/');
            if ($basePath) {
                $absolutePath = $basePath . '/carousel';
                if (!is_dir($absolutePath)) {
                    @mkdir($absolutePath, 0777, true);
                }
                $absolutePath = realpath($absolutePath);
            }
             if (!$absolutePath) {
                 // Fallback if realpath fails for some reason
                 return __DIR__ . '/../../../public/images/carousel/';
            }
        }
        return rtrim($absolutePath, '/') . '/';
    }

    private function deleteOldPhoto($filename) {
         if (empty($filename)) return false;
         
        // Validate filename
        if (!is_string($filename) || strlen($filename) < 3) return false;
        
        $carouselPath = $this->getCarouselImagePath();
        $filePath = $carouselPath . $filename;
        
        if (!file_exists($filePath)) return true; // Already gone
        if (!is_file($filePath)) return false;
        
        $actualFilename = basename($filePath);
        if ($actualFilename !== $filename) return false;
        
        $deleted = @unlink($filePath);
        if (!$deleted && file_exists($filePath)) {
            @chmod($filePath, 0666);
            $deleted = @unlink($filePath);
        }
        
        return $deleted;
    }

    private function uploadImage($file) {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) return null;
        if (isset($file['error']) && $file['error'] !== UPLOAD_ERR_OK) return null;

        $uploadDir = $this->getCarouselImagePath();
        
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) return null;
            @chmod($uploadDir, 0777);
        }
        
        if (!is_writable($uploadDir)) {
            @chmod($uploadDir, 0777);
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) return null;

        $filename = 'carousel-' . time() . '-' . uniqid() . '.' . $ext;
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        }
        
        if (copy($file['tmp_name'], $targetPath)) {
            @chmod($targetPath, 0644);
            return $filename;
        }

        return null;
    }
}


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
        $data = [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
            'category' => Request::post('category'),
            'type' => Request::post('type', 'square'),
            'status' => Request::post('status', 'active')
        ];

        // Handle image upload with priority
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
                
                if (Request::isAjax() || Request::wantsJson()) {
                    $this->json(['success' => false, 'message' => $errorMsg], 422);
                    return;
                }
                Response::with('error', $errorMsg)->withInput(Request::post())->redirect(url('/admin/gallery/create'));
                return;
            }
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file['type'], $allowedTypes) || !in_array($extension, $allowedExtensions)) {
                if (Request::isAjax() || Request::wantsJson()) {
                    $this->json(['success' => false, 'message' => 'Format file tidak didukung. Gunakan JPEG, PNG, GIF, atau WEBP'], 422);
                    return;
                }
                Response::with('error', 'Format file tidak didukung. Gunakan JPEG, PNG, GIF, atau WEBP')->withInput(Request::post())->redirect(url('/admin/gallery/create'));
                return;
            }
            
            // Validate file size (max 5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                if (Request::isAjax() || Request::wantsJson()) {
                    $this->json(['success' => false, 'message' => 'Ukuran file terlalu besar. Maksimal 5MB'], 422);
                    return;
                }
                Response::with('error', 'Ukuran file terlalu besar. Maksimal 5MB')->withInput(Request::post())->redirect(url('/admin/gallery/create'));
                return;
            }
            
            $uploadResult = $this->uploadImage($file);
            if ($uploadResult) {
                $data['image'] = $uploadResult;
            } else {
                 if (Request::isAjax() || Request::wantsJson()) {
                    $this->json(['success' => false, 'message' => 'Gagal mengupload gambar'], 422);
                    return;
                }
                 Response::with('error', 'Gagal mengupload gambar')->withInput(Request::post())->redirect(url('/admin/gallery/create'));
                 return;
            }
        } else {
             if (Request::isAjax() || Request::wantsJson()) {
                $this->json(['success' => false, 'message' => 'Gambar harus diupload'], 422);
                return;
            }
             Response::with('error', 'Gambar harus diupload')->withInput(Request::post())->redirect(url('/admin/gallery/create'));
             return;
        }

        $this->galleryModel->create($data);
        
        if (Request::isAjax() || Request::wantsJson()) {
            $this->json(['success' => true, 'message' => 'Gambar berhasil ditambahkan']);
            return;
        }
        Response::with('success', 'Gambar berhasil ditambahkan')->redirect(url('/admin/gallery'));
    }

    public function edit($id) {
        $item = $this->galleryModel->findById($id);
        if (!$item) {
             if (Request::isAjax() || Request::get('json') || Request::get('format') === 'json') {
                $this->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
                return;
            }
            Response::with('error', 'Item tidak ditemukan')->redirect(url('/admin/gallery'));
            return;
        }
        
         if (Request::isAjax() || Request::get('json') || Request::get('format') === 'json') {
            $this->json(['success' => true, 'item' => $item]);
            return;
        }
        
        $this->view('admin.gallery.edit', ['item' => $item]);
    }

    public function update($id) {
        $item = $this->galleryModel->findById($id);
        if (!$item) {
            if (Request::isAjax() || Request::wantsJson()) {
                $this->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
                return;
            }
            Response::with('error', 'Item tidak ditemukan')->redirect(url('/admin/gallery'));
            return;
        }

        $data = [
            'title' => Request::post('title'),
            'description' => Request::post('description'),
            'category' => Request::post('category'),
            'type' => Request::post('type', 'square'),
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
                
                if (Request::isAjax() || Request::wantsJson()) {
                    $this->json(['success' => false, 'message' => $errorMsg], 422);
                    return;
                }
                Response::with('error', $errorMsg)->redirect(url('/admin/gallery/' . $id . '/edit'));
                return;
            }

             // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file['type'], $allowedTypes) || !in_array($extension, $allowedExtensions)) {
                if (Request::isAjax() || Request::wantsJson()) {
                    $this->json(['success' => false, 'message' => 'Format file tidak didukung. Gunakan JPEG, PNG, GIF, atau WEBP'], 422);
                    return;
                }
                Response::with('error', 'Format file tidak didukung. Gunakan JPEG, PNG, GIF, atau WEBP')->redirect(url('/admin/gallery/' . $id . '/edit'));
                return;
            }
             
            // Validate file size (max 5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                 if (Request::isAjax() || Request::wantsJson()) {
                    $this->json(['success' => false, 'message' => 'Ukuran file terlalu besar. Maksimal 5MB'], 422);
                    return;
                }
                Response::with('error', 'Ukuran file terlalu besar. Maksimal 5MB')->redirect(url('/admin/gallery/' . $id . '/edit'));
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
                 if (Request::isAjax() || Request::wantsJson()) {
                    $this->json(['success' => false, 'message' => 'Gagal mengupload gambar'], 422);
                    return;
                }
                 Response::with('error', 'Gagal mengupload gambar')->redirect(url('/admin/gallery/' . $id . '/edit'));
                 return;
            }
        }

        $this->galleryModel->update($id, $data);
        
        if (Request::isAjax() || Request::wantsJson()) {
            $this->json(['success' => true, 'message' => 'Item berhasil diupdate']);
            return;
        }
        Response::with('success', 'Item berhasil diupdate')->redirect(url('/admin/gallery'));
    }

    public function destroy($id) {
        return $this->delete($id);
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
        if (!empty($item['image'])) {
            $this->deleteOldPhoto($item['image']);
        }

        $this->galleryModel->delete($id);
        
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'Item berhasil dihapus']);
            return;
        }
        Response::with('success', 'Item berhasil dihapus')->redirect(url('/admin/gallery'));
    }

    private function getGalleryImagePath() {
         $relativePath = __DIR__ . '/../../public/images/galeri/';
        $absolutePath = realpath($relativePath);
        if (!$absolutePath) {
            $basePath = realpath(__DIR__ . '/../../public/images/');
            if ($basePath) {
                $absolutePath = $basePath . '/galeri';
                if (!is_dir($absolutePath)) {
                    @mkdir($absolutePath, 0777, true);
                }
                $absolutePath = realpath($absolutePath);
            }
            if (!$absolutePath) {
                 $absolutePath = '/Applications/XAMPP/xamppfiles/htdocs/smkweb/public/images/galeri';
            }
        }
        return rtrim($absolutePath, '/') . '/';
    }

    private function deleteOldPhoto($filename) {
         if (empty($filename)) return false;
         
        // Validate filename
        if (!is_string($filename) || strlen($filename) < 3) return false;
        
        $galleryPath = $this->getGalleryImagePath();
        $filePath = $galleryPath . $filename;
        
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

        $uploadDir = $this->getGalleryImagePath();
        
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

        $filename = 'gallery-' . time() . '-' . uniqid() . '.' . $ext;
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


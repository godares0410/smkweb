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

        // Handle file upload foto tambahan - check $_FILES directly for better compatibility
        if (isset($_FILES['foto_tambahan']) && !empty($_FILES['foto_tambahan']['name'])) {
            $fotoTambahanFile = $_FILES['foto_tambahan'];
            
            // Check upload error
            if ($fotoTambahanFile['error'] !== UPLOAD_ERR_OK) {
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'File terlalu besar (melebihi upload_max_filesize)',
                    UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (melebihi MAX_FILE_SIZE)',
                    UPLOAD_ERR_PARTIAL => 'File hanya ter-upload sebagian',
                    UPLOAD_ERR_NO_FILE => 'Tidak ada file yang di-upload',
                    UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan',
                    UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk',
                    UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh extension'
                ];
                $errorMsg = $errorMessages[$fotoTambahanFile['error']] ?? 'Error upload tidak diketahui: ' . $fotoTambahanFile['error'];
                error_log("foto_tambahan upload error: " . $errorMsg);
            } else {
                $uploadResult = $this->uploadFotoBerita($fotoTambahanFile);
                if ($uploadResult) {
                    $data['foto_tambahan'] = $uploadResult;
                }
            }
        }

        // Insert post first
        $postId = $this->postModel->create($data);
        
        // If foto_tambahan was uploaded but not in $data, update using raw SQL
        if (isset($_FILES['foto_tambahan']) && !empty($_FILES['foto_tambahan']['name']) && empty($data['foto_tambahan']) && $postId) {
            $fotoTambahanFile = $_FILES['foto_tambahan'];
            if ($fotoTambahanFile['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->uploadFotoBerita($fotoTambahanFile);
                if ($uploadResult) {
                    $db = Database::getInstance();
                    $sql = "UPDATE posts SET foto_tambahan = :foto_tambahan WHERE id = :id";
                    $db->query($sql, [
                        'foto_tambahan' => $uploadResult,
                        'id' => $postId
                    ]);
                    error_log("foto_tambahan updated via raw SQL (store fallback): " . $uploadResult);
                }
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
        
        Response::with('success', 'Post berhasil dibuat')->redirect(url('/admin/posts'));
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

        // Handle file upload foto tambahan - check $_FILES directly (like absensi)
        if (isset($_FILES['foto_tambahan']) && !empty($_FILES['foto_tambahan']['name'])) {
            $file = $_FILES['foto_tambahan'];
            
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
                Response::with('error', $errorMsg);
                Response::redirect(url('/admin/posts/' . $id . '/edit'));
                return;
            }
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file['type'], $allowedTypes) || !in_array($extension, $allowedExtensions)) {
                Response::with('error', 'Format file tidak didukung. Gunakan JPEG, PNG, GIF, atau WEBP');
                Response::redirect(url('/admin/posts/' . $id . '/edit'));
                return;
            }
            
            // Validate file size (max 5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                Response::with('error', 'Ukuran file terlalu besar. Maksimal 5MB');
                Response::redirect(url('/admin/posts/' . $id . '/edit'));
                return;
            }
            
            // Delete old foto_tambahan BEFORE uploading new one (like absensi)
            // CRITICAL: Only delete foto_tambahan, NOT foto
            if (!empty($post['foto_tambahan'])) {
                error_log("=== UPDATE FOTO_TAMBAHAN ===");
                error_log("Preparing to delete OLD foto_tambahan: " . $post['foto_tambahan']);
                error_log("Current post foto: " . ($post['foto'] ?? 'NULL'));
                error_log("Will NOT delete foto: " . ($post['foto'] ?? 'NULL'));
                error_log("CONFIRMED: Only updating foto_tambahan, foto field will NOT be touched");
                
                // CRITICAL: Verify we're deleting the correct file - MUST be foto_tambahan
                $filenameToDelete = $post['foto_tambahan'];
                error_log("CRITICAL CHECK: About to delete foto_tambahan with filename: " . $filenameToDelete);
                
                // Triple check: make sure we're not accidentally deleting foto
                if (!empty($post['foto']) && $filenameToDelete === $post['foto']) {
                    error_log("ERROR: foto_tambahan and foto have the same filename! Aborting delete to prevent wrong deletion.");
                    error_log("ERROR: foto_tambahan: " . $post['foto_tambahan']);
                    error_log("ERROR: foto: " . $post['foto']);
                    error_log("ERROR: ABORTING DELETE - filename matches foto, not foto_tambahan!");
                } else {
                    // Final safety check: verify filename doesn't match foto
                    if (empty($post['foto']) || $filenameToDelete !== $post['foto']) {
                        error_log("SAFETY CHECK PASSED: foto_tambahan filename (" . $filenameToDelete . ") is different from foto (" . ($post['foto'] ?? 'NULL') . ")");
                        $deleted = $this->deleteOldPhoto($filenameToDelete);
                        if (!$deleted) {
                            error_log("WARNING: Failed to delete old foto_tambahan, but continuing with upload");
                        }
                        // Wait a bit to ensure file system has processed the deletion
                        usleep(100000); // 0.1 second
                    } else {
                        error_log("SAFETY CHECK FAILED: Not deleting - filename matches foto");
                    }
                }
            }
            
            // Generate unique filename
            $fileName = 'berita-' . time() . '-' . uniqid() . '.' . $extension;
            // Get consistent upload path
            $uploadPath = $this->getBeritaImagePath();
            error_log("Resolved upload path: " . $uploadPath);
            
            // Create directory if not exists (like absensi)
            if (!is_dir($uploadPath)) {
                error_log("Creating upload directory: " . $uploadPath);
                $created = @mkdir($uploadPath, 0777, true);
                @chmod($uploadPath, 0777);
                error_log("Directory created: " . ($created ? 'YES' : 'NO'));
            }
            
            // Check and log current permissions (like absensi)
            $currentPerms = substr(sprintf('%o', fileperms($uploadPath)), -4);
            error_log("Upload path: " . $uploadPath);
            error_log("Current permissions: " . $currentPerms);
            error_log("Is writable check: " . (is_writable($uploadPath) ? 'YES' : 'NO'));
            
            // Try to ensure directory is writable - but don't fail if is_writable() returns false
            // Sometimes is_writable() is unreliable on macOS, so we'll try to write anyway
            if (!is_writable($uploadPath)) {
                error_log("is_writable() returned false, attempting to fix permissions...");
                @chmod($uploadPath, 0777);
                $newPerms = substr(sprintf('%o', fileperms($uploadPath)), -4);
                error_log("After chmod 777, permissions: " . $newPerms);
                // Don't fail here - try to write anyway as is_writable() may be unreliable
            }
            
            // Ensure fullPath uses absolute path
            $fullPath = rtrim($uploadPath, '/') . '/' . $fileName;
            error_log("Full target path: " . $fullPath);
            
            // Detailed logging before upload attempt
            error_log("=== UPLOAD DEBUG ===");
            error_log("tmp_name: " . $file['tmp_name']);
            error_log("tmp_name exists: " . (file_exists($file['tmp_name']) ? 'YES' : 'NO'));
            error_log("tmp_name readable: " . (is_readable($file['tmp_name']) ? 'YES' : 'NO'));
            error_log("tmp_name size: " . filesize($file['tmp_name']) . " bytes");
            error_log("target path: " . $fullPath);
            error_log("target dir exists: " . (is_dir($uploadPath) ? 'YES' : 'NO'));
            error_log("target dir writable: " . (is_writable($uploadPath) ? 'YES' : 'NO'));
            error_log("target file exists (before): " . (file_exists($fullPath) ? 'YES' : 'NO'));
            
            // Try to remove extended attributes if on macOS
            if (function_exists('exec') && PHP_OS === 'Darwin') {
                @exec('xattr -c "' . $uploadPath . '" 2>&1', $xattrOutput, $xattrReturn);
                if ($xattrReturn === 0) {
                    error_log("Removed extended attributes from upload path");
                }
            }
            
            // Try copy instead of move as fallback
            $uploadSuccess = false;
            if (move_uploaded_file($file['tmp_name'], $fullPath)) {
                $uploadSuccess = true;
            } else {
                // Fallback: try copy
                error_log("move_uploaded_file failed, trying copy...");
                if (copy($file['tmp_name'], $fullPath)) {
                    @chmod($fullPath, 0644);
                    $uploadSuccess = true;
                    error_log("File copied successfully (fallback method)");
                } else {
                    error_log("Both move_uploaded_file and copy failed");
                    $lastError = error_get_last();
                    error_log("Last PHP error: " . print_r($lastError, true));
                }
            }
            
            if ($uploadSuccess) {
                // Verify file was created
                if (file_exists($fullPath)) {
                    error_log("File successfully uploaded and verified: " . $fullPath);
                    error_log("File size: " . filesize($fullPath) . " bytes");
                    $data['foto_tambahan'] = $fileName;
                } else {
                    error_log("ERROR: File moved but not found at: " . $fullPath);
                    Response::with('error', 'File ter-upload tapi tidak ditemukan di server');
                    Response::redirect(url('/admin/posts/' . $id . '/edit'));
                    return;
                }
            } else {
                error_log("ERROR: All upload methods failed");
                error_log("tmp_name: " . $file['tmp_name']);
                error_log("target: " . $fullPath);
                error_log("Upload error code: " . $file['error']);
                $lastError = error_get_last();
                if ($lastError) {
                    error_log("PHP error: " . $lastError['message']);
                }
                Response::with('error', 'Gagal mengupload foto. Error: ' . ($lastError['message'] ?? 'Unknown error') . '. Periksa permission folder dan ukuran file');
                Response::redirect(url('/admin/posts/' . $id . '/edit'));
                return;
            }
        }

        // Handle foto berita - priority: upload > select
        // CRITICAL: Only process if foto_upload is provided AND has a file, don't touch foto if only foto_tambahan is updated
        // Check $_FILES directly with strict validation to prevent accidental triggers
        if (isset($_FILES['foto_upload']) && !empty($_FILES['foto_upload']['name']) && $_FILES['foto_upload']['error'] === UPLOAD_ERR_OK) {
            error_log("=== HANDLING FOTO_UPLOAD ===");
            error_log("foto_upload file name: " . $_FILES['foto_upload']['name']);
            
            // Delete old foto BEFORE uploading new one (like absensi)
            // IMPORTANT: Only delete foto, NOT foto_tambahan
            if (!empty($post['foto'])) {
                error_log("=== UPDATE FOTO ===");
                error_log("Preparing to delete OLD foto: " . $post['foto']);
                error_log("Current post foto_tambahan: " . ($post['foto_tambahan'] ?? 'NULL'));
                error_log("Will NOT delete foto_tambahan: " . ($post['foto_tambahan'] ?? 'NULL'));
                
                // CRITICAL: Verify we're deleting the correct file
                $filenameToDelete = $post['foto'];
                error_log("CRITICAL CHECK: About to delete foto with filename: " . $filenameToDelete);
                
                // Double check: make sure we're not accidentally deleting foto_tambahan
                if (!empty($post['foto_tambahan']) && $filenameToDelete === $post['foto_tambahan']) {
                    error_log("ERROR: foto and foto_tambahan have the same filename! Aborting delete to prevent wrong deletion.");
                    error_log("ERROR: foto: " . $post['foto']);
                    error_log("ERROR: foto_tambahan: " . $post['foto_tambahan']);
                } else {
                    $deleted = $this->deleteOldPhoto($filenameToDelete);
                    if (!$deleted) {
                        error_log("WARNING: Failed to delete old foto, but continuing with upload");
                    }
                    // Wait a bit to ensure file system has processed the deletion
                    usleep(100000); // 0.1 second
                }
            }
            
            $uploadResult = $this->uploadFotoBerita(Request::file('foto_upload'));
            if ($uploadResult) {
                $data['foto'] = $uploadResult;
            }
        } elseif (Request::post('foto') !== null && Request::post('foto') !== '') {
            // Only update foto if explicitly set via POST (not when updating foto_tambahan)
            // IMPORTANT: Don't set foto to null/empty if it's not being updated
            $newFoto = Request::post('foto');
            if ($newFoto !== '') {
                $data['foto'] = $newFoto;
            }
            // If foto is empty string, don't update it (preserve existing)
        } else {
            // No foto_upload and no foto in POST - don't touch foto field at all
            error_log("No foto_upload and no foto in POST - preserving existing foto");
        }
        // If foto is not in POST at all, don't touch it (preserve existing)

        // Log data before update for debugging
        error_log("UPDATE DATA: " . print_r($data, true));
        error_log("UPDATE ID: " . $id);
        
        $this->postModel->update($id, $data);
        
        // Verify foto_tambahan was saved
        $updatedPost = $this->postModel->findById($id);
        error_log("UPDATED POST foto_tambahan: " . ($updatedPost['foto_tambahan'] ?? 'NULL'));
        
        Response::with('success', 'Post berhasil diupdate')->redirect(url('/admin/posts'));
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

        // Delete all photos associated with this post
        // Delete foto_tambahan
        if (!empty($post['foto_tambahan'])) {
            $this->deleteOldPhoto($post['foto_tambahan']);
        }
        
        // Delete foto
        if (!empty($post['foto'])) {
            $this->deleteOldPhoto($post['foto']);
        }

        $this->postModel->delete($id);
        
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'Post berhasil dihapus']);
            return;
        }
        Response::with('success', 'Post berhasil dihapus')->redirect(url('/admin/posts'));
    }

    /**
     * Get absolute path to berita images directory
     */
    private function getBeritaImagePath() {
        $relativePath = __DIR__ . '/../../public/images/berita/';
        $absolutePath = realpath($relativePath);
        if (!$absolutePath) {
            // If realpath fails, resolve base path first
            $basePath = realpath(__DIR__ . '/../../public/images/');
            if ($basePath) {
                $absolutePath = $basePath . '/berita';
                if (!is_dir($absolutePath)) {
                    @mkdir($absolutePath, 0777, true);
                }
                $absolutePath = realpath($absolutePath);
            }
            if (!$absolutePath) {
                // Fallback to absolute path
                $absolutePath = '/Applications/XAMPP/xamppfiles/htdocs/smkweb/public/images/berita';
            }
        }
        return rtrim($absolutePath, '/') . '/';
    }
    
    /**
     * Delete old photo file - ensure it's really deleted
     * @param string $filename The filename to delete (must match exactly)
     */
    private function deleteOldPhoto($filename) {
        if (empty($filename)) {
            error_log("deleteOldPhoto: filename is empty, skipping");
            return false;
        }
        
        // Validate filename to prevent accidental deletion
        if (!is_string($filename) || strlen($filename) < 3) {
            error_log("deleteOldPhoto: Invalid filename format: " . $filename);
            return false;
        }
        
        $beritaPath = $this->getBeritaImagePath();
        $filePath = $beritaPath . $filename;
        
        error_log("=== DELETE OLD PHOTO ===");
        error_log("Filename to delete: " . $filename);
        error_log("Full path: " . $filePath);
        error_log("File exists: " . (file_exists($filePath) ? 'YES' : 'NO'));
        error_log("CRITICAL: This method should ONLY delete the exact filename provided: " . $filename);
        
        // Double check: verify the file path is correct and file exists
        if (!file_exists($filePath)) {
            error_log("File does not exist at path: " . $filePath);
            error_log("Checking if filename might be wrong...");
            // List files in directory to debug
            $dirFiles = glob($beritaPath . '*');
            error_log("Files in directory: " . print_r(array_map('basename', $dirFiles), true));
            return true; // Consider it success if file doesn't exist
        }
        
        if (!is_file($filePath)) {
            error_log("Path exists but is not a file: " . $filePath);
            return false;
        }
        
        // Verify filename matches before deleting (safety check)
        $actualFilename = basename($filePath);
        if ($actualFilename !== $filename) {
            error_log("ERROR: Filename mismatch! Expected: " . $filename . ", Got: " . $actualFilename);
            error_log("ERROR: Aborting delete to prevent wrong file deletion!");
            return false;
        }
        
        // Additional safety: Log what we're about to delete
        error_log("SAFETY CHECK: About to delete file: " . $filename);
        error_log("SAFETY CHECK: File path verified: " . $filePath);
        error_log("SAFETY CHECK: Filename matches: YES");
        
        // Try to delete
        $deleted = @unlink($filePath);
        
        // Verify it's really deleted
        $stillExists = file_exists($filePath);
        
        if ($deleted && !$stillExists) {
            error_log("Successfully deleted old photo: " . $filePath);
            return true;
        } else {
            error_log("Failed to delete old photo: " . $filePath);
            error_log("Deleted flag: " . ($deleted ? 'YES' : 'NO'));
            error_log("Still exists: " . ($stillExists ? 'YES' : 'NO'));
            
            // Try again with different method
            if ($stillExists) {
                @chmod($filePath, 0666); // Make writable
                $deleted2 = @unlink($filePath);
                $stillExists2 = file_exists($filePath);
                if ($deleted2 && !$stillExists2) {
                    error_log("Successfully deleted on second attempt: " . $filePath);
                    return true;
                } else {
                    error_log("Still failed to delete after second attempt: " . $filePath);
                    return false;
                }
            }
            return false;
        }
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
        // Validate file exists and has no errors
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            error_log("uploadFotoBerita: Invalid file upload. tmp_name: " . ($file['tmp_name'] ?? 'not set'));
            return null;
        }

        // Check upload error
        if (isset($file['error']) && $file['error'] !== UPLOAD_ERR_OK) {
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
            error_log("uploadFotoBerita: Upload error - " . $errorMsg);
            return null;
        }

        // Get consistent upload path using helper method
        $uploadDir = $this->getBeritaImagePath();
        
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                error_log("uploadFotoBerita: Failed to create directory: " . $uploadDir);
                return null;
            }
            @chmod($uploadDir, 0777);
        }
        
        // Ensure directory is writable (like absensi)
        if (!is_writable($uploadDir)) {
            @chmod($uploadDir, 0777);
            if (!is_writable($uploadDir)) {
                error_log("uploadFotoBerita: Directory is not writable: " . $uploadDir);
                return null;
            }
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            error_log("uploadFotoBerita: Invalid file extension: " . $ext);
            return null;
        }

        // Check file size (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            error_log("uploadFotoBerita: File too large: " . $file['size'] . " bytes");
            return null;
        }

        // Generate unique filename: berita-{timestamp}-{random}.{ext}
        $filename = 'berita-' . time() . '-' . uniqid() . '.' . $ext;
        // Ensure fullPath uses absolute path
        $targetPath = rtrim($uploadDir, '/') . '/' . $filename;
        error_log("uploadFotoBerita: Resolved upload path: " . $uploadDir);
        error_log("uploadFotoBerita: Full target path: " . $targetPath);

        // Try move_uploaded_file first
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            error_log("uploadFotoBerita: Successfully uploaded: " . $filename);
            return $filename;
        }
        
        // Fallback: try copy if move fails
        error_log("uploadFotoBerita: move_uploaded_file failed, trying copy...");
        if (copy($file['tmp_name'], $targetPath)) {
            @chmod($targetPath, 0644);
            error_log("uploadFotoBerita: File copied successfully (fallback method): " . $filename);
            return $filename;
        }

        error_log("uploadFotoBerita: Failed to move/copy uploaded file. tmp_name: " . $file['tmp_name'] . ", target: " . $targetPath);
        $lastError = error_get_last();
        if ($lastError) {
            error_log("uploadFotoBerita: PHP error: " . $lastError['message']);
        }
        return null;
    }
}


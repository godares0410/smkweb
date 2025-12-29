<?php

class PageController extends Controller {
    private $pageModel;

    public function __construct() {
        $this->pageModel = new Page();
    }

    public function index() {
        $pages = $this->pageModel->getAll();
        $this->view('admin.pages.index', ['pages' => $pages]);
    }

    public function create() {
        $this->view('admin.pages.create');
    }

    public function store() {
        $data = [
            'title' => Request::post('title'),
            'slug' => $this->generateSlug(Request::post('title')),
            'content' => Request::post('content'),
            'excerpt' => Request::post('excerpt'),
            'meta_title' => Request::post('meta_title'),
            'meta_description' => Request::post('meta_description'),
            'status' => Request::post('status', 'draft')
        ];

        $this->pageModel->create($data);
        Response::with('success', 'Halaman berhasil dibuat')->redirect(url('/admin/pages'));
    }

    public function edit($id) {
        $page = $this->pageModel->findById($id);
        if (!$page) {
            Response::with('error', 'Halaman tidak ditemukan')->redirect(url('/admin/pages'));
            return;
        }
        $this->view('admin.pages.edit', ['page' => $page]);
    }

    public function update($id) {
        $page = $this->pageModel->findById($id);
        if (!$page) {
            Response::with('error', 'Halaman tidak ditemukan')->redirect(url('/admin/pages'));
            return;
        }

        $data = [
            'title' => Request::post('title'),
            'slug' => $this->generateSlug(Request::post('title'), $id),
            'content' => Request::post('content'),
            'excerpt' => Request::post('excerpt'),
            'meta_title' => Request::post('meta_title'),
            'meta_description' => Request::post('meta_description'),
            'status' => Request::post('status', 'draft')
        ];

        $this->pageModel->update($id, $data);
        Response::with('success', 'Halaman berhasil diupdate')->redirect(url('/admin/pages'));
    }

    public function delete($id) {
        $page = $this->pageModel->findById($id);
        if (!$page) {
            if (Request::isAjax()) {
                $this->json(['success' => false, 'message' => 'Halaman tidak ditemukan'], 404);
                return;
            }
            Response::with('error', 'Halaman tidak ditemukan')->redirect(url('/admin/pages'));
            return;
        }

        $this->pageModel->delete($id);
        
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'Halaman berhasil dihapus']);
            return;
        }
        Response::with('success', 'Halaman berhasil dihapus')->redirect(url('/admin/pages'));
    }

    private function generateSlug($title, $excludeId = null) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        $existing = $this->pageModel->findBySlug($slug);
        if ($existing && $existing['id'] != $excludeId) {
            $slug .= '-' . time();
        }
        
        return $slug;
    }
}


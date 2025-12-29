<?php

class PageController extends Controller {
    private $pageModel;

    public function __construct() {
        $this->pageModel = new Page();
    }

    public function show($slug) {
        $page = $this->pageModel->findBySlug($slug);
        if (!$page) {
            http_response_code(404);
            echo "404 - Halaman tidak ditemukan";
            return;
        }

        $this->view('public.pages.show', ['page' => $page]);
    }
}


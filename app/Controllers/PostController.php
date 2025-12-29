<?php

class PostController extends Controller {
    private $postModel;

    public function __construct() {
        $this->postModel = new Post();
    }

    public function index() {
        $posts = $this->postModel->getPublished();
        $this->view('public.posts.index', ['posts' => $posts]);
    }

    public function show($slug) {
        $post = $this->postModel->findBySlug($slug);
        if (!$post) {
            http_response_code(404);
            echo "404 - Post tidak ditemukan";
            return;
        }

        // Increment views
        $this->postModel->incrementViews($post['id']);

        $this->view('public.posts.show', ['post' => $post]);
    }
}


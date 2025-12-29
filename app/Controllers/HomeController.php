<?php

class HomeController extends Controller {
    private $postModel;
    private $galleryModel;
    private $settingModel;

    public function __construct() {
        $this->postModel = new Post();
        $this->galleryModel = new Gallery();
        $this->settingModel = new Setting();
    }

    public function index() {
        $posts = $this->postModel->getPublished(); // Get all published posts
        $gallery = $this->galleryModel->getActive(); // Get all active gallery items
        $settings = $this->settingModel->getAll();
        
        // Get carousel items from carousel table
        $carouselModel = new Carousel();
        $carouselItems = $carouselModel->getActive(10); // Get up to 10 active items
        
        $this->view('public.home', [
            'posts' => $posts,
            'gallery' => $gallery,
            'settings' => $settings,
            'carouselItems' => $carouselItems
        ]);
    }

    public function redirectToBerita() {
        header('Location: ' . url('/') . '#berita');
        exit;
    }

    public function redirectToGaleri() {
        header('Location: ' . url('/') . '#galeri');
        exit;
    }

    public function redirectToKontak() {
        header('Location: ' . url('/') . '#kontak');
        exit;
    }
}


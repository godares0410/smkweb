<?php

class GalleryController extends Controller {
    private $galleryModel;

    public function __construct() {
        $this->galleryModel = new Gallery();
    }

    public function index() {
        $gallery = $this->galleryModel->getActive();
        $this->view('public.gallery.index', ['gallery' => $gallery]);
    }
}


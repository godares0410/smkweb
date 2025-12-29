<?php



class DashboardController extends Controller {
    private $postModel;
    private $pageModel;
    private $galleryModel;

    public function __construct() {
        $this->postModel = new Post();
        $this->pageModel = new Page();
        $this->galleryModel = new Gallery();
    }

    public function index() {
        $stats = [
            'posts' => count($this->postModel->getAll()),
            'pages' => count($this->pageModel->getAll()),
            'gallery' => count($this->galleryModel->getAll()),
            'published_posts' => count($this->postModel->getPublished())
        ];

        $recentPosts = array_slice($this->postModel->getAll(), 0, 5);

        $this->view('admin.dashboard', [
            'stats' => $stats,
            'recentPosts' => $recentPosts
        ]);
    }
}


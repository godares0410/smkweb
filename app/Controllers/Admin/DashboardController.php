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
        $allPosts = $this->postModel->getAll();
        $stats = [
            'posts' => count($allPosts),
            'pages' => count($this->pageModel->getAll()),
            'gallery' => count($this->galleryModel->getAll()),
            'published_posts' => count($this->postModel->getPublished())
        ];

        // Get recent posts, but verify they exist (in case of database inconsistencies)
        $recentPosts = array_slice($allPosts, 0, 5);
        $verifiedPosts = [];
        foreach ($recentPosts as $post) {
            if ($this->postModel->findById($post['id'])) {
                $verifiedPosts[] = $post;
            }
        }

        $this->view('admin.dashboard', [
            'stats' => $stats,
            'recentPosts' => $verifiedPosts
        ]);
    }
}


<?php

class AdminUserController extends Controller {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
    }

    public function index() {
        if (!Auth::isAdmin()) {
            Response::with('error', 'Akses ditolak')->redirect(url('/admin/dashboard'));
            return;
        }

        $admins = $this->adminModel->getAll();
        $this->view('admin.users.index', ['admins' => $admins]);
    }

    public function create() {
        if (!Auth::isAdmin()) {
            Response::with('error', 'Akses ditolak')->redirect(url('/admin/dashboard'));
            return;
        }
        $this->view('admin.users.create');
    }

    public function store() {
        if (!Auth::isAdmin()) {
            Response::with('error', 'Akses ditolak')->redirect(url('/admin/dashboard'));
            return;
        }

        $data = [
            'username' => Request::post('username'),
            'email' => Request::post('email'),
            'password' => Request::post('password'),
            'name' => Request::post('name'),
            'role' => Request::post('role', 'admin')
        ];

        // Check if username exists
        if ($this->adminModel->findByUsername($data['username'])) {
            Response::with('error', 'Username sudah digunakan')
                ->withInput(Request::post())
                ->redirect(url('/admin/users/create'));
            return;
        }

        // Check if email exists
        if ($this->adminModel->findByEmail($data['email'])) {
            Response::with('error', 'Email sudah digunakan')
                ->withInput(Request::post())
                ->redirect(url('/admin/users/create'));
            return;
        }

        $this->adminModel->create($data);
        Response::with('success', 'Admin berhasil ditambahkan')->redirect(url('/admin/users'));
    }

    public function edit($id) {
        if (!Auth::isAdmin()) {
            Response::with('error', 'Akses ditolak')->redirect(url('/admin/dashboard'));
            return;
        }

        $admin = $this->adminModel->findById($id);
        if (!$admin) {
            Response::with('error', 'Admin tidak ditemukan')->redirect(url('/admin/users'));
            return;
        }
        $this->view('admin.users.edit', ['admin' => $admin]);
    }

    public function update($id) {
        if (!Auth::isAdmin()) {
            Response::with('error', 'Akses ditolak')->redirect(url('/admin/dashboard'));
            return;
        }

        $admin = $this->adminModel->findById($id);
        if (!$admin) {
            Response::with('error', 'Admin tidak ditemukan')->redirect(url('/admin/users'));
            return;
        }

        $data = [
            'email' => Request::post('email'),
            'name' => Request::post('name'),
            'role' => Request::post('role', 'admin')
        ];

        // Check email uniqueness
        $existing = $this->adminModel->findByEmail($data['email']);
        if ($existing && $existing['id'] != $id) {
            Response::with('error', 'Email sudah digunakan')
                ->withInput(Request::post())
                ->redirect(url('/admin/users/' . $id . '/edit'));
            return;
        }

        // Update password if provided
        if (Request::post('password')) {
            $data['password'] = Request::post('password');
        }

        $this->adminModel->update($id, $data);
        Response::with('success', 'Admin berhasil diupdate')->redirect(url('/admin/users'));
    }

    public function delete($id) {
        if (!Auth::isAdmin()) {
            if (Request::isAjax()) {
                $this->json(['success' => false, 'message' => 'Akses ditolak'], 403);
                return;
            }
            Response::with('error', 'Akses ditolak')->redirect(url('/admin/dashboard'));
            return;
        }

        // Prevent deleting yourself
        if ($id == Auth::id()) {
            if (Request::isAjax()) {
                $this->json(['success' => false, 'message' => 'Tidak dapat menghapus akun sendiri'], 400);
                return;
            }
            Response::with('error', 'Tidak dapat menghapus akun sendiri')->redirect(url('/admin/users'));
            return;
        }

        $admin = $this->adminModel->findById($id);
        if (!$admin) {
            if (Request::isAjax()) {
                $this->json(['success' => false, 'message' => 'Admin tidak ditemukan'], 404);
                return;
            }
            Response::with('error', 'Admin tidak ditemukan')->redirect(url('/admin/users'));
            return;
        }

        $this->adminModel->delete($id);
        
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'Admin berhasil dihapus']);
            return;
        }
        Response::with('success', 'Admin berhasil dihapus')->redirect(url('/admin/users'));
    }
}


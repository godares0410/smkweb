<?php

class AuthController extends Controller {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
    }

    public function showLoginForm() {
        if (Auth::check()) {
            $this->redirect(url('/admin/dashboard'));
            return;
        }
        $this->view('admin.login', ['noLayout' => true]);
    }

    public function login() {
        $username = Request::post('username');
        $password = Request::post('password');

        if (empty($username) || empty($password)) {
            Response::with('error', 'Username dan password harus diisi')
                ->withInput(Request::post())
                ->redirect(url('/admin/login'));
            return;
        }

        $admin = $this->adminModel->findByUsername($username);
        if (!$admin) {
            Response::with('error', 'Username atau password salah')
                ->withInput(Request::post())
                ->redirect(url('/admin/login'));
            return;
        }

        if (!$this->adminModel->verifyPassword($password, $admin['password'])) {
            Response::with('error', 'Username atau password salah')
                ->withInput(Request::post())
                ->redirect(url('/admin/login'));
            return;
        }

        // Remove password from session
        unset($admin['password']);
        Auth::login($admin);
        
        Response::with('success', 'Login berhasil')->redirect(url('/admin/dashboard'));
    }

    public function logout() {
        Auth::logout();
        Response::with('success', 'Logout berhasil')->redirect(url('/admin/login'));
    }
}


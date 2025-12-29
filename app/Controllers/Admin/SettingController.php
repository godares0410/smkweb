<?php

class SettingController extends Controller {
    private $settingModel;

    public function __construct() {
        $this->settingModel = new Setting();
    }

    public function index() {
        $settings = $this->settingModel->getAll();
        $this->view('admin.settings.index', ['settings' => $settings]);
    }

    public function update() {
        $data = Request::post();
        
        foreach ($data as $key => $value) {
            if ($key !== 'csrf_token') {
                $this->settingModel->set($key, $value);
            }
        }

        Response::with('success', 'Pengaturan berhasil diupdate')->redirect(url('/admin/settings'));
    }
}


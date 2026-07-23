<?php

namespace App\Controllers;
use App\Libraries\Session;
use App\Libraries\Database;

class SettingController extends Controller {
    public function index() {
        if (!Session::get('user_id')) {
            header("Location: " . base_url('auth/login'));
            exit;
        }

        $this->view('settings/index', [
            'title' => 'Pengaturan Profil | KathaHealthy',
            'username' => Session::get('username')
        ]);
    }
}

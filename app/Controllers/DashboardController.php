<?php

namespace App\Controllers;
use App\Libraries\Session;
use App\Models\BloodPressureModel;

class DashboardController extends Controller {
    public function index() {
        // Protect route
        if (!Session::get('user_id')) {
            Session::setFlash('error', 'Silakan login terlebih dahulu.');
            header("Location: " . base_url('auth/login'));
            exit;
        }

        $bpModel = new BloodPressureModel();
        $userId = Session::get('user_id');
        
        $logs = $bpModel->getLogsByUser($userId);
        $latest = $bpModel->getLatestLog($userId);

        $this->view('dashboard/index', [
            'title' => 'Beranda | KathaHealthy',
            'username' => Session::get('username'),
            'role' => Session::get('role'),
            'logs' => $logs,
            'latest' => $latest
        ]);
    }
}

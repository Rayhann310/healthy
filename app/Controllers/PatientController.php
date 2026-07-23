<?php

namespace App\Controllers;
use App\Models\PatientModel;
use App\Libraries\Session;

class PatientController extends Controller {
    public function index() {
        if (!Session::get('user_id')) {
            header("Location: " . base_url('auth/login'));
            exit;
        }

        $model = new PatientModel();
        $patients = $model->getAllPatients();

        $this->view('patients/index', [
            'title' => 'Daftar Pasien | KathaHealthy',
            'username' => Session::get('username'),
            'patients' => $patients
        ]);
    }

    public function store() {
        header('Content-Type: application/json');
        
        if (!Session::get('user_id')) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $name = htmlspecialchars($_POST['name'] ?? '');
        $age = intval($_POST['age'] ?? 0);
        $gender = htmlspecialchars($_POST['gender'] ?? '');
        $contact = htmlspecialchars($_POST['contact'] ?? '');

        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'Nama wajib diisi.']);
            return;
        }

        $model = new PatientModel();
        $success = $model->insertPatient([
            'name' => $name,
            'age' => $age,
            'gender' => $gender,
            'contact' => $contact
        ]);

        if ($success) {
            // Get the newly inserted patient
            $latest = $model->getLatestPatient();
            echo json_encode(['success' => true, 'message' => 'Pasien berhasil ditambahkan!', 'data' => $latest]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan pasien.']);
        }
    }

    public function delete() {
        header('Content-Type: application/json');
        
        if (!Session::get('user_id')) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $id = intval($_POST['id'] ?? 0);
        
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID Pasien tidak valid.']);
            return;
        }

        $model = new PatientModel();
        if ($model->deletePatient($id)) {
            echo json_encode(['success' => true, 'message' => 'Pasien berhasil dihapus.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus pasien.']);
        }
    }
}

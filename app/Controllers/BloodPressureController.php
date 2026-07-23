<?php

namespace App\Controllers;

use App\Models\BloodPressureModel;
use App\Models\PatientModel;
use App\Libraries\Session;

class BloodPressureController extends Controller {
    public function index() {
        if (!Session::get('user_id')) {
            header("Location: " . base_url('auth/login'));
            exit;
        }

        $bpModel = new BloodPressureModel();
        $patientModel = new PatientModel();
        $userId = Session::get('user_id');
        $logs = $bpModel->getLogsByUser($userId);
        $patients = $patientModel->getAllPatients();

        $this->view('blood_pressure/index', [
            'title' => 'Tensi Darah | KathaHealthy',
            'username' => Session::get('username'),
            'logs' => $logs,
            'patients' => $patients
        ]);
    }

    public function store() {
        header('Content-Type: application/json');
        
        $userId = Session::get('user_id');
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'Tidak ada otorisasi.']);
            return;
        }

        $systolic = intval($_POST['systolic'] ?? 0);
        $diastolic = intval($_POST['diastolic'] ?? 0);
        $heart_rate = intval($_POST['heart_rate'] ?? 0);
        $oxygen_saturation = intval($_POST['oxygen_saturation'] ?? 0);
        $notes = htmlspecialchars($_POST['notes'] ?? '');
        $patient_id = intval($_POST['patient_id'] ?? 0);
        
        $measured_date = $_POST['measured_date'] ?? date('Y-m-d');
        $measured_time = $_POST['measured_time'] ?? date('H:i');
        $measured_at = $measured_date . ' ' . $measured_time . ':00';

        if ($systolic <= 0 || $diastolic <= 0) {
            echo json_encode(['success' => false, 'message' => 'Sistolik dan Diastolik harus diisi dengan angka valid.']);
            return;
        }
        
        if ($patient_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Harap pilih pasien terlebih dahulu.']);
            return;
        }

        $model = new BloodPressureModel();
        $success = $model->insertLog([
            'user_id' => $userId,
            'patient_id' => $patient_id,
            'systolic' => $systolic,
            'diastolic' => $diastolic,
            'heart_rate' => $heart_rate,
            'oxygen_saturation' => $oxygen_saturation,
            'notes' => $notes,
            'measured_at' => $measured_at
        ]);

        if ($success) {
            $latest = $model->getLatestLog($userId);
            $latest['formatted_date'] = date('d M Y, H:i', strtotime($latest['measured_at']));
            echo json_encode(['success' => true, 'message' => 'Data tensi berhasil disimpan!', 'data' => $latest]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data.']);
        }
    }
}

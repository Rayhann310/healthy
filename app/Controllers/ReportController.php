<?php

namespace App\Controllers;
use App\Libraries\Session;
use App\Models\BloodPressureModel;
use App\Models\PatientModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller {
    public function index() {
        if (!Session::get('user_id')) {
            header("Location: " . base_url('auth/login'));
            exit;
        }

        $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $_GET['end_date'] ?? date('Y-m-d');

        $bpModel = new BloodPressureModel();
        
        $logs = $bpModel->getFilteredLogs($startDate, $endDate);
        
        $totalMeasurements = count($logs);
        $highBpCount = 0;
        foreach($logs as $l) {
            if ($l['systolic'] >= 140 || $l['diastolic'] >= 90) {
                $highBpCount++;
            }
        }
        
        $this->view('reports/index', [
            'title' => 'Laporan & Statistik | KathaHealthy',
            'username' => Session::get('username'),
            'totalMeasurements' => $totalMeasurements,
            'highBpCount' => $highBpCount,
            'logs' => $logs,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    public function exportPdf() {
        if (!Session::get('user_id')) {
            header("Location: " . base_url('auth/login'));
            exit;
        }

        $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $_GET['end_date'] ?? date('Y-m-d');

        $bpModel = new BloodPressureModel();
        $logs = $bpModel->getFilteredLogs($startDate, $endDate);

        // Render HTML
        ob_start();
        extract(['logs' => $logs, 'start_date' => $startDate, 'end_date' => $endDate]);
        require APP_PATH . '/Views/reports/pdf.php';
        $html = ob_get_clean();

        // Setup DOMPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "Laporan_Tensi_" . $startDate . "_sd_" . $endDate . ".pdf";
        $dompdf->stream($filename, ["Attachment" => true]);
    }
}

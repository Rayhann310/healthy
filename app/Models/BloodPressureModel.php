<?php

namespace App\Models;

use PDO;

class BloodPressureModel extends Model {
    protected $table = 'blood_pressure_logs';

    public function __construct() {
        parent::__construct();
    }

    public function getLogsByUser($userId, $limit = 50) {
        $stmt = $this->db->prepare("
            SELECT b.*, p.name as patient_name 
            FROM {$this->table} b 
            LEFT JOIN patients p ON b.patient_id = p.id 
            WHERE b.user_id = ? 
            ORDER BY b.measured_at DESC LIMIT ?
        ");
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getFilteredLogs($startDate, $endDate) {
        $stmt = $this->db->prepare("
            SELECT b.*, p.name as patient_name 
            FROM {$this->table} b 
            LEFT JOIN patients p ON b.patient_id = p.id 
            WHERE DATE(b.measured_at) >= ? AND DATE(b.measured_at) <= ?
            ORDER BY b.measured_at DESC
        ");
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll();
    }

    public function getLatestLog($userId) {
        $stmt = $this->db->prepare("
            SELECT b.*, p.name as patient_name 
            FROM {$this->table} b 
            LEFT JOIN patients p ON b.patient_id = p.id 
            WHERE b.user_id = ? 
            ORDER BY b.measured_at DESC LIMIT 1
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }

    public function insertLog($data) {
        $sql = "INSERT INTO {$this->table} (user_id, patient_id, systolic, diastolic, heart_rate, oxygen_saturation, notes, measured_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['user_id'],
            $data['patient_id'] ?? null,
            $data['systolic'],
            $data['diastolic'],
            $data['heart_rate'] ?? null,
            $data['oxygen_saturation'] ?? null,
            $data['notes'] ?? null,
            $data['measured_at']
        ]);
    }
}

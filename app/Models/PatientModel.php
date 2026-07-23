<?php

namespace App\Models;
use PDO;

class PatientModel extends Model {
    protected $table = 'patients';

    public function __construct() {
        parent::__construct();
    }

    public function getAllPatients() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPatientById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getLatestPatient() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insertPatient($data) {
        $sql = "INSERT INTO {$this->table} (name, age, gender, contact) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['age'] ?? null,
            $data['gender'] ?? null,
            $data['contact'] ?? null
        ]);
    }

    public function deletePatient($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

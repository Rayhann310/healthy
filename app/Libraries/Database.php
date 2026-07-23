<?php

namespace App\Libraries;

use PDO;
use PDOException;
use Exception;

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $this->connect();
    }

    private function connect() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false, // Real prepared statements
        ];

        // Self Recovery Logic: Retry 3x
        $attempts = 0;
        $maxAttempts = 3;
        $connected = false;

        while ($attempts < $maxAttempts && !$connected) {
            try {
                $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
                $connected = true;
                
                // Self-Healing Auto Migration
                $this->autoMigrate();
                
            } catch (PDOException $e) {
                $attempts++;
                if ($attempts >= $maxAttempts) {
                    Logger::error("Database Connection Failed after $maxAttempts attempts: " . $e->getMessage());
                    // Maintenance Mode Fallback
                    die("System Maintenance: Unable to connect to database. Please try again later.");
                }
                sleep(1); // Wait 1 second before retry
            }
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    private function autoMigrate() {
        try {
            // Create users table if not exists
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                username VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'user') DEFAULT 'user',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->conn->exec($sql);

            // Self-healing schema: if table exists from previous step but lacks 'username', add it.
            $stmt = $this->conn->query("SHOW COLUMNS FROM users LIKE 'username'");
            if ($stmt->rowCount() == 0) {
                $this->conn->exec("ALTER TABLE users ADD COLUMN username VARCHAR(50) UNIQUE AFTER name");
                $this->conn->exec("ALTER TABLE users DROP COLUMN email");
            }
            
            // Create blood pressure logs table if not exists (with patient_id)
            $sqlBp = "CREATE TABLE IF NOT EXISTS blood_pressure_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                patient_id INT NULL,
                systolic INT NOT NULL,
                diastolic INT NOT NULL,
                heart_rate INT,
                oxygen_saturation INT,
                notes TEXT,
                measured_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )";
            $this->conn->exec($sqlBp);
            
            // Self-healing: Ensure new columns exist if the table was created before
            $stmt = $this->conn->query("SHOW COLUMNS FROM blood_pressure_logs LIKE 'patient_id'");
            if ($stmt->rowCount() == 0) {
                $this->conn->exec("ALTER TABLE blood_pressure_logs ADD COLUMN patient_id INT NULL AFTER user_id");
            }
            $stmt = $this->conn->query("SHOW COLUMNS FROM blood_pressure_logs LIKE 'oxygen_saturation'");
            if ($stmt->rowCount() == 0) {
                $this->conn->exec("ALTER TABLE blood_pressure_logs ADD COLUMN oxygen_saturation INT NULL AFTER heart_rate");
            }
            
            // Create patients table if not exists
            $sqlPatients = "CREATE TABLE IF NOT EXISTS patients (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                age INT,
                gender VARCHAR(20),
                contact VARCHAR(50),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
            $this->conn->exec($sqlPatients);

            // Seed default admin user if not exists
            $stmt = $this->conn->query("SELECT id FROM users WHERE username = 'admin'");
            if ($stmt && $stmt->rowCount() == 0) {
                $password = password_hash('admin123', PASSWORD_BCRYPT);
                $insert = $this->conn->prepare("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)");
                $insert->execute(['Administrator', 'admin', $password, 'admin']);
            }
        } catch (PDOException $e) {
            Logger::error("Auto-Migration failed: " . $e->getMessage());
        }
    }
}

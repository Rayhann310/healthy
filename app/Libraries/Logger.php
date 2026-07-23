<?php

namespace App\Libraries;

class Logger {
    private static function write($level, $message) {
        $logDir = STORAGE_PATH . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $date = date('Y-m-d');
        $time = date('H:i:s');
        $logFile = $logDir . '/system-' . $date . '.log';
        
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $url = $_SERVER['REQUEST_URI'] ?? 'UNKNOWN';
        
        $logMessage = "[$time] [$level] [IP: $ip] [URL: $url] - $message" . PHP_EOL;
        
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    public static function info($message) {
        self::write('INFO', $message);
    }

    public static function warning($message) {
        self::write('WARNING', $message);
    }

    public static function error($message) {
        self::write('ERROR', $message);
    }
}

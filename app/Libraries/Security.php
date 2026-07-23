<?php

namespace App\Libraries;

class Security {
    
    // Generate UUID v4
    public static function generateUUID() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    // Generate CSRF Token
    public static function generateCsrfToken() {
        if (!Session::get('csrf_token')) {
            Session::set('csrf_token', bin2hex(random_bytes(32)));
        }
        return Session::get('csrf_token');
    }

    // Verify CSRF Token
    public static function verifyCsrfToken($token) {
        $stored = Session::get('csrf_token');
        if (!$stored || !hash_equals($stored, $token)) {
            // Self-Healing Session/CSRF -> Refresh if invalid might mean timeout
            Logger::warning("Invalid CSRF Token. Possible session timeout.");
            http_response_code(403);
            die("CSRF Token Verification Failed.");
        }
        return true;
    }

    // Basic XSS Filter
    public static function sanitize($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitize($value);
            }
            return $data;
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
}

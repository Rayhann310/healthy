<?php

namespace App\Libraries;

class Session {
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            // Secure Session Cookies
            ini_set('session.cookie_httponly', 1);
            // ini_set('session.cookie_secure', 1); // Enable in production with HTTPS
            ini_set('session.use_only_cookies', 1);
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy() {
        session_unset();
        session_destroy();
    }

    public static function refresh() {
        session_regenerate_id(true);
    }

    public static function setFlash($key, $message) {
        $_SESSION['_flash'][$key] = $message;
    }

    public static function getFlash($key) {
        if (isset($_SESSION['_flash'][$key])) {
            $msg = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $msg;
        }
        return null;
    }
}

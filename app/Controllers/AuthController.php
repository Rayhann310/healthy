<?php

namespace App\Controllers;
use App\Libraries\Database;
use App\Libraries\Session;

class AuthController extends Controller {
    public function login() {
        // If user wants to reset fast login manually
        if (isset($_GET['reset_fast_login'])) {
            setcookie('fast_login_username', '', time() - 3600, "/");
            header("Location: " . base_url('auth/login'));
            exit;
        }

        $fastLoginUser = $_COOKIE['fast_login_username'] ?? null;
        $error = Session::getFlash('error');

        $this->view('auth/login', [
            'title' => 'Sign In | KathaHealthy',
            'fastLoginUser' => $fastLoginUser,
            'error' => $error
        ]);
    }

    public function processLogin() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Success
            Session::set('user_id', $user['id']);
            Session::set('username', $user['username']);
            Session::set('role', $user['role']);
            
            // Set fast login cookie (valid for 30 days)
            setcookie('fast_login_username', $user['username'], time() + (86400 * 30), "/");
            
            // Redirect to dashboard (mock)
            header("Location: " . base_url('dashboard'));
            exit;
        } else {
            // Failed
            Session::setFlash('error', 'Username atau password salah.');
            header("Location: " . base_url('auth/login'));
            exit;
        }
    }

    public function logout() {
        Session::destroy();
        header("Location: " . base_url('auth/login'));
        exit;
    }
}

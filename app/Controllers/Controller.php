<?php

namespace App\Controllers;

class Controller {
    // Render View Method
    protected function view($view, $data = []) {
        // Extract data to variables
        if (!empty($data)) {
            extract($data);
        }
        
        $viewFile = APP_PATH . '/Views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View $view not found!");
        }
    }
    
    // Send JSON Response
    protected function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

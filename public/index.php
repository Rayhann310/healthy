<?php

// Front Controller - KathaHealthy Smart Blood Pressure Monitoring System
// PHP Native 8.3 MVC

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('STORAGE_PATH', ROOT_PATH . '/storage');

// Autoloader implementation (PSR-4 simplified)
spl_autoload_register(function ($className) {
    // Convert namespace to full file path
    // e.g., App\Controllers\HomeController -> app/Controllers/HomeController.php
    
    // Remove "App\" from the beginning
    $prefix = 'App\\';
    $len = strlen($prefix);
    if (strncmp($prefix, $className, $len) !== 0) {
        return; // Move to next registered autoloader
    }
    
    $relativeClass = substr($className, $len);
    $file = APP_PATH . '/' . str_replace('\\', '/', $relativeClass) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Load Configuration
require_once APP_PATH . '/Config/config.php';
require_once APP_PATH . '/Config/database.php';

// Composer Autoload
if (file_exists(dirname(APP_PATH) . '/vendor/autoload.php')) {
    require_once dirname(APP_PATH) . '/vendor/autoload.php';
}

// Initialize core components
\App\Libraries\Session::init();

// Load Routes
$router = new \App\Libraries\Router();
require_once APP_PATH . '/Routes/web.php';

// Dispatch Request
$router->dispatch();

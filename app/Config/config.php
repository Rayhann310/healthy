<?php

// Dynamic Base URL logic
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
// Remove '/public' if it exists to get the root of the app URL
$scriptName = str_replace('\\', '/', $scriptName);
$scriptName = preg_replace('/\/public$/i', '', $scriptName); 

define('BASE_URL', $protocol . $domainName . $scriptName);
define('APP_NAME', 'KathaHealthy');
define('APP_ENV', 'development'); // 'development' or 'production'

// Helper function to get base URL
if (!function_exists('base_url')) {
    function base_url($path = '') {
        return BASE_URL . '/' . ltrim($path, '/');
    }
}

<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\BloodPressureController;
use App\Controllers\PatientController;
use App\Controllers\ReportController;
use App\Controllers\SettingController;

// Note: $router is available from index.php

$router->get('/', [HomeController::class, 'index']);
$router->get('/auth/login', [AuthController::class, 'login']);
$router->post('/auth/login-process', [AuthController::class, 'processLogin']);
$router->get('/auth/logout', [AuthController::class, 'logout']);
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/blood-pressure', [BloodPressureController::class, 'index']);
$router->post('/bp/store', [BloodPressureController::class, 'store']);
$router->get('/patients', [PatientController::class, 'index']);
$router->post('/patients/store', [PatientController::class, 'store']);
$router->post('/patients/delete', [PatientController::class, 'delete']);
$router->get('/reports', [ReportController::class, 'index']);
$router->get('/reports/pdf', [ReportController::class, 'exportPdf']);
$router->get('/settings', [SettingController::class, 'index']);

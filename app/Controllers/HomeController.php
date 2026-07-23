<?php

namespace App\Controllers;

class HomeController extends Controller {
    public function index() {
        $this->view('home/index', [
            'title' => 'KathaHealthy | Smart Blood Pressure Monitor'
        ]);
    }
}

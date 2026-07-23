<?php

namespace App\Models;

use App\Libraries\Database;
use PDO;

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Basic shared repository methods can go here, though specific Repositories will handle business logic
}

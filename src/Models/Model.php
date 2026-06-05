<?php

declare(strict_types=1);

namespace Models;

use Core\Database;
use PDO;

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        // Każdy model dziedziczący po tej klasie od razu ma dostęp do połączenia z bazą
        $this->db = Database::getInstance()->getConnection();
    }
}
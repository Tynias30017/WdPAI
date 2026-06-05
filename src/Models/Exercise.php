<?php

declare(strict_types=1);

namespace Models;

use PDO;

class Exercise extends Model
{
    // Pobiera wszystkie dostępne ćwiczenia (słownik)
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM exercises ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
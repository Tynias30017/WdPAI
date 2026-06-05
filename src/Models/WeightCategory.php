<?php

declare(strict_types=1);

namespace Models;

use PDO;

class WeightCategory extends Model
{
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM weight_categories ORDER BY max_weight ASC");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
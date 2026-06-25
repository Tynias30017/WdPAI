<?php

declare(strict_types=1);

namespace Models;

use PDO;

class Exercise extends Model
{
    // Pobiera wszystkie dostępne ćwiczenia
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM exercises ORDER BY category DESC, name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Dodaje nowe ćwiczenie do słownika
    public function create(string $name, string $muscleGroup, string $equipmentType, string $category): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO exercises (name, muscle_group, equipment_type, category) 
            VALUES (:name, :muscle_group, :equipment_type, :category)
        ");
        
        return $stmt->execute([
            ':name' => $name,
            ':muscle_group' => $muscleGroup,
            ':equipment_type' => $equipmentType,
            ':category' => $category
        ]);
    }

    // Sprawdza czy ćwiczenie o danej nazwie już istnieje
    public function exists(string $name): bool
    {
        $stmt = $this->db->prepare("SELECT 1 FROM exercises WHERE LOWER(name) = LOWER(:name)");
        $stmt->execute([':name' => $name]);
        return (bool)$stmt->fetchColumn();
    }
}
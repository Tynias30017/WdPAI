<?php

declare(strict_types=1);

namespace Models;

use PDO;

class Workout extends Model
{
    // Pobiera wszystkie treningi danego użytkownika
    public function getUserWorkouts(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM workouts 
            WHERE user_id = :user_id 
            ORDER BY workout_date DESC, created_at DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tworzy nowy pusty trening i zwraca jego ID
    public function create(int $userId, string $date, string $notes = ''): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO workouts (user_id, workout_date, notes) 
            VALUES (:user_id, :workout_date, :notes) 
            RETURNING id
        ");
        
        $stmt->execute([
            ':user_id' => $userId,
            ':workout_date' => $date,
            ':notes' => $notes
        ]);
        
        // Zwracamy ID nowo utworzonego wiersza
        return (int)$stmt->fetchColumn();
    }
}
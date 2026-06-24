<?php

declare(strict_types=1);

namespace Models;

use PDO;

class WorkoutSet extends Model
{
    // Dodaje nową serię do treningu
    public function add(int $workoutId, int $exerciseId, float $weight, int $reps): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO workout_sets (workout_id, exercise_id, weight, reps) 
            VALUES (:workout_id, :exercise_id, :weight, :reps)
        ");
        
        return $stmt->execute([
            ':workout_id' => $workoutId,
            ':exercise_id' => $exerciseId,
            ':weight' => $weight,
            ':reps' => $reps
        ]);
    }

    // Pobiera wszystkie serie dla konkretnego treningu (używamy JOIN!)
    public function getByWorkout(int $workoutId): array
    {
        $stmt = $this->db->prepare("
            SELECT ws.*, e.name AS exercise_name 
            FROM workout_sets ws
            JOIN exercises e ON ws.exercise_id = e.id
            WHERE ws.workout_id = :workout_id
            ORDER BY ws.id ASC
        ");
        $stmt->execute([':workout_id' => $workoutId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Usuwa serię o konkretnym ID
    public function delete(int $setId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM workout_sets WHERE id = :id");
        return $stmt->execute([':id' => $setId]);
    }

    // Pobiera pojedynczą serię po ID
    public function getById(int $setId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM workout_sets WHERE id = :id");
        $stmt->execute([':id' => $setId]);
        $set = $stmt->fetch(PDO::FETCH_ASSOC);
        return $set ?: null;
    }
}
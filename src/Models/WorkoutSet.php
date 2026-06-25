<?php

declare(strict_types=1);

namespace Models;

use PDO;

class WorkoutSet extends Model
{
    // Dodaje nową serię do treningu z parametrami RPE oraz typem serii
    public function add(int $workoutId, int $exerciseId, float $weight, int $reps, ?float $rpe = null, string $setType = 'normal'): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO workout_sets (workout_id, exercise_id, weight, reps, rpe, set_type) 
            VALUES (:workout_id, :exercise_id, :weight, :reps, :rpe, :set_type)
        ");
        
        return $stmt->execute([
            ':workout_id' => $workoutId,
            ':exercise_id' => $exerciseId,
            ':weight' => $weight,
            ':reps' => $reps,
            ':rpe' => $rpe,
            ':set_type' => $setType
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

    // Pobiera wykonane serie dla danego ćwiczenia z ostatniego treningu użytkownika (Historia w locie)
    public function getLastSetsForExercise(int $userId, int $exerciseId, int $currentWorkoutId): array
    {
        // Zapytanie CTE wybiera ostatni trening użytkownika (przed bieżącym), na którym wykonywano to ćwiczenie
        $stmt = $this->db->prepare("
            WITH last_workout AS (
                SELECT w.id, w.workout_date
                FROM workouts w
                JOIN workout_sets ws ON ws.workout_id = w.id
                WHERE w.user_id = :user_id 
                  AND ws.exercise_id = :exercise_id
                  AND w.id != :current_workout_id
                ORDER BY w.workout_date DESC, w.created_at DESC
                LIMIT 1
            )
            SELECT ws.weight, ws.reps, ws.rpe, ws.set_type, lw.workout_date
            FROM workout_sets ws
            JOIN last_workout lw ON ws.workout_id = lw.id
            ORDER BY ws.id ASC
        ");
        
        $stmt->execute([
            ':user_id' => $userId,
            ':exercise_id' => $exerciseId,
            ':current_workout_id' => $currentWorkoutId
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
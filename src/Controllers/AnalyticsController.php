<?php

declare(strict_types=1);

namespace Controllers;

use Core\View;
use Models\WorkoutSet;
use Models\Exercise;

class AnalyticsController
{
    public function __construct()
    {
        // Sprawdzamy czy użytkownik jest zalogowany
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    }

    // Widok główny statystyk i wykresów
    public function index(): void
    {
        $userId = (int)$_SESSION['user_id'];
        
        $setModel = new WorkoutSet();
        $exerciseModel = new Exercise();
        
        // Pobieramy rekordy osobiste zalogowanego użytkownika
        $personalRecords = $setModel->getPersonalRecords($userId);
        
        // Pobieramy wszystkie ćwiczenia do dropdowna na wykresie
        $exercises = $exerciseModel->getAll();
        
        View::render('analytics/index', [
            'title' => 'Statystyki i Analiza Postępów',
            'personalRecords' => $personalRecords,
            'exercises' => $exercises
        ]);
    }

    // Asynchroniczne pobieranie danych do wykresów (Fetch API)
    public function getChartData(): void
    {
        header('Content-Type: application/json');
        
        $userId = (int)$_SESSION['user_id'];
        $exerciseId = (int)($_GET['exercise_id'] ?? 0);
        
        if (!$exerciseId) {
            http_response_code(400);
            echo json_encode(['error' => 'Brak identyfikatora ćwiczenia.']);
            return;
        }
        
        $setModel = new WorkoutSet();
        $progressionData = $setModel->getProgressionData($userId, $exerciseId);
        
        // Przekształcamy dane do prostszego formatu do wykresu
        $chartPoints = [];
        foreach ($progressionData as $row) {
            $chartPoints[] = [
                'date' => $row['workout_date'],
                'workout_name' => $row['workout_name'],
                'max_weight' => (float)$row['max_weight'],
                'max_1rm' => (float)$row['max_1rm'],
                'total_volume' => (float)$row['total_volume']
            ];
        }
        
        echo json_encode([
            'success' => true,
            'data' => $chartPoints
        ]);
    }
}

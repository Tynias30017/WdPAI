<?php

declare(strict_types=1);

namespace Controllers;

use Models\Exercise;
use Core\View;

class ExerciseController
{
    public function __construct()
    {
        // Wszystkie akcje katalogu ćwiczeń wymagają zalogowania
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    }

    // Wyświetlanie bazy ćwiczeń z opcjonalnym filtrowaniem
    public function index(): void
    {
        $exerciseModel = new Exercise();
        $exercises = $exerciseModel->getAll();

        // Pobranie unikalnych grup mięśniowych i sprzętu dla filtrów w widoku
        $muscleGroups = array_filter(array_unique(array_column($exercises, 'muscle_group')));
        $equipmentTypes = array_filter(array_unique(array_column($exercises, 'equipment_type')));

        View::render('exercises/index', [
            'title' => 'Baza Ćwiczeń - Katalog',
            'exercises' => $exercises,
            'muscleGroups' => $muscleGroups,
            'equipmentTypes' => $equipmentTypes,
            'success' => isset($_GET['success']),
            'error' => $_GET['error'] ?? null
        ]);
    }

    // Zapisywanie nowego ćwiczenia (POST)
    public function store(): void
    {
        $name = trim($_POST['name'] ?? '');
        $muscleGroup = trim($_POST['muscle_group'] ?? '');
        $equipmentType = trim($_POST['equipment_type'] ?? '');
        $category = trim($_POST['category'] ?? 'accessory');

        if (empty($name) || empty($muscleGroup) || empty($equipmentType)) {
            header("Location: /exercises?error=" . urlencode("Wszystkie pola są wymagane!"));
            exit;
        }

        if (!in_array($category, ['main', 'accessory', 'warmup'])) {
            header("Location: /exercises?error=" . urlencode("Nieprawidłowa kategoria ćwiczenia."));
            exit;
        }

        $exerciseModel = new Exercise();

        // Sprawdzamy unikalność
        if ($exerciseModel->exists($name)) {
            header("Location: /exercises?error=" . urlencode("Ćwiczenie o tej nazwie już istnieje w bazie!"));
            exit;
        }

        $exerciseModel->create($name, $muscleGroup, $equipmentType, $category);

        header("Location: /exercises?success=1");
        exit;
    }
}

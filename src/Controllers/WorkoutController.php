<?php

declare(strict_types=1);

namespace Controllers;

use Models\Workout;
use Models\Exercise;
use Models\WorkoutSet;
use Core\View;

class WorkoutController
{
    // Konstruktor do zabezpieczania dostępu
    public function __construct()
    {
        // Jeśli użytkownik nie jest zalogowany (brak ID w sesji), nie pozwalamy mu wejść w treningi
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    }

    // Wyświetlanie listy treningów zalogowanego użytkownika (GET)
    public function index(): void
    {
        $workoutModel = new Workout();
        $workouts = $workoutModel->getUserWorkouts($_SESSION['user_id']);

        View::render('workouts/index', [
            'title' => 'Moje Treningi',
            'workouts' => $workouts
        ]);
    }

    // Wyświetlanie formularza tworzenia nowego treningu (GET)
    public function create(): void
    {
        View::render('workouts/create', [
            'title' => 'Dodaj nowy trening'
        ]);
    }

    // Zapisywanie nowego treningu (POST)
    public function store(): void
    {
        $date = $_POST['workout_date'] ?? '';
        $notes = trim($_POST['notes'] ?? '');

        if (empty($date)) {
            die("Błąd: Data treningu jest wymagana!");
        }

        $workoutModel = new Workout();
        $workoutId = $workoutModel->create($_SESSION['user_id'], $date, $notes);

        // Po utworzeniu od razu przechodzimy do widoku szczegółów tego treningu!
        header("Location: /workout?id=" . $workoutId);
        exit;
    }

    // Wyświetlanie szczegółów pojedynczego treningu i formularza dodawania serii (GET)
    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        if (!$id) {
            die("Błąd: Brak ID treningu.");
        }

        $workoutModel = new Workout();
        
        // Zabezpieczenie (IDOR): sprawdzamy, czy ten trening należy do zalogowanego usera
        $workout = $workoutModel->getByIdAndUser($id, $_SESSION['user_id']);
        if (!$workout) {
            die("Błąd: Trening nie istnieje lub nie masz do niego dostępu.");
        }

        // Pobieramy słownik ćwiczeń do pola <select>
        $exerciseModel = new Exercise();
        $exercises = $exerciseModel->getAll();

        // Pobieramy już dodane serie do tego treningu
        $setModel = new WorkoutSet();
        $sets = $setModel->getByWorkout($id);

        View::render('workouts/show', [
            'title' => 'Szczegóły treningu - ' . $workout['workout_date'],
            'workout' => $workout,
            'exercises' => $exercises,
            'sets' => $sets
        ]);
    }

    // Obsługa dodawania nowej serii do treningu (POST)
    public function addSet(): void
    {
        $workoutId = (int)($_POST['workout_id'] ?? 0);
        $exerciseId = (int)($_POST['exercise_id'] ?? 0);
        $weight = (float)($_POST['weight'] ?? 0);
        $reps = (int)($_POST['reps'] ?? 0);

        // Ponowna autoryzacja - czy użytkownik ma prawo modyfikować ten trening?
        $workoutModel = new Workout();
        if (!$workoutModel->getByIdAndUser($workoutId, $_SESSION['user_id'])) {
            die("Błąd: Brak dostępu.");
        }

        $setModel = new WorkoutSet();
        $setModel->add($workoutId, $exerciseId, $weight, $reps);

        // Wracamy na stronę szczegółów treningu
        header("Location: /workout?id=" . $workoutId);
        exit;
    }
}
<?php

declare(strict_types=1);

// Uruchamiamy mechanizm sesji w PHP (musi być na samym początku!)
session_start();

// Wymagamy pliku z klasą Router. Wkrótce dodamy autoloader, żeby nie pisać tego ręcznie.
// Inicjujemy nasz Autoloader (to jedyny require_once, jakiego będziemy potrzebować!)
require_once __DIR__ . '/Core/Autoloader.php';
\Core\Autoloader::register();

// Wczytanie konfiguracji z pliku .env
\Core\Config::load(__DIR__ . '/.env');

use Core\Router;
use Controllers\HomeController;
use Controllers\AuthController;
use Controllers\WorkoutController;

$router = new Router();

// Rejestrujemy trasy
$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/register', [AuthController::class, 'register']);
$router->add('POST', '/register', [AuthController::class, 'store']);
$router->add('GET', '/login', [AuthController::class, 'login']);
$router->add('POST', '/login', [AuthController::class, 'authenticate']);
$router->add('GET', '/logout', [AuthController::class, 'logout']);

// Trasy treningowe
$router->add('GET', '/workouts', [WorkoutController::class, 'index']);
$router->add('GET', '/workouts/create', [WorkoutController::class, 'create']);
$router->add('POST', '/workouts/create', [WorkoutController::class, 'store']);
$router->add('GET', '/workout', [WorkoutController::class, 'show']);
$router->add('POST', '/workout/add-set', [WorkoutController::class, 'addSet']);

// Zmienne $_SERVER zawierają dane o żądaniu z przeglądarki
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

try {
    $router->dispatch($uri, $method);
} catch (Exception $e) {
    echo "Błąd: " . $e->getMessage();
}
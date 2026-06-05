<?php

declare(strict_types=1);

// Uruchamiamy mechanizm sesji w PHP (musi być na samym początku!)
session_start();

// Wymagamy pliku z klasą Router. Wkrótce dodamy autoloader, żeby nie pisać tego ręcznie.
// Inicjujemy nasz Autoloader (to jedyny require_once, jakiego będziemy potrzebować!)
require_once __DIR__ . '/Core/Autoloader.php';
\Core\Autoloader::register();

use Core\Router;
use Controllers\HomeController;
use Controllers\AuthController;

$router = new Router();

// Rejestrujemy trasy
$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/register', [AuthController::class, 'register']);
$router->add('POST', '/register', [AuthController::class, 'store']);
$router->add('GET', '/login', [AuthController::class, 'login']);
$router->add('POST', '/login', [AuthController::class, 'authenticate']);
$router->add('GET', '/logout', [AuthController::class, 'logout']);

// Zmienne $_SERVER zawierają dane o żądaniu z przeglądarki
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

try {
    $router->dispatch($uri, $method);
} catch (Exception $e) {
    echo "Błąd: " . $e->getMessage();
}
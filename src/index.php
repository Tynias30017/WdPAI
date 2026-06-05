<?php

declare(strict_types=1);

// Wymagamy pliku z klasą Router. Wkrótce dodamy autoloader, żeby nie pisać tego ręcznie.
// Inicjujemy nasz Autoloader (to jedyny require_once, jakiego będziemy potrzebować!)
require_once __DIR__ . '/Core/Autoloader.php';
\Core\Autoloader::register();

use Core\Router;
use Controllers\HomeController;

$router = new Router();

// Rejestrujemy naszą pierwszą trasę
$router->add('GET', '/', [HomeController::class, 'index']);

// Zmienne $_SERVER zawierają dane o żądaniu z przeglądarki
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

try {
    $router->dispatch($uri, $method);
} catch (Exception $e) {
    echo "Błąd: " . $e->getMessage();
}
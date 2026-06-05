<?php

declare(strict_types=1);

// Wymagamy pliku z klasą Router. Wkrótce dodamy autoloader, żeby nie pisać tego ręcznie.
require_once __DIR__ . '/Core/Router.php';

use Core\Router;

$router = new Router();

// Zmienne $_SERVER zawierają dane o żądaniu z przeglądarki
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

try {
    $router->dispatch($uri, $method);
} catch (Exception $e) {
    echo "Błąd: " . $e->getMessage();
}
<?php

declare(strict_types=1);

namespace Core;

class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register(function (string $class) {
            // Zamieniamy backslashe z namespace (np. Controllers\HomeController) 
            // na slashe ze ścieżki katalogów (np. Controllers/HomeController)
            $path = str_replace('\\', '/', $class);
            
            // Definiujemy ścieżkę bazową (katalog src/)
            $file = dirname(__DIR__) . '/' . $path . '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
}
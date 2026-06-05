<?php

declare(strict_types=1);

namespace Core;

class View
{
    public static function render(string $viewPath, array $data = []): void
    {
        // 1. Odkodowanie zmiennych z tablicy $data
        // extract() sprawia, że jeśli przekażemy ['title' => 'Cześć'], 
        // to w widoku będzie dostępna zmienna $title.
        extract($data);

        // 2. Sklejenie ścieżki do pliku widoku
        $fullPath = dirname(__DIR__) . '/Views/' . $viewPath . '.php';

        // 3. Sprawdzenie, czy widok istnieje, a jeśli tak, to jego załadowanie
        if (file_exists($fullPath)) {
            require $fullPath;
        } else {
            throw new \Exception("Nie znaleziono pliku widoku: $viewPath");
        }
    }
}
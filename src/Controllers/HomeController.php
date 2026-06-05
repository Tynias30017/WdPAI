<?php

declare(strict_types=1);

namespace Controllers;

use Models\WeightCategory;

class HomeController
{
    public function index(): void
    {
        // 1. Tworzymy obiekt modelu
        $categoryModel = new WeightCategory();
        
        // 2. Pobieramy dane z bazy
        $categories = $categoryModel->getAll();

        // 3. (Tymczasowo) Wyświetlamy dane bezpośrednio w kontrolerze 
        // W następnym kroku przeniesiemy to do warstwy V (View)
        echo "<h1>Witaj w aplikacji do śledzenia treningów Trójboju Siłowego!</h1>";
        echo "<h2>Oficjalne kategorie wagowe IPF:</h2>";
        
        echo "<ul>";
        foreach ($categories as $category) {
            echo "<li>" . htmlspecialchars($category['name']) . " (Max: " . htmlspecialchars((string)$category['max_weight']) . " kg)</li>";
        }
        echo "</ul>";
    }
}
<?php

declare(strict_types=1);

namespace Controllers;

use Models\WeightCategory;
use Core\View;

class HomeController
{
    public function index(): void
    {
        $categoryModel = new WeightCategory();
        $categories = $categoryModel->getAll();

        // Używamy naszej nowej klasy View do wyrenderowania HTML-a,
        // przekazując mu zmienne $title oraz $categories w tablicy.
        View::render('home/index', [
            'title' => 'Witaj w aplikacji do śledzenia treningów Trójboju Siłowego!',
            'categories' => $categories
        ]);
    }
}
<?php

declare(strict_types=1);

namespace Controllers;

class HomeController
{
    public function index(): void
    {
        echo "<h1>Witaj w aplikacji do śledzenia treningów Trójboju Siłowego!</h1>";
        echo "<p>To jest strona główna obsłużona przez HomeController.</p>";
    }
}
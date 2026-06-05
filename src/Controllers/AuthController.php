<?php

declare(strict_types=1);

namespace Controllers;

use Models\User;
use Core\View;

class AuthController
{
    // Metoda wyświetlająca formularz rejestracji (GET)
    public function register(): void
    {
        View::render('auth/register', [
            'title' => 'Rejestracja - Trójbój Siłowy'
        ]);
    }

    // Metoda przetwarzająca dane z formularza (POST)
    public function store(): void
    {
        // 1. Pobranie danych (zabezpieczenie przed brakiem klucza w tablicy za pomocą operatora ??)
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // 2. Bardzo prosta walidacja
        if (empty($email) || empty($password)) {
            die("Błąd: Wypełnij wszystkie pola!"); // W przyszłości zrobimy to ładniej, przez widok
        }

        $userModel = new User();

        // 3. Sprawdzenie czy email już istnieje
        if ($userModel->findByEmail($email)) {
            die("Błąd: Ten adres e-mail jest już zajęty!");
        }

        // 4. BEZPIECZEŃSTWO: Hashowanie hasła! 
        // Używamy wbudowanej w PHP funkcji, która stosuje najnowocześniejsze algorytmy (domyślnie BCRYPT/Argon2)
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // 5. Zapis do bazy
        if ($userModel->create($email, $passwordHash)) {
            // Po udanej rejestracji przekierowujemy użytkownika na stronę główną (wkrótce na logowanie)
            header("Location: /");
            exit;
        } else {
            die("Błąd: Nie udało się utworzyć konta.");
        }
    }
}
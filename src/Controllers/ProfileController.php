<?php

declare(strict_types=1);

namespace Controllers;

use Models\UserProfile;
use Core\View;

class ProfileController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    }

    public function show(): void
    {
        $profileModel = new UserProfile();
        $profile = $profileModel->getByUserId($_SESSION['user_id']);

        // Jeśli brak profilu (np. stary użytkownik zarejestrowany przed wdrożeniem transakcji),
        // tworzymy pusty domyślny profil w locie.
        if (!$profile) {
            $profileModel->upsert($_SESSION['user_id'], '', '', 'male', 0.0);
            $profile = $profileModel->getByUserId($_SESSION['user_id']);
        }

        View::render('profile/show', [
            'title' => 'Mój Profil - Trójbój Siłowy',
            'profile' => $profile,
            'success' => isset($_GET['success'])
        ]);
    }

    public function update(): void
    {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $gender = trim($_POST['gender'] ?? 'male');
        $bodyWeight = (float)($_POST['body_weight'] ?? 0.0);

        if ($bodyWeight < 0) {
            throw new \Exception("Waga ciała nie może być ujemna!", 400);
        }

        $profileModel = new UserProfile();
        $profileModel->upsert($_SESSION['user_id'], $firstName, $lastName, $gender, $bodyWeight);

        header("Location: /profile?success=1");
        exit;
    }
}

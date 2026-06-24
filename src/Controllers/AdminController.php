<?php

declare(strict_types=1);

namespace Controllers;

use Core\Database;
use Core\View;
use PDO;

class AdminController
{
    public function __construct()
    {
        // Sprawdzamy czy użytkownik jest zalogowany i czy jest administratorem
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        if (($_SESSION['user_role'] ?? '') !== 'admin') {
            // Wyrzucamy wyjątek 403 (Zabronione), który zostanie obsłużony przez nasz globalny router/error handler!
            throw new \Exception("Brak uprawnień. Dostęp tylko dla administratorów.", 403);
        }
    }

    // Wyświetlanie listy wszystkich użytkowników
    public function users(): void
    {
        $db = Database::getInstance()->getConnection();
        
        // Pobieramy dane użytkowników oraz ich profilowe i statystyki za pomocą JOIN-ów
        $stmt = $db->query("
            SELECT 
                u.id, 
                u.email, 
                u.role, 
                u.created_at,
                up.first_name, 
                up.last_name, 
                up.body_weight,
                wc.name as weight_category
            FROM users u
            LEFT JOIN user_profiles up ON u.id = up.user_id
            LEFT JOIN weight_categories wc ON up.weight_category_id = wc.id
            ORDER BY u.id ASC
        ");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        View::render('admin/users', [
            'title' => 'Zarządzanie Użytkownikami - Panel Admina',
            'users' => $users
        ]);
    }

    // Zmiana roli użytkownika
    public function updateRole(): void
    {
        $userId = (int)($_POST['user_id'] ?? 0);
        $newRole = trim($_POST['role'] ?? '');

        if (!$userId || !in_array($newRole, ['user', 'admin'])) {
            throw new \Exception("Nieprawidłowe dane do zmiany roli.", 400);
        }

        // Zabezpieczenie: Administrator nie może sam sobie odebrać roli admina w ten sposób
        if ($userId === (int)$_SESSION['user_id']) {
            throw new \Exception("Nie możesz zmienić własnej roli administratora!", 400);
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE users SET role = :role WHERE id = :id");
        $stmt->execute([
            ':role' => $newRole,
            ':id' => $userId
        ]);

        header("Location: /admin/users");
        exit;
    }

    // Usunięcie użytkownika z bazy (akcja kaskadowa ON DELETE CASCADE)
    public function deleteUser(): void
    {
        $userId = (int)($_POST['user_id'] ?? 0);

        if (!$userId) {
            throw new \Exception("Brak ID użytkownika do usunięcia.", 400);
        }

        if ($userId === (int)$_SESSION['user_id']) {
            throw new \Exception("Nie możesz usunąć własnego konta z poziomu panelu!", 400);
        }

        $db = Database::getInstance()->getConnection();

        // Wykonanie usunięcia w transakcji w celu zapewnienia spójności
        try {
            $db->beginTransaction();

            $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute([':id' => $userId]);

            $db->commit();
        } catch (\Throwable $e) {
            $db->rollBack();
            throw $e;
        }

        header("Location: /admin/users");
        exit;
    }
}

<?php

declare(strict_types=1);

namespace Models;

use PDO;

class User extends Model
{
    public function create(string $email, string $passwordHash): bool
    {
        try {
            // Rozpoczęcie transakcji
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO users (email, password_hash, role) VALUES (:email, :password_hash, 'user') RETURNING id");
            $stmt->execute([
                ':email' => $email,
                ':password_hash' => $passwordHash
            ]);
            $userId = (int)$stmt->fetchColumn();

            if (!$userId) {
                throw new \Exception("Nie udało się utworzyć rekordu użytkownika.");
            }

            // Tworzymy powiązany profil 1:1 z domyślnymi wartościami (również w tej samej transakcji)
            $stmtProfile = $this->db->prepare("INSERT INTO user_profiles (user_id, first_name, last_name, gender, body_weight) VALUES (:user_id, '', '', 'male', 0.0)");
            $stmtProfile->execute([':user_id' => $userId]);

            // Zatwierdzenie transakcji
            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            // Wycofanie transakcji w razie błędu
            $this->db->rollBack();
            return false;
        }
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Zwracamy tablicę z danymi użytkownika lub null, jeśli taki email nie istnieje
        return $user ?: null;
    }
}
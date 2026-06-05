<?php

declare(strict_types=1);

namespace Models;

use PDO;

class User extends Model
{
    public function create(string $email, string $passwordHash): bool
    {
        // Używamy "prepared statements" (przygotowanych zapytań), aby zapobiec SQL Injection!
        $stmt = $this->db->prepare("INSERT INTO users (email, password_hash) VALUES (:email, :password_hash)");
        
        return $stmt->execute([
            ':email' => $email,
            ':password_hash' => $passwordHash
        ]);
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
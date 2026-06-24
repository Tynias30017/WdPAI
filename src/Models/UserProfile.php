<?php

declare(strict_types=1);

namespace Models;

use PDO;

class UserProfile extends Model
{
    public function getByUserId(int $userId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT up.*, wc.name as weight_category_name 
            FROM user_profiles up
            LEFT JOIN weight_categories wc ON up.weight_category_id = wc.id
            WHERE up.user_id = :user_id
        ");
        $stmt->execute([':user_id' => $userId]);
        
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        return $profile ?: null;
    }

    public function upsert(int $userId, string $firstName, string $lastName, string $gender, float $bodyWeight): bool
    {
        // Sprawdzamy czy profil już istnieje
        $stmt = $this->db->prepare("SELECT 1 FROM user_profiles WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            $stmt = $this->db->prepare("
                UPDATE user_profiles 
                SET first_name = :first_name, 
                    last_name = :last_name, 
                    gender = :gender, 
                    body_weight = :body_weight
                WHERE user_id = :user_id
            ");
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO user_profiles (user_id, first_name, last_name, gender, body_weight)
                VALUES (:user_id, :first_name, :last_name, :gender, :body_weight)
            ");
        }

        return $stmt->execute([
            ':user_id' => $userId,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':gender' => $gender,
            ':body_weight' => $bodyWeight
        ]);
    }
}

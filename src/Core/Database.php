<?php

declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct()
    {
        // Dane do połączenia z PostgreSQL pobierane z konfiguracji
        $host = Config::get('DB_HOST', 'db');
        $port = Config::get('DB_PORT', '5432');
        $dbname = Config::get('DB_DATABASE', 'powerlifting_app'); 
        $user = Config::get('DB_USERNAME', 'root');   
        $password = Config::get('DB_PASSWORD', 'rootpassword'); 

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        try {
            $this->connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Blokujemy możliwość klonowania obiektu (Singleton)
    private function __clone() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
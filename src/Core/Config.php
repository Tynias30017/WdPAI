<?php

declare(strict_types=1);

namespace Core;

class Config
{
    private static array $config = [];

    public static function load(string $filePath): void
    {
        if (!file_exists($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Pomiń komentarze
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Rozdziel klucz od wartości
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);

                // Usuń cudzysłowy/apostrofy
                if (preg_match('/^"($|.*?[^\\\\])"$/', $value, $matches)) {
                    $value = stripslashes($matches[1]);
                } elseif (preg_match('/^\'($|.*?[^\\\\])\'$/', $value, $matches)) {
                    $value = stripslashes($matches[1]);
                }

                $_ENV[$key] = $value;
                putenv("$key=$value");
                self::$config[$key] = $value;
            }
        }
    }

    public static function get(string $key, $default = null)
    {
        if (isset(self::$config[$key])) {
            return self::$config[$key];
        }
        $envValue = getenv($key);
        return $envValue !== false ? $envValue : $default;
    }
}

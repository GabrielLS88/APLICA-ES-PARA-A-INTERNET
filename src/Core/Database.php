<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Singleton: garante uma única conexão PDO compartilhada por toda a aplicação.
 */
class Database
{
    private static ?Database $instance = null;

    private PDO $connection;

    private function __construct()
    {
        $host = getenv('DB_HOST') ?: 'db';
        $dbName = getenv('DB_NAME') ?: 'fly_eventos';
        $user = getenv('DB_USER') ?: 'fly_user';
        $pass = getenv('DB_PASS') ?: 'fly_pass';

        $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8mb4";

        $attempts = 0;
        $lastError = null;

        while ($attempts < 10) {
            try {
                $this->connection = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
                return;
            } catch (PDOException $e) {
                $lastError = $e;
                $attempts++;
                sleep(2);
            }
        }

        die('Erro de conexão com o banco de dados: ' . $lastError->getMessage());
    }

    public static function getInstance(): Database
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

    private function __clone(): void
    {
    }

    public function __wakeup(): void
    {
        throw new \RuntimeException('Não é possível desserializar um Singleton.');
    }
}

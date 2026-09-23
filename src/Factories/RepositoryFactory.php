<?php

namespace App\Factories;

use App\Core\Database;
use App\Repositories\EventRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use InvalidArgumentException;

/**
 * Factory Method: centraliza a criação dos repositórios, escondendo do
 * código cliente como cada um é instanciado (e sempre reutilizando a
 * conexão PDO fornecida pelo Singleton Database).
 */
class RepositoryFactory
{
    public static function make(string $type): UserRepository|TaskRepository|EventRepository
    {
        $pdo = Database::getInstance()->getConnection();

        return match (strtolower($type)) {
            'user' => new UserRepository($pdo),
            'task' => new TaskRepository($pdo),
            'event' => new EventRepository($pdo),
            default => throw new InvalidArgumentException("Repositório desconhecido: {$type}"),
        };
    }
}

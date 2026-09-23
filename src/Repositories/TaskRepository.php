<?php

namespace App\Repositories;

use App\Models\Task;
use PDO;

class TaskRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function allByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM tasks WHERE user_id = :user_id ORDER BY is_completed ASC, created_at DESC'
        );
        $stmt->execute(['user_id' => $userId]);

        return array_map([Task::class, 'fromArray'], $stmt->fetchAll());
    }

    public function create(int $userId, string $title, string $description): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO tasks (user_id, title, description, is_completed, created_at)
             VALUES (:user_id, :title, :description, 0, NOW())'
        );
        $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function toggleComplete(int $id, int $userId): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE tasks SET is_completed = NOT is_completed WHERE id = :id AND user_id = :user_id'
        );
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }

    public function delete(int $id, int $userId): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = :id AND user_id = :user_id');
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }
}

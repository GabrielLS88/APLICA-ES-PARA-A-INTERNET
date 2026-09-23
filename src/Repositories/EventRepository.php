<?php

namespace App\Repositories;

use App\Models\Event;
use PDO;

class EventRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function allByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM events WHERE user_id = :user_id ORDER BY event_date ASC');
        $stmt->execute(['user_id' => $userId]);

        return array_map([Event::class, 'fromArray'], $stmt->fetchAll());
    }

    public function find(int $id, int $userId): ?Event
    {
        $stmt = $this->pdo->prepare('SELECT * FROM events WHERE id = :id AND user_id = :user_id LIMIT 1');
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        $row = $stmt->fetch();

        return $row ? Event::fromArray($row) : null;
    }

    public function create(int $userId, string $name, string $description, string $eventDate, string $location): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO events (user_id, name, description, event_date, location, created_at, updated_at)
             VALUES (:user_id, :name, :description, :event_date, :location, NOW(), NOW())'
        );
        $stmt->execute([
            'user_id' => $userId,
            'name' => $name,
            'description' => $description,
            'event_date' => $eventDate,
            'location' => $location,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(
        int $id,
        int $userId,
        string $name,
        string $description,
        string $eventDate,
        string $location
    ): void {
        $stmt = $this->pdo->prepare(
            'UPDATE events SET name = :name, description = :description, event_date = :event_date,
             location = :location, updated_at = NOW() WHERE id = :id AND user_id = :user_id'
        );
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'event_date' => $eventDate,
            'location' => $location,
            'id' => $id,
            'user_id' => $userId,
        ]);
    }

    public function delete(int $id, int $userId): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM events WHERE id = :id AND user_id = :user_id');
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }
}

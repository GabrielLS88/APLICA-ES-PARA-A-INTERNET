<?php

namespace App\Models;

class Task
{
    public function __construct(
        public int $id,
        public int $userId,
        public string $title,
        public ?string $description,
        public bool $isCompleted,
        public ?string $createdAt = null,
    ) {
    }

    public static function fromArray(array $row): self
    {
        return new self(
            (int) $row['id'],
            (int) $row['user_id'],
            $row['title'],
            $row['description'],
            (bool) $row['is_completed'],
            $row['created_at'] ?? null,
        );
    }
}

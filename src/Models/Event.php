<?php

namespace App\Models;

class Event
{
    public function __construct(
        public int $id,
        public int $userId,
        public string $name,
        public ?string $description,
        public string $eventDate,
        public ?string $location,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {
    }

    public static function fromArray(array $row): self
    {
        return new self(
            (int) $row['id'],
            (int) $row['user_id'],
            $row['name'],
            $row['description'],
            $row['event_date'],
            $row['location'],
            $row['created_at'] ?? null,
            $row['updated_at'] ?? null,
        );
    }
}

<?php

namespace App\Models;

class User
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password,
        public ?string $createdAt = null,
    ) {
    }

    public static function fromArray(array $row): self
    {
        return new self(
            (int) $row['id'],
            $row['name'],
            $row['email'],
            $row['password'],
            $row['created_at'] ?? null,
        );
    }
}

<?php

namespace App\Entity;

class Product
{
    public function __construct(
        public int $id,
        public string $name,
        public float $price,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {
    }
}

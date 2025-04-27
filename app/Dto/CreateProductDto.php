<?php

declare(strict_types=1);

namespace App\Dto;

final class CreateProductDto
{
    public function __construct(
        public string $name,
        public float $price,
    ) {
    }
}

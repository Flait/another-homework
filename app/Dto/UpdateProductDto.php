<?php

declare(strict_types=1);

namespace App\Dto;

final class UpdateProductDto
{
    public function __construct(
        public string $name,
        public float $price,
    ) {
    }
}

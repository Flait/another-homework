<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Product;

final class ProductDto
{
    public int                 $id;
    public string              $name;
    public float               $price;
    public string  $created_at;
    public string  $updated_at;

    private function __construct()
    {
    }

    public static function fromEntity(Product $p): self
    {
        $dto = new self();
        $dto->id = $p->getId();
        $dto->name = $p->getName();
        $dto->price = $p->getPrice();
        $dto->created_at = $p->getCreatedAt()->format('Y-m-d H:i:s');
        $dto->updated_at = $p->getUpdatedAt()->format('Y-m-d H:i:s');
        return $dto;
    }
}

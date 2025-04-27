<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Product;

final class ProductDto
{
    public int                 $id;
    public string              $name;
    public float               $price;
    public ?string             $category;
    public \DateTimeImmutable  $createdAt;
    public \DateTimeImmutable  $updatedAt;

    private function __construct()
    {
    }

    public static function fromEntity(Product $p): self
    {
        $dto = new self();
        $dto->id = $p->getId();
        $dto->name = $p->getName();
        $dto->price = $p->getPrice();
        // if your entity has category:
        $dto->category = method_exists($p, 'getCategory')
            ? $p->getCategory()
            : null;
        $dto->createdAt = $p->getCreatedAt();
        $dto->updatedAt = $p->getUpdatedAt();
        return $dto;
    }
}

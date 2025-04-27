<?php

declare(strict_types=1);

namespace App\Facade;

use App\Dto\CreateProductDto;
use App\Dto\UpdateProductDto;
use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductFacade
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    /** @return Product[] */
    public function getAllProducts(): array
    {
        return $this->productRepository->findAll();
    }

    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(CreateProductDto $dto): Product
    {
        $id = $this->productRepository->insert($dto->name, $dto->price);
        $product = $this->productRepository->findById($id);

        if ($product === null) {
            throw new \RuntimeException('Product creation failed.');
        }

        return $product;
    }

    public function updateProduct(int $id, UpdateProductDto $dto): bool
    {
        return $this->productRepository->update($id, $dto->name, $dto->price);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }
}

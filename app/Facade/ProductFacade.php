<?php

namespace App\Facade;

use App\Repository\ProductRepository;
use App\Entity\Product;

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

    public function createProduct(string $name, float $price): Product
    {
        $id = $this->productRepository->insert($name, $price);
        $product = $this->productRepository->findById($id);

        if ($product === null) {
            throw new \RuntimeException('Product creation failed.');
        }

        return $product;
    }

    public function updateProduct(int $id, string $name, float $price): bool
    {
        return $this->productRepository->update($id, $name, $price);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }
}

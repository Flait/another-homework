<?php

declare(strict_types=1);

namespace Tests\Integration\Facade;

use App\Dto\CreateProductDto;
use App\Dto\UpdateProductDto;
use App\Facade\ProductFacade;
use Tests\BaseIntegrationTest;

final class ProductFacadeTest extends BaseIntegrationTest
{
    private ProductFacade $productFacade;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productFacade = $this->container->getByType(ProductFacade::class);
    }

    public function testCreateProduct(): void
    {
        restore_error_handler();
        restore_exception_handler();


        $dto = new CreateProductDto(

            name: 'Test Product',
            price: 99.99
        );

        $product = $this->productFacade->createProduct($dto);

        $this->assertSame('Test Product', $product->name);
        $this->assertSame(99.99, $product->price);
    }

    public function testUpdateProduct(): void
    {
        $dto = new CreateProductDto(
            name: 'Old Product',
            price: 10.00
        );

        $product = $this->productFacade->createProduct($dto);

        $updateDto = new UpdateProductDto(
            name: 'Updated Product',
            price: 20.00
        );

        $success = $this->productFacade->updateProduct($product->id, $updateDto);

        $this->assertTrue($success);

        $updatedProduct = $this->productFacade->getProductById($product->id);
        $this->assertSame('Updated Product', $updatedProduct->name);
        $this->assertSame(20.00, $updatedProduct->price);
    }

    public function testDeleteProduct(): void
    {
        $dto = new CreateProductDto(
            name: 'Product to Delete',
            price: 5.00
        );

        $product = $this->productFacade->createProduct($dto);

        $success = $this->productFacade->deleteProduct($product->id);

        $this->assertTrue($success);

        $deletedProduct = $this->productFacade->getProductById($product->id);
        $this->assertNull($deletedProduct);
    }

    public function testGetAllProducts(): void
    {
        $productsBefore = $this->productFacade->getAllProducts();
        $countBefore = count($productsBefore);

        $this->productFacade->createProduct(new CreateProductDto('Product 1', 10));
        $this->productFacade->createProduct(new CreateProductDto('Product 2', 20));

        $productsAfter = $this->productFacade->getAllProducts();

        $this->assertCount($countBefore + 2, $productsAfter);
    }
}

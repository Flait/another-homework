<?php

declare(strict_types=1);

namespace App\Presenter;

use App\Dto\CreateProductDto;
use App\Dto\UpdateProductDto;
use App\Facade\ProductFacade;
use Nette\Application\BadRequestException;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Presenter;
use Nette\Http\Request;

final class ProductPresenter extends Presenter
{
    public function __construct(
        private ProductFacade $productFacade,
        private Request $httpRequest,
    ) {
        parent::__construct();
    }

    public function actionGetAll(): void
    {
        $products = $this->productFacade->getAllProducts();
        $this->sendResponse(new JsonResponse($products));
    }

    public function actionGetById(int $id): void
    {
        $product = $this->productFacade->getProductById($id);
        if (!$product) {
            throw new BadRequestException('Product not found', 404);
        }

        $this->sendResponse(new JsonResponse($product));
    }

    public function actionCreate(): void
    {
        $data = $this->getJsonBody();
        $dto = new CreateProductDto(
            name: $data['name'] ?? throw new BadRequestException('Missing name'),
            price: isset($data['price']) ? (float)$data['price'] : throw new BadRequestException('Missing price'),
        );

        $product = $this->productFacade->createProduct($dto);

        $this->sendResponse(new JsonResponse($product));
    }

    public function actionUpdate(int $id): void
    {
        $data = $this->getJsonBody();

        $dto = new UpdateProductDto(
            name: $data['name'] ?? throw new BadRequestException('Missing name'),
            price: isset($data['price']) ? (float) $data['price'] : throw new BadRequestException('Missing price'),
        );

        $success = $this->productFacade->updateProduct($id, $dto);

        if (!$success) {
            throw new BadRequestException('Product not found', 404);
        }

        $this->sendResponse(new JsonResponse(['success' => true]));
    }

    public function actionDelete(int $id): void
    {
        $success = $this->productFacade->deleteProduct($id);

        if (!$success) {
            throw new BadRequestException('Product not found', 404);
        }

        $this->sendResponse(new JsonResponse(['success' => true]));
    }

    /**
     * @return array<string, mixed>
     */
    private function getJsonBody(): array
    {
        $raw = $this->httpRequest->getRawBody();
        $data = $raw !== null ? json_decode($raw, true) : null;


        if (!is_array($data)) {
            throw new BadRequestException('Invalid JSON body');
        }

        return $data;
    }
}

<?php

namespace App\Presenter;

use App\Facade\ProductFacade;
use Nette\Application\UI\Presenter;
use Nette\Http\Request;
use Nette\Application\BadRequestException;
use Nette\Application\Responses\JsonResponse;

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

        if (!isset($data['name'], $data['price'])) {
            throw new BadRequestException('Missing name or price');
        }

        $product = $this->productFacade->createProduct($data['name'], (float)$data['price']);
        $this->sendResponse(new JsonResponse($product));
    }

    public function actionUpdate(int $id): void
    {
        $data = $this->getJsonBody();

        if (!isset($data['name'], $data['price'])) {
            throw new BadRequestException('Missing name or price');
        }

        $success = $this->productFacade->updateProduct($id, $data['name'], (float)$data['price']);

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

    private function getJsonBody(): array
    {
        $raw = $this->httpRequest->getRawBody();
        $data = json_decode($raw, true);

        if (!is_array($data)) {
            throw new BadRequestException('Invalid JSON body');
        }

        return $data;
    }
}

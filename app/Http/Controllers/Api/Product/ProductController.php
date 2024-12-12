<?php

namespace App\Http\Controllers\Api\Product;

use App\Domains\Product\Dtos\ProductDto;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\SearchProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(SearchProductRequest $request): JsonResponse
    {
        try {
            $search = $request->validated();

            $products = $this->service->list($search);

            return $this->responseOk($products);
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function show(string $uuid)
    {
        try {
            $product = $this->service->findById($uuid);

            return $this->responseOk($product);
        } catch (\Exception $e) {
            return $this->responseNotFound($e->getMessage());
        }
    }

    public function store(CreateProductRequest $request): JsonResponse
    {
        try {
            $dto = ProductDto::fromArray($request->validated());
            $product = $this->service->create($dto);

            return $this->responseCreated($product, "Product created.");
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function update(UpdateProductRequest $request, string $uuid): JsonResponse
    {
        try {
            $dto = ProductDto::fromArray($request->validated());
            $updatedProduct = $this->service->update($uuid, $dto);

            return $this->responseOk($updatedProduct, 'Product updated.');
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function destroy(string $uuid): JsonResponse
    {
        try {
            $this->service->delete($uuid);

            return $this->responseOk(null, 'Product deleted successfully.');
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }
}

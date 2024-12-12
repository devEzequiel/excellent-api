<?php

namespace App\Http\Controllers\Api;

use App\Domains\Product\Dtos\ProductDto;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $search = $request->only(['corporate_name', 'cnpj', 'email']);

            $products = $this->service->list($search);

            return response()->json($products);
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $product = $this->service->findById($id);

            return $this->responseOk($product);
        } catch (\Exception $e) {
            return $this->responseNotFound($e->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $dto = ProductDto::fromArray($request->all());
            $this->service->create($dto);

            return $this->responseCreated("Product created.");
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        try {
            $dto = ProductDto::fromArray($request->all());
            $updatedProduct = $this->service->update($product->id, $dto);

            return response()->json(['data' => $updatedProduct]);
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function destroy(Product $product): JsonResponse
    {
        try {
            $this->service->delete($product->id);

            return response()->json(['message' => 'Product deleted successfully.']);
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }
}

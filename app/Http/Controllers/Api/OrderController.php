<?php

namespace App\Http\Controllers\Api;

use App\Domains\Order\Services\OrderService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $search = $request->only(['corporate_name', 'cnpj', 'email']);

            $clients = $this->service->list($search);

            return response()->json($clients);
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $client = $this->service->findById($id);

            return $this->responseOk($client);
        } catch (\Exception $e) {
            return $this->responseNotFound($e->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $dto = ClientDto::fromArray($request->all());
            $this->service->create($dto);

            return $this->responseCreated("Product created.");
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function update(Request $request, Client $client): JsonResponse
    {
        try {
            $dto = ClientDto::fromArray($request->all());
            $updatedClient = $this->service->update($client->id, $dto);

            return response()->json(['data' => $updatedClient]);
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function destroy(Client $client): JsonResponse
    {
        try {
            $this->service->delete($client->id);

            return response()->json(['message' => 'Product deleted successfully.']);
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }
}

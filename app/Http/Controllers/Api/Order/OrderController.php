<?php

namespace App\Http\Controllers\Api\Order;

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

    public function index(SearchClientRequest $request): JsonResponse
    {
        try {
            $search = $request->validated();
            $clients = $this->service->list($search);

            return $this->responseOk($clients);
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function show(string $uuid)
    {
        try {
            $client = $this->service->findById($uuid);

            return $this->responseOk($client);
        } catch (\Exception $e) {
            return $this->responseNotFound($e->getMessage());
        }
    }

    public function store(CreateClientRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $dto = ClientDto::fromArray($data);
            $client = $this->service->create($dto);

            return $this->responseCreated($client, "Client created.");
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function update(UpdateClientRequest $request, string $uuid): JsonResponse
    {
        try {
            $data = $request->validated();
            $dto = ClientDto::fromArray($data);
            $updatedClient = $this->service->update($uuid, $dto);

            return $this->responseOk($updatedClient, 'Client updated.');
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function destroy(string $uuid): JsonResponse
    {
        try {
            $this->service->delete($uuid);

            return response()->json(['message' => 'Client deleted successfully.']);
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }
}

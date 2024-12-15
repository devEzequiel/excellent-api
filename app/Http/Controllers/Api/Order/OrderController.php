<?php

namespace App\Http\Controllers\Api\Order;

use App\Domains\Order\Dtos\OrderDto;
use App\Domains\Order\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        try {
            $orders = $this->service->list();
            $orderDto = $this->service->formatOrdersToDto($orders);

            return $this->responseOk($orderDto->toArray());
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function show(string $uuid): JsonResponse
    {
        try {
            $order = $this->service->findById($uuid);

            $orderDto = $this->service->formatOrderToDto($order);

            return $this->responseOk($orderDto->toArray());
        } catch (\Exception $e) {
            return $this->responseNotFound($e->getMessage());
        }
    }

    public function store(CreateOrderRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $order = $this->service->create($data);

            $orderDtoResponse = $this->service->formatOrderToDto($order);

            return $this->responseCreated($orderDtoResponse->toArray(), "Order created.");
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function update(UpdateOrderRequest $request, string $uuid): JsonResponse
    {
        try {
            $data = $request->validated();

            $order = $this->service->update($uuid, $data);

            $orderDtoResponse = $this->service->formatOrderToDto($order);

            return $this->responseOk($orderDtoResponse->toArray(), 'Order updated.');
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function destroy(string $uuid): JsonResponse
    {
        try {
            $this->service->delete($uuid);

            return response()->json(['message' => 'Order deleted successfully.']);
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }
}

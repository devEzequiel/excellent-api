<?php

namespace App\Domains\Order\Services;

use App\Domains\Order\Dtos\OrderDto;
use App\Domains\Order\Dtos\OrderProductDto;
use App\Domains\Order\Models\Order;
use App\Domains\Order\Repositories\OrderRepository;

class OrderService
{
    private OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(array $search = []): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->getOrders($search);
    }

    public function findById(string $uuid): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->getOrderById($uuid);
    }

    public function create(array $data): Order
    {
        return $this->repository->createOrder($data);
    }

    public function update(string $uuid, array $data): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->updateOrder($uuid, $data);
    }

    public function delete(string $uuid): bool
    {
        return $this->repository->deleteOrder($uuid);
    }

    public function formatOrdersToDto($orders)
    {
        return $orders->map(fn($order) => $this->mapOrderToDto($order));
    }

    public function formatOrderToDto($order)
    {
        return $this->mapOrderToDto($order);
    }

    private function mapOrderToDto($order): OrderDto
    {
        return new OrderDto(
            $order->uuid,
            $order->client_id,
            $order->total,
            $order->products->map(fn($product) => $this->mapProductToDto($product))->toArray()
        );
    }

    private function mapProductToDto($product): OrderProductDto
    {
        return new OrderProductDto(
            $product->product_id,
            $product->quantity
        );
    }
}

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
        return $this->repository->getAll($search);
    }

    public function findById(string $uuid): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->getById($uuid);
    }

    public function create(array $data): Order
    {
        return $this->repository->createOrder($data);
    }

    public function update(string $uuid, array $data): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->update($data, $uuid);
    }

    public function delete(string $uuid): bool
    {
        return $this->repository->delete($uuid);
    }

    public function formatOrderToDto(Order $order)
    {
        return new OrderDto(
            $order->uuid,
            $order->client_id,
            $order->total,
            $order->products->map(function ($product) {
                return new OrderProductDto(
                    $product->uuid,
                    $product->order_id,
                    $product->product_id,
                    $product->quantity
                );
            })->toArray()
        );
    }
}

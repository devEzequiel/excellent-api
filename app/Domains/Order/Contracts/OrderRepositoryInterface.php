<?php

namespace App\Domains\Order\Contracts;

interface OrderRepositoryInterface
{
    public function createOrder(array $data);
    public function getOrders();
    public function getOrderById(string $uuid);
    public function deleteOrder(string $uuid): bool;
    public function updateOrder(string $uuid, array $data);
}

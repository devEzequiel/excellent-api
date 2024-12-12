<?php

namespace App\Domains\Order\Services;

use App\Domains\Order\Dtos\OrderDto;
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

    public function findById(int $id): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->getById($id);
    }

    public function create(OrderDto $dto): Order
    {
        return $this->repository->create([
            'corporate_name' => $dto->corporate_name,
            'cnpj' => $dto->cnpj,
            'email' => $dto->email,
        ]);
    }

    public function update(int $id, OrderDto $dto): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->update($id, [
            'corporate_name' => $dto->corporate_name,
            'cnpj' => $dto->cnpj,
            'email' => $dto->email,
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}

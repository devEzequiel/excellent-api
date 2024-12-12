<?php

namespace App\Domains\Product\Services;

use App\Domains\Product\Dtos\ProductDto;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
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

    public function create(ProductDto $dto): Product
    {
        return $this->repository->create([
            'description' => $dto->description,
            'price' => $dto->price,
            'stock' => $dto->stock,
        ]);
    }

    public function update(string $uuid, ProductDto $dto): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->update($uuid, [
            'description' => $dto->description,
            'price' => $dto->price,
            'stock' => $dto->stock,
        ]);
    }

    public function delete(string $uuid): bool
    {
        return $this->repository->delete($uuid);
    }
}

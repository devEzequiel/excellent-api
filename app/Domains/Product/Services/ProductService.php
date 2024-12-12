<?php

namespace App\Domains\Product\Services;

use App\Domains\Product\Dtos\ProductDto;
use App\Domains\Product\Models\Product;
use App\Domains\Products\Repositories\ProductRepository;

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

    public function findById(int $id): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->getById($id);
    }

    public function create(ProductDto $dto): Product
    {
        return $this->repository->create([
            'corporate_name' => $dto->corporate_name,
            'cnpj' => $dto->cnpj,
            'email' => $dto->email,
        ]);
    }

    public function update(int $id, ProductDto $dto): ?\Illuminate\Database\Eloquent\Model
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

<?php

namespace App\Domains\Product\Contracts;

interface ProductRepositoryInterface
{
    public function getAll(array $search);
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
}

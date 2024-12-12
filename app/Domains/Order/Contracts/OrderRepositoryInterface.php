<?php

namespace App\Domains\Order\Contracts;

interface OrderRepositoryInterface
{
    public function getAll(array $search);
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
}

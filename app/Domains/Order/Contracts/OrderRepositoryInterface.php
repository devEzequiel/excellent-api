<?php

namespace App\Domains\Order\Contracts;

interface OrderRepositoryInterface
{
    public function getAll(array $search);
    public function getById(string $uuid);
    public function create(array $data);
    public function update(string $uuid, array $data);
    public function delete(string $uuid): bool;
}

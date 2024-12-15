<?php

namespace App\Domains\Product\Contracts;

interface ProductRepositoryInterface
{
    public function getAll(array $search);
    public function getById(string $uuid);
    public function create(array $data);
    public function update(string $uuid, array $data);
    public function delete(string $uuid): bool;

    public function uploadImages(array $data);

    public function deleteImage(string $image_uuid);
}

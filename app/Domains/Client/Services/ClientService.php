<?php

namespace App\Domains\Client\Services;

use App\Domains\Client\Models\Client;
use App\Domains\Client\Dtos\ClientDto;
use App\Domains\Client\Repositories\ClientRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService
{
    private ClientRepository $repository;

    public function __construct(ClientRepository $repository)
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

    public function create(ClientDto $dto): Client
    {
        return $this->repository->create([
            'corporate_name' => $dto->corporate_name,
            'cnpj' => $dto->cnpj,
            'email' => $dto->email,
        ]);
    }

    public function update(string $uuid, ClientDto $dto): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->update($uuid, [
            'corporate_name' => $dto->corporate_name,
            'cnpj' => $dto->cnpj,
            'email' => $dto->email,
        ]);
    }

    public function delete(string $uuid): bool
    {
        return $this->repository->delete($uuid);
    }
}

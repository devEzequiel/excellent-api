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

    public function findById(int $id): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->getById($id);
    }

    public function create(ClientDto $dto): Client
    {
        return $this->repository->create([
            'corporate_name' => $dto->corporate_name,
            'cnpj' => $dto->cnpj,
            'email' => $dto->email,
        ]);
    }

    public function update(int $id, ClientDto $dto): ?\Illuminate\Database\Eloquent\Model
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

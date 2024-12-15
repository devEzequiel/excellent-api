<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractRepository
{
    /** @var Model */
    protected Model $model;

    /**
     * AbstractRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $search
     * @return Collection
     */
    public function getAll(array $search = []): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->search($search)->get();
    }

    public function getById(string $uuid): ?Model
    {
        return $this->model->find($uuid);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param string $id
     * @param array $data
     * @return Model|null
     */
    public function update(string $uuid, array $data): ?Model
    {
        $record = $this->model->find($uuid);

        if ($record) {
            $record->update($data);
        }

        return $record;
    }

    /**
     * @param string $uuid
     * @return bool
     */
    public function delete(string $uuid): bool
    {
        $record = $this->model->find($uuid);

        if ($record) {
            return $record->delete();
        }

        return false;
    }
}


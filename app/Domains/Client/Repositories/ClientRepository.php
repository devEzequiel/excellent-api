<?php

namespace App\Domains\Client\Repositories;

use App\Domains\Client\Contracts\ClientRepositoryInterface;
use App\Domains\Client\Models\Client;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

class ClientRepository extends AbstractRepository implements ClientRepositoryInterface
{
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }
}

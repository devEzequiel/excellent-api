<?php

namespace App\Domains\Order\Repositories;

use App\Domains\Order\Contracts\OrderRepositoryInterface;
use App\Domains\Order\Models\Order;
use App\Repositories\AbstractRepository;

class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
}

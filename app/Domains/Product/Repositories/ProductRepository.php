<?php

namespace App\Domains\Products\Repositories;

use App\Domains\Product\Contracts\ProductRepositoryInterface;
use App\Domains\Product\Models\Product;
use App\Repositories\AbstractRepository;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}

<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class BaseService
{
    public function __construct(protected Model $model)
    {
    }
}

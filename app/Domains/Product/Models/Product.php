<?php

namespace App\Domains\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'uuid';

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = [
        'description',
        'price',
        'stock',
    ];

    public function scopeSearch($query, $search): void
    {
        $query->when(isset($search['description']), function ($query, $search) {
            $query->where('description', 'like', "%{$search}%");
        });
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}

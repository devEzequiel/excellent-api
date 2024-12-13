<?php

namespace App\Domains\Order\Models;

use App\Domains\Client\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $table = 'orders';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'uuid';
    public $timestamps = true;
    protected $fillable = [
        'client_id',
        'total',
        'uuid'
    ];

    public function scopeSearch($query, $search)
    {
        $query->when(isset($search['client_id']), function ($query, $search) {
            $query->where('client_id', 'like', "%{$search}%");
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        });
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'uuid', 'client_id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'uuid');
    }
}

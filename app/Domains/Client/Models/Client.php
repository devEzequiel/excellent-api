<?php

namespace App\Domains\Client\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'uuid';
    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = [
        'corporate_name',
        'cnpj',
        'email',
        'uuid'
    ];

    public function scopeSearch($query, $search): void
    {
        $query->when(isset($search['corporate_name']), function ($query, $search) {
            $query->where('corporate_name', 'like', "%{$search}%");
        })
            ->when(isset($search['cnpj']), function ($query, $search) {
                $query->where('cnpj', 'like', "%{$search}%");
            })
            ->when(isset($search['email']), function ($query, $search) {
                $query->where('email', 'like', "%{$search}%");
            });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}

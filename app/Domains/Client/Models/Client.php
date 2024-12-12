<?php

namespace App\Domains\Client\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = [
        'corporate_name',
        'cnpj',
        'email',
    ];

    public function scopeSearch($query, $search): void
    {
        $query->when($search['corporate_name'], function ($query, $search) {
            $query->where('corporate_name', 'like', "%{$search}%");
        })
            ->when($search['cnpj'], function ($query, $search) {
                $query->where('cnpj', 'like', "%{$search}%");
            })
            ->when($search['email'], function ($query, $search) {
                $query->where('email', 'like', "%{$search}%");
            });
    }
}

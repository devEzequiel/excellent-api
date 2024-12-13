<?php

namespace App\Domains\Order\Dtos;

use App\Domains\Client\Models\Client;

class OrderDto
{
    public Client $client;
    public float $total;
    public array $products;
    public function __construct(
        string  $client_id,
        float   $total,
        array   $products = []
    )
    {
        $this->client = Client::find($client_id);
        $this->total = $total;

        $this->products = array_map(function ($product) {
            return $product instanceof OrderProductDto
                ? $product
                : OrderProductDto::fromArray($product);
        }, $products);
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['client_id'] ?? '',
            $data['total'] ?? 0.0,
            $data['products'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'client_id' => $this->client->uuid,
            'total' => $this->total,
            'products' => array_map(function ($product) {
                return $product->toArray();
            }, $this->products),
        ];
    }
}


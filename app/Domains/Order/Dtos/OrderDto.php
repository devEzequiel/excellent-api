<?php

namespace App\Domains\Order\Dtos;

use App\Domains\Client\Models\Client;

class OrderDto
{
    public Client $client;
    public int $quantity;
    public float $total;

    public function __construct(string $client_id, int $quantity, float $total)
    {
        $this->client = Client::findOrFail($client_id);
        $this->quantity = $quantity;
        $this->total = $total;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            client_id: $data['client_id'] ?? '',
            quantity: $data['quantity'] ?? '',
            total: $data['total'] ?? ''
        );
    }
}

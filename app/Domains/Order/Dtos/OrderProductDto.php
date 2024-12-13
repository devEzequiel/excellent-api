<?php

namespace App\Domains\Order\Dtos;

class OrderProductDto
{
    public ?string $uuid;

    public string $order_id;
    public string $product_id;

    public int $quantity;

    public function __construct(
        ?string $uuid,
        string  $order_id,
        string  $product_id,
        int     $quantity
    )
    {
        $this->uuid = $uuid;
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['uuid'] ?? null,
            $data['order_id'] ?? '',
            $data['product_id'] ?? '',
            $data['quantity'] ?? 0
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
        ];
    }
}

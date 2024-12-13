<?php

namespace App\Domains\Order\Dtos;

class OrderProductDto
{
    public string $order_id;
    public string $product_id;

    public int $quantity;

    public function __construct(
        string  $order_id,
        string  $product_id,
        int     $quantity
    )
    {
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['order_id'] ?? '',
            $data['product_id'] ?? '',
            $data['quantity'] ?? 0
        );
    }

    public function toArray(): array
    {
        return [
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
        ];
    }
}

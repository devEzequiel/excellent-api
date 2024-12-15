<?php

namespace App\Domains\Order\Dtos;

use App\Domains\Product\Models\Product;

class OrderProductDto
{
    public Product $product;
    public int $quantity;

    public function __construct(
        string  $product_id,
        int     $quantity
    )
    {
        $this->product = Product::find($product_id);
        $this->quantity = $quantity;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['product_id'] ?? '',
            $data['quantity'] ?? 0
        );
    }

    public function toArray(): array
    {
        return [
            'product' => $this->product,
            'quantity' => $this->quantity,
        ];
    }
}

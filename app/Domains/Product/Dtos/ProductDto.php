<?php

namespace App\Domains\Product\Dtos;

class ProductDto
{
    public string $description;
    public float $price;
    public int $stock;

    public function __construct(string $description, float $price, int $stock)
    {
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
    }

    /**
     * Creates a new instance of the class from an array of data.
     *
     * @param array $data Input data containing keys for 'description', 'price', and 'stock'.
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            description: $data['description'] ?? '',
            price: $data['price'] ?? null,
            stock: $data['stock'] ?? null
        );
    }
}

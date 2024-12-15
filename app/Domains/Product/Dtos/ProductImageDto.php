<?php

namespace App\Domains\Product\Dtos;

class ProductImageDto
{
    public string $uuid;
    public string $image_url;

    public function __construct(string $uuid, string $image_url)
    {
        $this->uuid = $uuid;
        $this->image_url = $image_url;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'image_url' => $this->image_url,
        ];
    }
}

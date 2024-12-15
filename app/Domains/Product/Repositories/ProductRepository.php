<?php

namespace App\Domains\Product\Repositories;

use App\Domains\Product\Contracts\ProductRepositoryInterface;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Models\ProductImage;
use App\Repositories\AbstractRepository;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    protected ProductImage $image;

    public function __construct(Product $model, ProductImage $image)
    {
        parent::__construct($model);
        $this->image = $image;
    }

    public function uploadImages(array $data)
    {
        $product = $this->model::find($data['product_id']);

        foreach ($data['images'] as $image) {
            $product->images()->create([
                'image_url' => $image,
            ]);
        }

        return $product->load('images');
    }

    public function deleteImage(string $image_uuid)
    {
        $image = $this->image::find($image_uuid);

        if (!$image) {
            throw new \Exception("Image not found.");
        }

        $imagePath = storage_path('app/public/' . $image->image_url);

        if (!file_exists($imagePath)) {
            throw new \Exception("File does not exist at path: {$imagePath}");
        }

        unlink($imagePath);
        $image->delete();

        return $this->model::find($image->product_id);
    }
}

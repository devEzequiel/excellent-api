<?php

namespace App\Http\Controllers\Api\Product;

use App\Domains\Product\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UploadImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function upload(UploadImageRequest $request)
    {
        try {
            $data = $request->validated();

            foreach ($request->file('image') as $image) {
                $data['images'][] = $image->store('images', 'public');
            }

            $product = $this->service->uploadImages($data);

            return $this->responseOk($product, 'Image uploaded successfully.');
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }

    public function delete(string $image_uuid)
    {
        try {
            $product = $this->service->deleteImage($image_uuid);

            return $this->responseOk($product, 'Image deleted successfully.');
        } catch (\Exception $e) {
            return $this->responseUnprocessableEntity($e->getMessage());
        }
    }
}

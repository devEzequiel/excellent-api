<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UploadImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(UploadImageRequest $request)
    {
        $path = $request->file('image')->store('images', 'public');
//        dd($path);

        return $this->responseOk($image, 'Image uploaded successfully.');
    }
}

<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('products', 'App\Http\Controllers\Api\Product\ProductController');
Route::post('products/image', 'App\Http\Controllers\Api\Product\ImageUploadController@upload');
Route::delete('products/image/{image_uuid}', 'App\Http\Controllers\Api\Product\ImageUploadController@delete');

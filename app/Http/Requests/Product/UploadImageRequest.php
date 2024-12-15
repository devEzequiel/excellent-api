<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'required|array|min:1',
            'image.*' => 'required|image|mimes:jpeg,jpg,png,gif|max:4096',
            'product_id' => 'required|exists:products,uuid',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

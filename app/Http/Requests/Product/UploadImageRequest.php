<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:4096',
            'product_id' => 'required|exists:products,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

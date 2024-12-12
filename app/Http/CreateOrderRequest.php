<?php

namespace App\Http;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            ''
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

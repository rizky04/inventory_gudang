<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVarianProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'name_variant' => 'required',
            'stok_variant' => 'required|numeric',
            'price_variant' => 'required|numeric',
            'image_variant' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
// 'product_id',
//         'number_sku',
//         'name_variant',
//         'image_variant',
//         'price_variant',
//         'stok_variant',

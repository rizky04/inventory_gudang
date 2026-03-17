<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
           'name_product' => 'required|unique:products,name_product,' . $this->product->id,
           'description_product' => 'required|min:10',
           'category_product_id' => 'required|exists:category_products,id',

        ];
    }

    public function messages(): array
    {
        return [
            'name_product.required' => 'Name Product required',
            'description_product.required' => 'Description product required',
            'description_product.min' => 'Description product minimal 10 caracter',
            'category_product_id.required' => 'Category product required',
            'category_product_id.exists' => 'Category not found'
        ];
    }
}

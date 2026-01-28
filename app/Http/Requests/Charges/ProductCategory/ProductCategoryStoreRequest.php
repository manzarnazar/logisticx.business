<?php

namespace App\Http\Requests\Charges\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|min:2|max:50|unique:product_categories,name',
            'position'  => 'numeric|min:0',
            'status'    => 'boolean'
        ];
    }
}

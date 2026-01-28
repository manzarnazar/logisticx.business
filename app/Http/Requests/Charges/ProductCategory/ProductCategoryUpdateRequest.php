<?php

namespace App\Http\Requests\Charges\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ProductCategoryUpdateRequest extends FormRequest
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
            'id'        => 'required|exists:product_categories,id',
            'name'      => 'required|string|min:2|max:50|unique:product_categories,name,' . Request::input('id'),
            'position'  => 'numeric|min:0',
            'status'    => 'boolean'
        ];
    }
}

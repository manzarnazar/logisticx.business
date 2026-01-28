<?php

namespace App\Http\Requests\MerchantPanel\Charge;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'product_category_id'   => 'required|exists:product_categories,id',
            'service_type_id'       => 'required|exists:service_types,id',
            'area'                  => 'required',
            'delivery_time'         => 'required|numeric',
            'charge'                => 'nullable|numeric|min:0',
            'additional_charge'     => 'nullable|numeric|min:0',
            'position'              => 'nullable|numeric|min:0',
            'status'                => 'required|boolean'
        ];
    }
}

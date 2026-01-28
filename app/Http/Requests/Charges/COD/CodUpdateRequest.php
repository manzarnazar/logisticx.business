<?php

namespace App\Http\Requests\Charges\COD;

use Illuminate\Foundation\Http\FormRequest;

class CodUpdateRequest extends FormRequest
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
            'cod_inside_city'   => 'required|numeric|min:0',
            'cod_sub_city'      => 'required|numeric|min:0',
            'cod_outside_city'  => 'required|numeric|min:0',
            'liquid_fragile'    => 'required|numeric|min:0',
            'merchant_vat'      => 'required|numeric|min:0',
        ];
    }
}

<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;

class MerchantCODChargeUpdateRequest extends FormRequest
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
            'cod_charges.*' => 'required|numeric|min:0',
        ];
    }

    public function attributes()
    {
        return [
            'cod_charges.sub_city'       => trans('charges.sub_city'),
            'cod_charges.outside_city'   => trans('charges.outside_city'),
            'cod_charges.inside_city'    => trans('charges.inside_city'),
            'cod_charges.liquid_fragile' => trans('charges.liquid_fragile'),
            'cod_charges.*'              => trans('levels.mentioned'),
        ];
    }
}

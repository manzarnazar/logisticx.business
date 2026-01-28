<?php

namespace App\Http\Requests\MerchantShop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'merchant_id'   => ['required', 'exists:merchants,id'],
            'name'          => ['required', 'max:100'],
            'contact_no'    => ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/', 'unique:merchant_shops,contact_no,' . Request::input('id')],
            'address'       => ['required', 'max:150'],
            'hub'           => ['required', 'exists:hubs,id'],
            // 'coverage'      => ['required', 'exists:coverages,id'],
            'status'        => ['required', 'boolean'],
        ];
    }

    public function attributes()
    {
        return [
            'name'                       => trans('validation.attributes.name'),
            'contact_no'                 => ___('label.contract_number'),
            'address'                    => trans('validation.attributes.address'),
            // 'coverage'                   =>  ___('label.coverage_area'),
            'status'                     => trans('validation.attributes.status'),
        ];
    }
}

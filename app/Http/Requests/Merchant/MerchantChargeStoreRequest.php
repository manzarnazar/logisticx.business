<?php

namespace App\Http\Requests\Merchant;

use App\Models\Backend\MerchantCharge;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MerchantChargeStoreRequest extends FormRequest
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
            'merchant_id'           => 'required|exists:merchants,id',
            'charge_id'             => 'required|exists:charges,id',
            'product_category_id'   => 'required|exists:product_categories,id',
            'service_type_id'       => 'required|exists:service_types,id',
            'area'                  => 'required',
            'delivery_time'         => 'required|numeric',
            'charge'                => 'required|numeric|min:0',
            'additional_charge'     => 'nullable|numeric|min:0',
            'position'              => 'nullable|numeric|min:0',
            'status'                => 'required|boolean'
        ];
    }

    private function uniqueMerchantChargeCheck()
    {
        return MerchantCharge::where([
            'merchant_id'         => $this->input('merchant_id'),
            'product_category_id' => $this->input('product_category_id'),
            'service_type_id'     => $this->input('service_type_id'),
            'area'                => $this->input('area'),
        ])->exists();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->uniqueMerchantChargeCheck()) {
                $validator->errors()->add('uniqueMerchantCharge', ___('This Charge combination is already exists.'));
            }
        });
    }
}

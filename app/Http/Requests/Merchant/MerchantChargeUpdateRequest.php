<?php

namespace App\Http\Requests\Merchant;

use App\Models\Backend\MerchantCharge;
use Illuminate\Foundation\Http\FormRequest;

class MerchantChargeUpdateRequest extends FormRequest
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
            'id'                    => 'required|exists:merchant_charges,id',
            'merchant_id'           => 'required|exists:merchants,id',
            // 'product_category_id'   => 'required|exists:product_categories,id',
            // 'service_type_id'       => 'required|exists:service_types,id',
            // 'area'                  => 'required',
            'delivery_time'         => 'required|numeric',
            'charge'                => 'required|numeric|min:0',
            'additional_charge'     => 'nullable|numeric|min:0',
            'position'              => 'nullable|numeric|min:0',
            'status'                => 'required|boolean'
        ];
    }


    private function uniqueMerchantChargeCheck()
    {
        $query = MerchantCharge::where([
            'merchant_id'         => $this->input('merchant_id'),
            'product_category_id' => $this->input('product_category_id'),
            'service_type_id'     => $this->input('service_type_id'),
            'area'                => $this->input('area'),
        ]);

        // Exclude the current record when updating
        if ($this->isMethod('PUT')) { // Assuming the HTTP method for updating is PUT
            $id =  $this->route('id') ?? $this->input('id');
            $query->where('id', '<>', $id);
        }

        return $query->exists();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->uniqueMerchantChargeCheck()) {
                $validator->errors()->add('uniqueMerchantCharge', ___('This Charge combination is already exists.'));
            }
        });
        // dd($validator->errors());
    }
}

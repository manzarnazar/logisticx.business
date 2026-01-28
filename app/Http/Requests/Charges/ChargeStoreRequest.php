<?php

namespace App\Http\Requests\Charges;

use App\Enums\Area;
use App\Models\Backend\Charges\Charge;
use Illuminate\Foundation\Http\FormRequest;

class ChargeStoreRequest extends FormRequest
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
        $rules = [
            'product_category_id'           => 'required|exists:product_categories,id',
            'service_type_id'               => 'required|exists:service_types,id',
            'area'                          => 'required|in:' . implode(',',  array_keys(config('site.areas'))),
            'delivery_time'                 => 'required|numeric|min:0|max:1000',
            'charge'                        => 'required|numeric|min:0|max:1000',
            'additional_charge'             => 'required|numeric|min:0|max:1000',
            'delivery_commission'           => 'required|numeric|min:0|max:1000',
            'additional_delivery_commission' => 'required|numeric|min:0|max:1000',
            'position'                      => 'required|numeric|min:0|max:1000000',
            'status'                        => 'required|boolean'
        ];

        if ($this->isMethod('PUT')) {
            $rules['id']    = 'required|exists:charges,id';
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->uniqueChargeCheck()) {
                $validator->errors()->add('uniqueCharge', ___('alert.charge_validation_error'));
            }
        });
    }

    private function uniqueChargeCheck()
    {
        $query = Charge::where(['product_category_id' => $this->product_category_id, 'service_type_id' => $this->service_type_id, 'area' => $this->area]);

        if ($this->isMethod('PUT')) {
            $query->whereNot('id', $this->input('id'));
        }

        return $query->exists();
    }
}

<?php

namespace App\Http\Requests\Coupon;

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
        // dd($this->all());
        return [
            'type'          => 'required|integer',
            'merchant_id'   => 'nullable|array',
            'merchant_id.*' => 'exists:merchants,id',
            'start_date'    => 'required|date|after_or_equal:today|before_or_equal:end_date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'discount_type' => 'required|integer',
            'discount'      => 'required|numeric|min:0',
            'coupon'        => 'required|string|min:1|max:100|unique:coupons,coupon',
        ];
    }
}

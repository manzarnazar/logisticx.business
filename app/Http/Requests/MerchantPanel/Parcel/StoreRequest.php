<?php

namespace App\Http\Requests\MerchantPanel\Parcel;

use App\Enums\UserType;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
{
    use ApiReturnFormatTrait;
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
        // merge auth merchant id if not in request
        if (!$this->has('merchant_id') || $this->get('merchant_id') == null) {
            $this->merge([
                'merchant_id' => auth()->user()->merchant->id ?? null,
            ]);
        }

        \Log::info('test ' . json_encode($this->all()));


        $rules =  [
            'shop_id'           => ['required', 'exists:merchant_shops,id'],
            'pickup_phone'      => ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'],
            'pickup_address'    => ['required', 'string', 'max:191'],

            // 'pickup'            => ['required', 'exists:coverages,id'],
            'destination'       => ['required', 'exists:coverages,id'],

            'cash_collection'   => ['nullable', 'numeric', 'min:0'],
            'selling_price'     => ['nullable', 'numeric', 'min:0'],
            'invoice_no'        => ['nullable', 'string', 'max:50'],

            'customer_name'     => ['required', 'string', 'max:191'],
            'customer_phone'    => ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'],
            'customer_address'  => ['required', 'string', 'max:191'],
            'note'              => ['nullable', 'string', 'max:255'],

            'fragileLiquid' => ['nullable', 'in:on'],

            'vas'               => ['nullable', 'array'],
            'vas.*'             => ['exists:value_added_services,id'],

            'product_category'  => ['required', 'exists:product_categories,id'],
            'service_type'      => ['required', 'exists:service_types,id'],
            // 'area'              => ['required', 'exists:charges,area'],
            'quantity'          => ['required', 'numeric', 'min:0'],
            'charge'            => ['nullable', 'numeric', 'min:0'],
            'coupon'            => ['nullable', 'string', 'exists:coupons,coupon'],

        ];

        if (auth()->user()->user_type != UserType::MERCHANT) {
            $rules['merchant_id']  =  ['required', 'exists:merchants,id'];
        }



        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        \Log::error('Validation failed', $validator->errors()->toArray());

        if ($this->is('api/*') || $this->wantsJson()) {
            $response = $this->responseWithError(___('alert.validation_error'), $validator->errors(), 422);
            throw new ValidationException($validator, $response);
        }

        parent::failedValidation($validator);
    }
}

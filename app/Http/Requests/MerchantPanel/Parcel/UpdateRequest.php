<?php

namespace App\Http\Requests\MerchantPanel\Parcel;

use App\Enums\UserType;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
{
    use ApiReturnFormatTrait;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // merge auth merchant id if not in request
        if (!$this->has('merchant_id') || $this->get('merchant_id') == null) {
            $this->merge([
                'merchant_id' => auth()->user()->merchant->id ?? null,
            ]);
        }

        \Log::info('update request ' . json_encode($this->all()));

        $rules = [
            // 'id'                => ['required', 'exists:parcels,id'],

            'shop_id'           => ['required', 'exists:merchant_shops,id'],
            'pickup_phone'      => ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'],
            'pickup_address'    => ['required', 'string', 'max:191'],

            // 'pickup'         => ['required', 'exists:coverages,id'], // optional if auto-detected
            'destination'       => ['required', 'exists:coverages,id'],

            'cash_collection'   => ['nullable', 'numeric', 'min:0'],
            'selling_price'     => ['nullable', 'numeric', 'min:0'],
            'invoice_no'        => ['nullable', 'string', 'max:50'],

            'customer_name'     => ['required', 'string', 'max:191'],
            'customer_phone'    => ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'],
            'customer_address'  => ['required', 'string', 'max:191'],
            'note'              => ['nullable', 'string', 'max:255'],

            'fragileLiquid'     => ['nullable', 'in:on'],

            'vas'               => ['nullable', 'array'],
            'vas.*'             => ['exists:value_added_services,id'],

            'product_category'  => ['required', 'exists:product_categories,id'],
            'service_type'      => ['required', 'exists:service_types,id'],
            // 'area'            => ['required', 'exists:charges,area'], // skip if auto-handled
            'quantity'          => ['required', 'numeric', 'min:0'],
            'charge'            => ['nullable', 'numeric', 'min:0'],
            'coupon'            => ['nullable', 'string', 'exists:coupons,coupon'],
        ];

        // ✅ Require id only when not cloning
        if ($this->has('id') && !empty($this->id)) {
            $rules['id'] = ['required', 'exists:parcels,id'];
        }

        if (auth()->user()->user_type != UserType::MERCHANT) {
            $rules['merchant_id'] = ['required', 'exists:merchants,id'];
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        \Log::error('Update validation failed', $validator->errors()->toArray());

        if ($this->is('api/*') || $this->wantsJson()) {
            $response = $this->responseWithError(___('alert.validation_error'), $validator->errors(), 422);
            throw new ValidationException($validator, $response);
        }

        parent::failedValidation($validator);
    }
}

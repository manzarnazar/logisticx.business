<?php

namespace App\Http\Requests\Parcel;

use App\Enums\UserType;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        




        $rules = [
            'merchant_id'       => ['required', 'numeric'],
            'shop_id'           => ['required', 'numeric'],
            'pickup_phone'      => ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'],
            'pickup_address'    => ['required', 'string', 'max:191'],
            'destination'       => ['required', 'exists:coverages,id'],

            'cash_collection'   => ['nullable', 'numeric', 'min:0'],
            'selling_price'     => ['nullable', 'numeric', 'min:0'],

            'invoice_no'        => 'nullable|string|max:50',

            'customer_name'     => ['required', 'string', 'max:191'],
            'customer_phone'    => ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'],
            'customer_address'  => ['required', 'string', 'max:191'],
            'note'              => ['nullable', 'string', 'max:255'],

            'fragileLiquid'     => ['in:on'],

            'vas'               => ['nullable', 'array'],
            'vas.*'             => ['exists:value_added_services,id'],

            'product_category'  => ['required', 'exists:product_categories,id'],
            'service_type'      => ['required', 'exists:service_types,id'],
            // 'area'              => 'nullable|in:' . implode(',', array_keys(config('site.areas'))),
            'quantity'          => ['required', 'numeric', 'min:0'],
            'charge'            => ['nullable', 'numeric', 'min:0'],
            'coupon'            => ['nullable', 'string'],

        ];

        if ($this->isMethod('put')) {
            $rules['id']        = ['required', 'exists:parcels,id'];
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        if (auth()->user()->user_type == UserType::MERCHANT) {
            $this->merge(['merchant_id' =>  auth()->user()->merchant->id]);
        }

        if ($this->input('cash_collection') == null) {
            $this->merge(['cash_collection' =>  0]);
        }

        if ($this->input('selling_price') == null) {
            $this->merge(['selling_price' =>  0]);
        }

        if ($this->input('charge') == null) {
            $this->merge(['charge' =>  0]);
        }
    }

    public function response(array $errors)
    {
        if ($this->wantsJson()) {
            return response()->json(['errors' => $errors], 422);
        }

        return parent::response($errors);
    }
}

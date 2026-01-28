<?php

namespace App\Http\Requests\MerchantPanel\PaymentRequest;

use Illuminate\Http\Request;
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
        // if auth merchant not null & merchant null then merge to request 
        if (auth()->user()->merchant && !Request::input('merchant')) {
            $this->merge(['merchant' => auth()->user()->merchant->id]);
            $this->merge(['created_by' => auth()->user()->merchant->id]);
        }
        
        $rules = [
            'merchant'          => 'required|exists:merchants,id',
            'amount'            => 'required|numeric|min:0',
            'merchant_account'  => 'required|exists:merchant_payments,id',
            'parcel_id'         => 'required|array',
            'parcel_id.*'       => 'exists:parcels,id',
        ];

        if ($this->isMethod('put')) {
            $rules['id']    = 'required|exists:payments,id';
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'parcel_id' => 'parcels',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*') || $this->wantsJson()) {
            $response = $this->responseWithError(___('alert.validation_error'), $validator->errors(), 422);
            throw new ValidationException($validator, $response);
        }
        parent::failedValidation($validator);
    }
}

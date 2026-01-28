<?php

namespace App\Http\Requests\PickupRequest;

use App\Enums\PickupRequestType;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PickupStoreRequest extends FormRequest
{
    use ApiReturnFormatTrait;

    /**
     * Authorize the request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        $rules = [
            'request_type' => ['required', 'in:' . PickupRequestType::REGULAR . ',' . PickupRequestType::EXPRESS],
            'address'      => ['nullable', 'string', 'max:500'],
            'note'         => ['nullable', 'string', 'max:500'],
        ];

        if ($this->request_type == PickupRequestType::REGULAR) {
            $rules['parcel_quantity'] = ['required', 'integer', 'min:1'];
        }

        if ($this->request_type == PickupRequestType::EXPRESS) {
            $rules['name']       = ['required', 'string', 'max:255'];
            $rules['phone']      = ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'];
            $rules['cod_amount'] = ['required', 'numeric', 'min:0'];
            $rules['invoice']    = ['nullable', 'string', 'max:255'];
            $rules['weight']     = ['required', 'numeric', 'min:0.1'];
            $rules['exchange']   = ['nullable', 'boolean'];
        }

        return $rules;
    }

    /**
     * Custom attributes for error messages.
     */
    public function attributes(): array
    {
        return [
            'request_type'    => __('pickup request type'),
            'parcel_quantity' => __('parcel quantity'),
            'name'            => __('customer name'),
            'phone'           => __('customer phone'),
            'cod_amount'      => __('COD amount'),
            'invoice'         => __('invoice number'),
            'weight'          => __('parcel weight'),
            'exchange'        => __('exchange flag'),
            'address'         => __('pickup address'),
            'note'            => __('note'),
        ];
    }

    /**
     * Handle failed validation for API vs Web.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*') || $this->wantsJson()) {
            $response = $this->responseWithError(
                ___('alert.validation_error'),
                $validator->errors(),
                422
            );
            throw new ValidationException($validator, $response);
        }

        parent::failedValidation($validator);
    }
}

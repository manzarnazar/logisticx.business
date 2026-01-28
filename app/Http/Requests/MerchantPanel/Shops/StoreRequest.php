<?php

namespace App\Http\Requests\MerchantPanel\Shops;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
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
        return [
            'name'       => ['required', 'string', 'max:255'],
            'contact_no' => ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'],
            'address'    => ['required', 'string'],
            'hub'        => ['required', 'exists:hubs,id'],
            'status'     => ['required', 'boolean'],
        ];
    }

    /**
     * Custom attributes for error messages.
     */
    public function attributes(): array
    {
        return [
            'name'       => __('shop name'),
            'contact_no' => __('contact number'),
            'address'    => __('address'),
            'hub'        => __('hub'),
            'status'     => __('status'),
        ];
    }

    /**
     * Handle failed validation for API vs Web.
     */
    protected function failedValidation(Validator $validator)
    {
        // If API call → return JSON error
        if ($this->is('api/*') || $this->wantsJson()) {
            $response = $this->responseWithError(
                ___('alert.validation_error'),
                $validator->errors(),
                422
            );
            throw new ValidationException($validator, $response);
        }

        // Otherwise fallback to Laravel default (redirect back)
        parent::failedValidation($validator);
    }
}

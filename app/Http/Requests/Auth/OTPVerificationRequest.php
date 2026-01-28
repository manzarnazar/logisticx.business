<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class OTPVerificationRequest extends FormRequest
{
    use ApiReturnFormatTrait;

    /**
     * Determine if the user is authorized to make this request.
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
            'email' => ['required', 'email', 'exists:users,email'],
            'otp'   => ['required', 'numeric', 'digits:6'],
        ];
    }

    /**
     * Custom attribute names (optional).
     */
    public function attributes(): array
    {
        return [
            'email' => __('email address'),
            'otp'   => __('OTP code'),
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

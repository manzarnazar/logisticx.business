<?php

namespace App\Http\Requests\Auth;

use App\Enums\Status;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class SigninRequest extends FormRequest
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
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:32'],
        ];

        if (!$this->is('api/*') && settings('recaptcha_status') == Status::ACTIVE) {
            $rules['g-recaptcha-response'] = ['required', 'recaptcha'];
        }

        return $rules;
    }

    /**
     * Custom attributes for error messages.
     */
    public function attributes(): array
    {
        return [
            'email'    => __('email address'),
            'password' => __('password'),
            'g-recaptcha-response' => __('reCAPTCHA verification'),
        ];
    }

    /**
     * Custom messages.
     */
    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => ___('alert.please_complete_the_reCAPTCHA_verification'),
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

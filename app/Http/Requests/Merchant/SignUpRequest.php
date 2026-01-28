<?php

namespace App\Http\Requests\Merchant;

use App\Enums\Status;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class SignUpRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'business_name' => ['required', 'string', 'unique:merchants'],
            'full_name'     => ['required', 'string', 'max:100'],
            'mobile'        => ['required', 'regex:/^(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})$/', 'unique:users,mobile'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required', 'min:6', 'max:32'],
            'address'       => ['required', 'string', 'max:191'],
            'hub'           => ['required', 'exists:hubs,id'],
            'pickup_slot'   => ['nullable', 'exists:pickup_slots,id'],
            'policy'        => ['required', 'accepted'],
        ];

        // Add recaptcha only for web requests (not API)
        if (!$this->is('api/*') && settings('recaptcha_status') == Status::ACTIVE) {
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }

        return $rules;
    }

    /**
     * Custom attributes for error messages.
     */
    public function attributes(): array
    {
        return [
            'business_name' => __('business name'),
            'full_name'     => __('full name'),
            'mobile'        => __('mobile number'),
            'email'         => __('email address'),
            'password'      => __('password'),
            'address'       => __('address'),
            'hub'           => __('hub'),
            'pickup_slot'   => __('pickup slot'),
            'policy'        => __('policy'),
        ];
    }

    /**
     * Custom validation messages.
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
        // If API call → return JSON error
        if ($this->is('api/*') || $this->wantsJson()) {
            $response = $this->responseWithError(
                ___('alert.validation_error'),
                $validator->errors(),
                422
            );
            throw new ValidationException($validator, $response);
        }

        // Otherwise fallback to Laravel default
        parent::failedValidation($validator);
    }
}

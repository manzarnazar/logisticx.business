<?php

namespace App\Http\Requests\Support;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class SupportStoreRequest extends FormRequest
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
            'department_id' => ['required', 'exists:departments,id'],
            'service'       => ['required', 'in:' . implode(',', array_keys(config('site.support.services')))],
            'priority'      => ['required', 'in:' . implode(',', array_keys(config('site.support.priority')))],
            'subject'       => ['required', 'string', 'max:250'],
            'attached_file' => ['nullable', 'mimes:png,jpg,jpeg,webp,pdf', 'max:5120'],
        ];
    }

    /**
     * Custom attributes for error messages.
     */
    public function attributes(): array
    {
        return [
            'department_id' => __('department'),
            'service'       => __('service'),
            'priority'      => __('priority'),
            'subject'       => __('subject'),
            'attached_file' => __('attached file'),
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

<?php

namespace App\Http\Requests\Profile;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PasswordUpdateRequest extends FormRequest
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
        return [
            'old_password'     => ['required', 'max:50'],
            'new_password'     => ['required', 'min:6', 'max:32'],
            'confirm_password' => ['required_with:new_password', 'same:new_password', 'min:6', 'max:32'],
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

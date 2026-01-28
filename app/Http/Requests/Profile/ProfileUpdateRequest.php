<?php

namespace App\Http\Requests\Profile;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ProfileUpdateRequest extends FormRequest
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
            'name'    => 'required|string|min:2|max:50',
            'email'   => 'required|email|unique:users,email,' . auth()->user()->id,
            'mobile'  => 'required|regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/|unique:users,mobile,' . auth()->user()->id,
            'address' => 'required|string|max:100',
            'image'   => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5098',
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

    // public function response(array $errors)
    // {
    //     if ($this->expectsJson()) {
    //         return response()->json(['errors' => $errors], 422);
    //     }

    //     return parent::response($errors);
    // }
}

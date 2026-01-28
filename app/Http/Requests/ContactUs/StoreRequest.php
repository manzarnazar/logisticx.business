<?php

namespace App\Http\Requests\ContactUs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // dd($this->all());
        return [
            'name'      => 'required|string|min:3|max:100',
            'email'     => 'required|email',
            'phone'     => 'required',
            'address'   => 'required',
            'subject'   => 'required',
            'message'   => 'required|string|max:255',
            // 'agree'     => 'required|in:on',
        ];
    }

    // public function response(array $errors)
    // {
    //     if ($this->expectsJson()) {
    //         return new JsonResponse($errors, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    //     }

    //     return parent::response($errors);
    // }

    // public function messages()
    // {
    //     return [
    //         'agree.required'  => 'You have to agree.'
    //     ];
    // }
}

<?php

namespace App\Http\Requests\Parcel;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'file'          => 'required',
            'merchant_id'   => 'nullable|exists:merchants,id'
        ];

        if (auth()->user()->user_type != UserType::MERCHANT) {
            $rules['merchant_id'] = 'required';
        }

        return $rules;
    }
}

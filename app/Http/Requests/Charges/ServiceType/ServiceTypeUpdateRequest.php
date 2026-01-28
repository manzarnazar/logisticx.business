<?php

namespace App\Http\Requests\Charges\ServiceType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ServiceTypeUpdateRequest extends FormRequest
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
        return [
            'id'        => 'required|exists:service_types,id',
            'name'      => 'required|string|min:3|max:100|unique:service_types,name,' . Request::input('id'),
            'position'  => 'nullable|numeric|min:0',
            'status'    => 'boolean'
        ];
    }
}

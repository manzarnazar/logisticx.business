<?php

namespace App\Http\Requests\Charges\ValueAddedService;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class VASUpdateRequest extends FormRequest
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
            'id'        => 'required|exists:value_added_services,id',
            'name'      => 'required|string|min:3|max:100|unique:value_added_services,name,' . Request::input('id'),
            'price'     => 'required|numeric|min:0',
            'position'  => 'nullable|numeric|min:0',
            'status'    => 'boolean'
        ];
    }
}

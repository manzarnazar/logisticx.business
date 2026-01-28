<?php

namespace App\Http\Requests\Charges\ServiceFaq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class ServiceFaqUpdateRequest extends FormRequest
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
            'id'        => 'required|exists:service_faqs,id',
            'title'      => 'required|string|min:3|max:100|unique:service_faqs,title,' . Request::input('id'),
            'position'  => 'nullable|numeric|min:0',
            'status'    => 'boolean'
        ];
    }
}

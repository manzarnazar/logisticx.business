<?php

namespace App\Http\Requests\Charges\HomePageSlider;

use Illuminate\Foundation\Http\FormRequest;

class HomePageSliderStoreRequest extends FormRequest
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
            'small_title'      => 'required|string|min:3|max:100',
            'title'      => 'required|string|min:3|max:300',
            'position'  => 'nullable|numeric|min:0',
            'status'    => 'boolean'
        ];
    }
}

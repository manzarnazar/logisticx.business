<?php

namespace App\Http\Requests\Charges\HomePageSlider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class HomePageSliderUpdateRequest extends FormRequest
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
            'id'        => 'required|exists:home_page_sliders,id',
            'small_title' => 'required|string|min:3|max:100',
            'title'      => 'required|string|min:3|max:300',
            'position'  => 'nullable|numeric|min:0',
            'status'    => 'boolean'
        ];
    }
}

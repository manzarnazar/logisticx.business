<?php

namespace Modules\Features\Http\Requests\features;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:5098',
            'description' => 'nullable|string',
            'position'    => ['nullable', 'numeric', 'min:0'],
            'status'      => 'boolean',
            
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

<?php

namespace Modules\Testimonial\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_name'       => ['required', 'string', 'max:50'],
            'image'             => ['nullable', 'mimes:png,jpg'],
            'designation'       => ['required', 'string'],
            'rating'            => ['required', 'numeric', 'min:0.5', 'max:5'],
            'position'          => ['nullable', 'numeric', 'min:0'],
            'status'            => ['boolean'],
            'description'       => ['required', 'string'],
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

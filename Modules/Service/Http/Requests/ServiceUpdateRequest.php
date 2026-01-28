<?php

namespace Modules\Service\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => 'required|string|min:2|max:100',
            'image'             => 'nullable|image|mimes:png,jpg',
            'banner_image'      => 'nullable|image|mimes:png,jpg',
            'position'          => 'nullable|numeric|min:0',
            'status'            => 'required|boolean',
            'short_description' => 'nullable|string',
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

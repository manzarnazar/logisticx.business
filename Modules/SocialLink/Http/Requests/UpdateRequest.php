<?php

namespace Modules\SocialLink\Http\Requests;

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
            'name'    => ['required'],
            'icon'    => ['required'],
            'link'    => ['required', 'url'],
            'position' => ['nullable', 'numeric'],
            'status'  => ['required', 'boolean']
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

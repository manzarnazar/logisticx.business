<?php

namespace Modules\Pages\Http\Requests;

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
            'page'          => ['required'],
            'title'         => ['required'],
            'description'   => ['nullable', 'string'],
            'position'      => ['nullable', 'numeric', 'min:0'],
            'status'        => ['required', 'boolean'],
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

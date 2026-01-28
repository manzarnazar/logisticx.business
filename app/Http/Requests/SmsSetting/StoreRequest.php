<?php

namespace App\Http\Requests\SmsSetting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gateway'                => ['required', 'string', 'max:191'],
            'api_key'                => ['required', 'string', 'max:191'],
            'secret_key'             => ['nullable', 'string', 'max:191'],
            'api_url'                => ['nullable', 'url'],
            'username'               => ['nullable', 'string', 'max:191'],
            'user_password'          => ['nullable', 'string', 'max:191'],
            'status'                 => ['required', 'boolean'],
        ];
    }
}

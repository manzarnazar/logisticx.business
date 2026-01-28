<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class MailSettingUpdateRequest extends FormRequest
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
            'sendmail_path'               => 'required|string',
            'mail_driver'                 => 'required|string',
            'mail_host'                   => 'required|string',
            'mail_port'                   => 'required|string',
            'mail_username'               => 'required|string',
            'mail_password'               => 'required|string',
            'mail_encryption'             => 'required|string',
            'mail_address'                => 'required|email',
            'mail_name'                   => 'required|string',
            'signature'                   => 'required',
        ];
    }
}

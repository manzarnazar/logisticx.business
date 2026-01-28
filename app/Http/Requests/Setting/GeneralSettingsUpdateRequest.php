<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingsUpdateRequest extends FormRequest
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
            'name'              => 'required|string',
            'phone'             => 'required|regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/',
            'email'             => 'required|email',
            'currency'          => 'required',
            'par_track_prefix'  => 'required|string',
            'invoice_prefix'    => 'required|string',
            'logo'              => 'nullable|image|mimes:png,jpg,jpeg,svg,webp',
            'favicon'           => 'nullable|image|mimes:png,jpg,jpeg,svg,webp,ico',
            'copyright'         => 'required|string',
        ];
    }
}

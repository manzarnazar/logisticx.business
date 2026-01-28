<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        // dd($this->all());
        return [
            'name'           => ['required', 'string', 'max:191'],
            'email'          => ['required', 'string', 'unique:users,email'],
            'password'       => ['nullable', 'string', 'min:6', 'max:32'],
            'mobile'         => ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/', 'unique:users,mobile'],
            'nid_number'     => ['nullable', 'numeric', 'digits_between:1,20'],
            'designation_id' => ['required', 'exists:designations,id'],
            'department_id'  => ['required', 'exists:departments,id'],
            'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp'],
            'joining_date'   => ['required', 'date'],
            'salary'         => ['nullable', 'numeric', 'min:0'],
            'address'        => ['required', 'string', 'max:191'],
            'status'         => ['required', 'boolean'],
            'role_id'        => 'required|exists:roles,id',
            'hub_id'         => 'required|exists:hubs,id',
        ];
    }
}

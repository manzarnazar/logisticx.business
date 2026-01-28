<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateUserRequest extends FormRequest
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
        if (Request::input('id') != 1) {
            return [
                'name'           => ['required', 'string', 'max:191'],
                'email'          => 'required|string|unique:users,email,' . Request::input('id'),
                'password'       => ['nullable'],
                'mobile'         => 'required|regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/|unique:users,mobile,' . Request::input('id'),
                'nid_number'     => ['nullable', 'numeric', 'digits_between:1,20'],
                'designation_id' => ['required', 'exists:designations,id'],
                'department_id'  => ['required', 'exists:departments,id'],
                'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp'],
                'salary'         => ['numeric'],
                'joining_date'   => ['required'],
                'address'        => ['required', 'string', 'max:191'],
                'status'         => ['required', 'numeric'],
                'role_id'        => 'required|exists:roles,id',
                'hub_id'         => 'required|exists:hubs,id',
            ];
        } else {
            return [
                'name'           => ['required', 'string', 'max:191'],
                'email'          => 'required|string|unique:users,email,' . Request::input('id'),
                'password'       => ['nullable', 'string', 'min:6', 'max:32'],
                'mobile'         => 'required|regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/|unique:users,mobile,' . Request::input('id'),
                'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp'],
                'address'        => ['required', 'string', 'max:191'],
            ];
        }
    }
}

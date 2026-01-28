<?php

namespace App\Http\Requests\DeliveryMan;

use App\Models\Backend\DeliveryMan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class DeliveryManRequest extends FormRequest
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
        if (Request::input('id')) {

            $user   = DeliveryMan::findOrFail(Request::input('id'));
            $userID = $user->user_id;

            $email    = ['required', 'email', 'string', Rule::unique("users", "email")->ignore($userID)];
            $mobile   = ['required', 'regex:/^(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})$/', Rule::unique("users", "mobile")->ignore($userID)];

            $password = ['nullable', 'min:6', 'max:32'];
        } else {
            $email    = ['required', 'email', 'string', 'unique:users,email'];
            $mobile   = ['required', 'regex:/^(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})$/', 'unique:users,mobile'];
            $password = ['required', 'min:6', 'max:32'];
        }

        return [

            'name'                       => ['required', 'string', 'max:50'],
            'email'                      => $email,
            'password'                   => $password,
            'mobile'                     => $mobile,
            'address'                    => ['required', 'string', 'max:200'],
            'hub_id'                     => ['required', 'exists:hubs,id'],
            'delivery_charge'            => ['nullable', 'numeric', 'min:0'],
            'pickup_charge'              => ['nullable', 'numeric', 'min:0'],
            'return_charge'              => ['nullable', 'numeric', 'min:0'],
            'status'                     => ['required', 'boolean'],

            'salary'                     => ['nullable', 'numeric', 'min:0'],
            'opening_balance'            => ['nullable', 'numeric', 'min:0'],

            'image_id'                   => 'nullable|image|mimes:jpeg,png,jpg|max:5098',
            'driving_license'           => 'nullable|mimes:jpeg,png,jpg,pdf|max:5098',

            'coverage'                  => 'required|exists:coverages,id',
            'pickup_slot'               => 'required|exists:pickup_slots,id'

        ];
    }

    public function attributes()
    {
        return [
            'name'                       => trans('validation.attributes.name'),
            'status'                     => trans('validation.attributes.status'),
            'email'                      => trans('validation.attributes.email'),
            'mobile'                     => trans('validation.attributes.phone'),
            'address'                    => trans('validation.attributes.address'),
            'hub_id'                     => trans('validation.attributes.hub_id'),
            'opening_balance'            => trans('validation.attributes.opening_balance'),
            'delivery_charge'            => trans('validation.attributes.delivery_charge'),
            'pickup_charge'              => trans('validation.attributes.pickup_charge'),
            'return_charge'              => trans('validation.attributes.return_charge'),
            'image_id'                   => trans('validation.attributes.image_id'),
            'coverage'                   => 'Coverage Area',
        ];
    }
}

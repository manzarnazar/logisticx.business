<?php

namespace App\Http\Requests\Merchant;

use App\Models\Backend\Merchant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        // this request rules file may no need 
        $merchant   = Merchant::findOrFail($this->id);
        $userID = $merchant->user_id;

        return [
            'id'                    => 'required|exists:merchants,id',
            'name'                  => 'required|string|max:191',
            'business_name'         => 'required|string|unique:merchants,business_name,' . $this->id,
            'mobile'                => 'required|regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/|unique:users,mobile,' . $userID,
            'email'                 => 'required|email|unique:users,email,' . $userID,
            'hub'                   => 'required|exists:hubs,id',
            'status'                => 'required|boolean',
            'password'              => 'nullable|min:6|max:32',
            'address'               => 'required|string|max:255',

            'image'                 => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5120',
            'nid'                   => 'nullable|mimes:png,jpg,jpeg,webp,pdf|max:5120',
            'trade_license'         => 'nullable|mimes:png,jpg,jpeg,webp,pdf|max:5120',

            'nid_number'            => ['nullable', 'numeric', 'digits_between:1,20'],
            'coverage'              => 'required|exists:coverages,id',
            'pickup_slot'           => 'required|exists:pickup_slots,id',


        ];
    }
}

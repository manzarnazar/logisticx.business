<?php

namespace App\Http\Requests\Merchant;

use App\Models\Backend\Merchant;
use Illuminate\Foundation\Http\FormRequest;

class MerchantStoreRequest extends FormRequest
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
        $rules = [
            'name'                  => 'required|string|max:50',
            'email'                 => 'required|email|unique:users,email',
            'mobile'                => 'required|regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/|unique:users,mobile',
            'password'              => 'required|min:6|max:32',
            'nid_number'            => 'nullable|numeric|digits_between:1,20',
            'business_name'         => 'required|string|max:100|unique:merchants',
            'hub'                   => 'required|exists:hubs,id',

            'reference_name'        => 'nullable|string|max:50',
            'reference_phone'       => 'nullable|regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/',

            // 'coverage'              => 'required|exists:coverages,id',
            'pickup_slot'           => 'required|exists:pickup_slots,id',
            'status'                => 'required|numeric',
            'address'               => 'required|string|max:191',

            'image'                 => 'nullable|image|mimes:png,jpg,jpeg,webp|max:10240',
            'nid'                   => 'nullable|mimes:png,jpg,jpeg,webp,pdf|max:10240',
            'trade_license'         => 'nullable|mimes:png,jpg,jpeg,webp,pdf|max:10240',

        ];

        if ($this->isMethod('put')) {
            $merchant               = Merchant::findOrFail($this->id);
            $rules['id']            = 'required|exists:merchants,id';
            $rules['business_name'] = 'required|string|max:100|unique:merchants,business_name,' . $this->id;
            $rules['mobile']        = 'required|regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/|unique:users,mobile,' . $merchant->user_id;
            $rules['email']         = 'required|email|unique:users,email,' . $merchant->user_id;
            $rules['password']      = 'nullable|min:6|max:32';
        }

        return $rules;
    }
}

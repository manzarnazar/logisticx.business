<?php

namespace App\Http\Requests\MerchantProfile;

use App\Models\Backend\Merchant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
        $userID     = Auth::user()->id;
        $merchant   = Merchant::where('user_id', $userID)->first();

        return [
            'name'          => ['required', 'string', 'max:191'],


            'business_name'         => 'required|string|unique:merchants,business_name,' . $merchant->id,
            'mobile'                => 'required|numeric|digits_between:11,14|unique:users,mobile,' . $userID,
            'email'                 => ['required', 'email', 'unique:users,email,' . $userID],


            'address'   => ['required'],
            'coverage'  => 'required|exists:coverages,id',

            'image_id'                 => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5120',
            'nid'                   => 'nullable|mimes:png,jpg,jpeg,webp,pdf|max:5120',
            'trade_license'         => 'nullable|mimes:png,jpg,jpeg,webp,pdf|max:5120',
        ];
    }
}

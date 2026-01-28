<?php

namespace App\Http\Requests\Account;

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
        $rules =  [
            // 'type'                => ['required'],
            'hub'                 => ['required', 'exists:hubs,id'],
            'user'                => ['required', 'exists:users,id'],
            'gateway'             => ['required'],
        ];

        if (Request::input('gateway') == 1) {
            $rules['balance'] = ['required', 'numeric', 'min:0'];
        } else {
            $rules['opening_balance']       = ['required', 'numeric', 'min:0'];
            $rules['account_holder_name']   = ['required', 'string', 'max:50'];
        }

        if (Request::input('gateway') == 2) {
            $rules['account_no']          = ['required', 'numeric'];
            $rules['bank']                = ['required', 'exists:banks,id'];
            $rules['branch_name']         = ['required', 'string', 'max:50'];
        }

        if (Request::input('gateway') == 3 || Request::input('gateway') == 4 || Request::input('gateway') == 5) {
            $rules['mobile']                = ['required', 'numeric', 'digits_between:11,14'];
            $rules['account_type']          = ['required'];
            $rules['status']                = ['required'];
        }

        return $rules;
    }
}

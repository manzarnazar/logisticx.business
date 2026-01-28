<?php

namespace App\Http\Requests\HubManage\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class HubPaymentRequest extends FormRequest
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
            'hub_id'            => 'required|exists:hubs,id',
            'hub_account_id'    => 'required|exists:accounts,id',
            'amount'            => 'required|numeric|min:0',
            'description'       => 'nullable|string|max:5000',
        ];

        if (Request::input('isprocess')) {
            $rules['from_account']      = 'required|exists:accounts,id';
            $rules['transaction_id']    = 'required|string|max:50';
            $rules['reference_file']    = 'nullable|mimes:jpeg,png,jpg,webp,pdf|max:10124';
        }

        if ($this->isMethod('put')) {
            $validation['id']      = 'required|exists:hub_payments,id';
        }

        return $rules;
    }
}

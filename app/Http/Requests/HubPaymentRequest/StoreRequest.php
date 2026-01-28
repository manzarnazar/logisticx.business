<?php

namespace App\Http\Requests\HubPaymentRequest;

use Illuminate\Foundation\Http\FormRequest;

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
        $rules = [
            'hub_account_id'    => 'required|exists:accounts,id',
            'amount'            => 'required|numeric|min:0',
            'description'       => 'nullable|string|max:5000',
        ];

        if ($this->isMethod('put')) {
            $validation['id']      = 'required|exists:hub_payments,id';
        }

        return $rules;
    }
}

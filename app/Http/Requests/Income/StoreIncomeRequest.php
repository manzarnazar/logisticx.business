<?php

namespace App\Http\Requests\Income;

use App\Enums\FixedAccountHeads;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class StoreIncomeRequest extends FormRequest
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
        $validation =  [
            'account_head_id'   => 'required|exists:account_heads,id',
            'date'              => 'nullable|date',
            'receipt'           => 'nullable|mimes:jpeg,png,jpg,webp,pdf|max:5098',
            'amount'            => 'required|numeric|min:1',
            'note'              => 'nullable|string|max:1000',

            'parcel_id'         => 'required|array',
            'parcel_id.*'       => 'exists:parcels,id',
            'account_id'        => 'required|exists:accounts,id',
        ];

        if ($this->input('account_head_id') == FixedAccountHeads::ReceiveFromDeliveryMan) {
            $validation['delivery_man_id']  = 'required|exists:delivery_man,id';
            $validation['hub_id']           = 'required|exists:hubs,id';
            $validation['hub_account_id']   = 'required|exists:accounts,id';
            $validation['account_id']       = 'nullable|exists:accounts,id';
        } else if ($this->input('account_head_id') == FixedAccountHeads::ReceiveFromHub) {
            $validation['hub_id']           = 'required|exists:hubs,id';
            $validation['hub_account_id']   = 'required|exists:accounts,id';
        } else if ($this->input('account_head_id') == FixedAccountHeads::ReceiveFromMerchant) {
            $validation['merchant_id']      = 'required|exists:merchants,id';
        } else {
            $validation['title']            = 'required|string|max:255';
            $validation['parcel_id']        = 'nullable|array';
        }

        if ($this->isMethod('put')) {
            $validation['id']      = 'required|exists:incomes,id';
        }

        return $validation;
    }

    public function response(array $errors)
    {
        if ($this->wantsJson()) {
            return response()->json(['errors' => $errors], 422);
        }

        return parent::response($errors);
    }

    public function prepareForValidation()
    {
        if ($this->input('parcel_id') == null) {
            $this->merge(['parcel_id' =>  []]);
        }
    }

    public function attributes()
    {
        return [
            'account_head_id'       => trans('label.account_head'),
            'hub_id'                => trans('label.hub'),
            'hub_account_id'        => trans('label.hub_account'),
            'account_head_id'       => trans('label.account_head'),
            'merchant_id'           => trans('label.merchant'),
            'delivery_man_id'       => trans('label.delivery_man'),
            'account_id'            => trans('label.account'),
        ];
    }
}

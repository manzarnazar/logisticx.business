<?php

namespace App\Http\Requests\Expense;

use App\Enums\FixedAccountHeads;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class StoreExpenseRequest extends FormRequest
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

        $validation =  [
            'account_head_id'   => 'required|exists:account_heads,id',
            'date'              => 'nullable|date',
            'receipt'           => 'nullable|mimes:jpeg,png,jpg,webp,pdf|max:10124',
            'amount'            => 'required|numeric|min:1',
            'note'              => 'nullable|string|max:1000',
            'account_id'        => 'required|exists:accounts,id', // from account 
        ];

        if ($this->input('account_head_id') == FixedAccountHeads::PayDeliveryManCommission) {
            $validation['delivery_man_id']  = 'required|exists:delivery_man,id';
            $validation['parcel_id']        = 'required|array';
            $validation['parcel_id.*']      = 'exists:parcels,id';
        } elseif ($this->input('account_head_id') == FixedAccountHeads::PayToHub) {
            $validation['hub_id']           = 'required|exists:hubs,id';
            $validation['hub_account_id']   = 'required|exists:accounts,id';
        } else {
            $validation['title']            = 'required|string|max:255';
        }

        if ($this->isMethod('put')) {
            $validation['id']      = 'required|exists:expenses,id';
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
            'delivery_man_id'       => trans('label.delivery_man'),
            'account_id'            => trans('label.account'),
        ];
    }
}

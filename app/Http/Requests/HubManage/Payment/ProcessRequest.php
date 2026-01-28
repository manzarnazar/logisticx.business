<?php

namespace App\Http\Requests\HubManage\Payment;

use Illuminate\Foundation\Http\FormRequest;

class ProcessRequest extends FormRequest
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
        return [
            'id'                => 'required|exists:hub_payments,id',
            'from_account'      => 'required|exists:accounts,id',
            'transaction_id'    => 'required|string|max:50',
            'reference_file'    => 'nullable|mimes:jpeg,png,jpg,webp,pdf|max:10124',
        ];
    }
}

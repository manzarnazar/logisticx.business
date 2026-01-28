<?php

namespace App\Http\Requests\MerchantPanel\Parcel;

use App\Enums\PickupRequestType;
use Illuminate\Foundation\Http\FormRequest;

class PickupStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'request_type'  => 'present|in:' . PickupRequestType::REGULAR . ',' . PickupRequestType::EXPRESS,
            'address'       => 'required|string|max:191',
            'note'          => 'nullable|string',
        ];

        if ($this->request_type == PickupRequestType::REGULAR) {
            $rules['parcel_quantity'] = 'required|numeric|min:0';
        }

        if ($this->request_type == PickupRequestType::EXPRESS) {
            $rules['name']          = 'required|string|max:100';
            $rules['phone']         = 'required|regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/';
            $rules['cod_amount']    = 'nullable|numeric|min:0';
            $rules['invoice']       = 'nullable|string|max:50';
            $rules['weight']        = 'nullable|numeric|min:0';
            $rules['exchange']      = 'nullable|boolean';
        }

        return $rules;
    }

    public function response(array $errors)
    {
        if ($this->wantsJson()) {
            return response()->json(['errors' => $errors], 422);
        }

        return parent::response($errors);
    }
}

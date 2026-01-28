<?php

namespace App\Http\Requests\Merchant;

use App\Enums\UserType;
use App\Enums\Merchant_panel\PaymentMethod;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PaymentInfoStore extends FormRequest
{
    use ApiReturnFormatTrait;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        // dd($this->request);
        $rules =  [
            'payment_method'    => ['required', 'in:' . PaymentMethod::cash . ',' . PaymentMethod::bank . ',' . PaymentMethod::mfs],
            'status'            => ['required', 'boolean'],
            'merchant_id'       => 'required|exists:merchants,id'
        ];

        if ($this->input('payment_method') == PaymentMethod::bank || $this->input('payment_method') == PaymentMethod::mfs) {
            $rules['account_name']  = ['required', 'min:2', 'max:50'];
            $rules['mobile_no']     = ['required', 'regex:/^\+?[0-9]{1,4}-?[0-9]{7,14}$/'];
        }

        if ($this->input('payment_method') == PaymentMethod::bank) {
            $rules['bank_id']           = ['required', 'exists:banks,id'];
            $rules['account_no']        = ['required',];
            $rules['bank_account_type'] = ['nullable', 'string', 'min:1', 'max:30'];
            $rules['routing_no']        = ['nullable', 'numeric', 'digits_between:2,30'];
            $rules['branch_name']       = ['nullable', 'min:2', 'max:50'];
            return $rules;
        }

        if ($this->input('payment_method') == PaymentMethod::mfs) {
            $rules['mfs']      = ['required'];
            $rules['mfs_account_type']  = ['required', 'string', 'min:1', 'max:30'];
            return $rules;
        }

        if ($this->isMethod('put')) {
            $rules['id']  = 'required|exists:merchant_payments,id';
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        if (auth()->user()->user_type == UserType::MERCHANT) {
            $this->merge(['merchant_id' => auth()->user()->merchant->id]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*') || $this->wantsJson()) {
            $response = $this->responseWithError(___('alert.validation_error'), $validator->errors(), 422);
            throw new ValidationException($validator, $response);
        }

        parent::failedValidation($validator);
    }
}

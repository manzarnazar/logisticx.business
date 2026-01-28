<?php

namespace App\Http\Requests\Payroll;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // dd($this->all());
        $rules =  [
            'user_id' => ['required', 'exists:users,id'],
            'month'   => ['required'],

            'allowance' => ['nullable', 'array'],
            'allowance.*.name' => ['string', 'max:100'],
            'allowance.*.amount' => ['numeric', 'min:0'],

            'deduction' => ['nullable', 'array'],
            'deduction.*.name' => ['string', 'max:100'],
            'deduction.*.amount' => ['numeric', 'min:0'],

            'note'  => ['nullable', 'string', 'max:255'],
        ];

        if ($this->input('_method') == 'put') {
            $rules['id']        = 'required|exists:salary_generates,id';
            $rules['user_id']   = 'nullable';
        }


        return $rules;
    }
}

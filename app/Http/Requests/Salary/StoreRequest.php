<?php

namespace App\Http\Requests\Salary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

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

        if ($this->isMethod('put')) {
            $rules['id']        = 'required|exists:salary_generates,id';
            $rules['user_id']   = 'nullable';
        }

        return $rules;
    }

    public function prepareForValidation()
    {
        if ($this->allowance != null) {
            $this->merge([
                'allowance' => collect($this->allowance)->filter(function ($item) {
                    return !empty($item['amount']) && $item['amount'] >= 0;
                })->values()->toArray(),
            ]);
        }

        if ($this->deduction != null) {
            $this->merge([
                'deduction' => collect($this->deduction)->filter(function ($item) {
                    return !empty($item['amount']) && $item['amount'] >= 0;
                })->values()->toArray(),
            ]);
        }
    }
}

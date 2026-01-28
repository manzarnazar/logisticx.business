<?php

namespace App\Http\Requests\Parcel;

use App\Enums\UserType;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ParcelDeliveredRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd($this->all());
        $rules =  [
            'parcel_id'         => 'required|exists:parcels,id',
            'note'              => 'nullable|string|max:1000',
            'quantity'          => 'nullable|numeric|min:1', // required if partial delivered
            'cash_collection'   => 'nullable|numeric|min:0', // need if partial delivered has new cash_collection
        ];

        if (auth()->user()->user_type == UserType::DELIVERYMAN) {
            $rules['otp']       = 'required|exists:parcel_status_updates,otp';
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*') || $this->wantsJson()) {
            $response = $this->responseWithError(___('alert.validation_error'), ['errors' => $validator->errors()], 422);
            throw new ValidationException($validator, $response);
        }

        parent::failedValidation($validator);
    }
}

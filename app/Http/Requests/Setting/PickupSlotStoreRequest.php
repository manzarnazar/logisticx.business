<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class PickupSlotStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|string|unique:pickup_slots',
            'start_time'    => 'required',
            'end_time'      => 'required',
            'position'      => 'nullable|numeric',
            'status'        => 'required|boolean'
        ];
    }
}

<?php

namespace Modules\Leave\Http\Requests\LeaveRequest;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequestStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_id'       => 'required|exists:leave_types,id',
            'reason'        => 'required',
            'file_id'       => 'nullable|image|mimes:jpeg,png,jpg|max:5098',
            'days'          => 'nullable|numeric',
            'date'          => ['required'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

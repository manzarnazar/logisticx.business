<?php

namespace Modules\Leave\Http\Requests\LeaveType;

use Illuminate\Foundation\Http\FormRequest;

class LeaveTypeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'   => 'required|exists:leave_types,id',
            'name' => 'required|min:2|max:30|unique:leave_types,name,' . request('id') . ',id',

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

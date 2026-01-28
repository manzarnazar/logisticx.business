<?php

namespace Modules\Leave\Http\Requests\LeaveAssign;

use Illuminate\Foundation\Http\FormRequest;

class LeaveAssignUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'            => 'required|exists:leave_assigns,id',
            'department_id' => 'required|exists:departments,id',
            'type_id'       => 'required|exists:leave_types,id',
            'days'          => 'required|integer|min:1',
            'status'        => 'required|boolean',
            'position'      => 'nullable|integer|min:0'
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

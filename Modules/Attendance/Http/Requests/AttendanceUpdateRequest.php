<?php

namespace Modules\Attendance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id'   => 'required|exists:users,id',
            'date'      => 'required|date',
            'check_in'  => 'nullable|date_format:H:i:s',
            'check_out' => 'nullable|date_format:H:i:s',
            'type'      => 'required|in:' . implode(',', array_keys(config('attendance.type'))),
            'note'      => 'nullable|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}

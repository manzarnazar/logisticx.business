<?php

namespace Modules\Attendance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user'                      => 'required|array',
            'user.*.id'                 => 'required|exists:users,id',
            'user.*.check_in'           => 'nullable|date_format:H:i:s',
            'user.*.check_out'          => 'nullable|date_format:H:i:s',
            'user.*.attendance_type'    => 'required|in:' . implode(',', array_keys(config('attendance.type'))),
            'user.*.note'               => 'nullable|string',
            'date'                      => 'nullable|date',
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

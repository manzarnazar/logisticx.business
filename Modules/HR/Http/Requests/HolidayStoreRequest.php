<?php

namespace Modules\HR\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class HolidayStoreRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->input('days')) {
            $date = preg_split('/\bto\b/i', $this->input('days'));
            $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
            $to     = isset($date[1]) ? Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString() : $from;
            $this->merge(['from' => $from, 'to' => $to,]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'     => 'required|string|max:255',
            'days'      => 'required',
            'from'      => 'date',
            'to'        => 'date|after_or_equal:from',
            'description' => 'required|string|max:255',
            'file'      => 'nullable|file|mimes:jpeg,jpg,png,webp,pdf|max:2048',
            'status'    => 'required|boolean',
        ];

        if ($this->input('_method') == 'put') {
            $rules['id']    = 'required|exists:holidays,id';
        }

        return $rules;
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

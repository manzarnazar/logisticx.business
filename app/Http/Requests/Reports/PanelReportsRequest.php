<?php

namespace App\Http\Requests\Reports;

use App\Enums\UserType;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PanelReportsRequest extends FormRequest
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
            'get_report'    => 'nullable',
            'date'          => 'nullable|string|regex:/^\d{4}-\d{2}-\d{2}( to \d{4}-\d{2}-\d{2})?$/',
        ];

        if ($this->get_report) {
            $rules['user_type']    = 'required|in:' . UserType::MERCHANT . ',' . UserType::HUB . ', ' . UserType::DELIVERYMAN;
        }

        if ($this->user_type == UserType::MERCHANT) {
            $rules['merchant_id'] = 'required|exists:merchants,id';
        }

        if ($this->user_type == UserType::HUB) {
            $rules['hub_id'] = 'required|exists:hubs,id';
        }

        if ($this->user_type == UserType::DELIVERYMAN) {
            $rules['delivery_man_id'] = 'required|exists:delivery_man,id';
        }

        return $rules;
    }

    // after validation successful
    protected function passedValidation()
    {
        if ($this->has('date') && $this->date != null) {

            $date_between = explode('to', $this->date);
            if (is_array($date_between)) {

                $from = $to = Carbon::parse(trim($date_between[0]));

                if (count($date_between) > 1) {
                    $to = Carbon::parse(trim($date_between[1]));
                }

                $this->merge(['date_between' => ['from' => $from->startOfDay(), 'to' => $to->endOfDay()]]);
            }
        }
    }
}

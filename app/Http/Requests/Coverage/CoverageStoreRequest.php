<?php

namespace App\Http\Requests\Coverage;

use Illuminate\Foundation\Http\FormRequest;

class CoverageStoreRequest extends FormRequest
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
        $rules =  [
            'parent'    => 'nullable|exists:coverages,id',
            'name'      => 'required|unique:coverages,name,NULL,id,parent_id,' . $this->parent,
            'position'  => 'nullable|numeric|min:0',
            'status'    => 'required|boolean',
        ];

        if ($this->isMethod('PUT')) {
            $rules['id']    = 'required|exists:coverages,id';
            $rules['name']  = 'required|unique:coverages,name,' . $this->id . ',id,parent_id,' . $this->parent;
        }

        return   $rules;
    }
}

<?php

namespace App\Http\Requests\ToDo;

use Illuminate\Foundation\Http\FormRequest;

class ToDoStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd($this->all());
        $rules = [
            'title'         => 'required|string|max:255',
            'description'   => 'required|string|max:1000',
            'user_id'       => 'required|exists:users,id',
            'date'          => 'required',
        ];

        if ($this->isMethod('put')) {
            $rules['id']    = ['required', 'exists:to_dos,id'];
        }

        return $rules;
    }

    public function response(array $errors)
    {
        if ($this->wantsJson()) {
            return response()->json(['errors' => $errors], 422);
        }

        return parent::response($errors);
    }
}

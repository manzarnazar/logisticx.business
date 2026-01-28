<?php

namespace Modules\Blog\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        return [
            'author'      => ['required'],
            'title'       =>  'required|string|min:4|max:255|unique:blogs,title',
            'date'        => ['required'],
            'position'    => ['nullable', 'numeric', 'min:0'],
            'banner'      => 'nullable|image|mimes:jpeg,png,jpg|max:5098',
            'status'      => 'boolean',
            'description' => 'nullable|string',

        ];
    }
}

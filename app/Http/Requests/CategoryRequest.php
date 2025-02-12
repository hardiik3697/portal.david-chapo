<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        /** Assuming the user ID is in the request body */
        $id = $this->input('id');

        if ($this->method() == 'PATCH') {
            return [
                'name' => 'required|max:30|regex:/^[A-Za-z]/|unique:categories,name,'.$id,
                'description' => 'required|string'
            ];
        } else {
            return [
                'name' => 'required|max:30|regex:/^[A-Za-z]/|unique:categories,name,',
                'description' => 'required|string'
            ];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter name',
            'name.max' => 'name max limit id 30',
            'name.regex' => 'Please enter valid name',
            'name.exists' => 'name not found',
            'description.required' => 'Please enter description',
            'description.string' => 'Please enter valid description'
        ];
    }
}

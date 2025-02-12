<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
                'name' => 'required|string|max:30|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|email:rfc,dns|unique:customers,email,'.$id,
                'phone' => 'required|numeric|digits:10|unique:customers,phone,'.$id
            ];
        } else {
            return [
                'name' => 'required|string|max:30|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|email:rfc,dns|unique:customers,email',
                'phone' => 'required|numeric|digits:10|unique:customers,phone'
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
            'name.string' => 'Entered name must be alphabet',
            'name.max' => 'Name lenght must be smaller than 256 character',
            'name.regex' => 'Please enter proper name',
            'email.required' => 'Please enter email address',
            'email.email' => 'Please enter proper email address',
            'email.unique' => 'Email address must be unique',
            'phone.required' => 'Please enter phone no',
            'phone.numeric' => 'Please enter proper phone no ',
            'phone.digits' => 'Phone no must be 10 digits',
            'phone.unique' => 'Phone no must be unique'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StripeRequest extends FormRequest
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
                'email' => 'required|email:rfc,dns|unique:stripes,email,'.$id,
                'publishable_key' => 'required',
                'secret_key' => 'required'
            ];
        } else {
            return [
                'email' => 'required|email:rfc,dns|unique:stripes,email,',
                'publishable_key' => 'required',
                'secret_key' => 'required'
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
            'email.required' => 'Please enter email address',
            'email.email' => 'Please enter proper email address',
            'email.unique' => 'Email address must be unique',
            'publishable_key.required' => 'Please enter publishable key',
            'secret_key.numeric' => 'Please enter secret key'
        ];
    }
}

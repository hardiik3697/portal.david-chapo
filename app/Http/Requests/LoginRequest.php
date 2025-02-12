<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'username' => 'required|string|max:30|regex:/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/|exists:users,username',
            'password' => 'required|regex:/^[A-Za-z0-9]/',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Please enter username',
            'username.max' => 'Username max limit id 30',
            'username.regex' => 'Please enter valid username',
            'username.exists' => 'Username not found',
            'password.required' => 'Please enter password',
            'password.regex' => 'Please enter valid password'
        ];
    }
}

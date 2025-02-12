<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                'username' => 'required|max:30|regex:/^[A-Za-z0-9]/|unique:users,username,'.$id,
                'email' => 'required|email:rfc,dns|unique:users,email,'.$id,
                'phone' => 'required|numeric|digits:10|unique:users,phone,'.$id,
                'password' => 'nullable|max:30|regex:/^[A-Za-z0-9]/',
                'confirm_password' => 'nullable|max:30|regex:/^[A-Za-z0-9]/|required_with:password|same:password'
            ];
        } else {
            return [
                'name' => 'required|string|max:30|regex:/^[a-zA-Z\s]+$/',
                'username' => 'required|max:30|regex:/^[A-Za-z0-9]/|unique:users,username',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'phone' => 'required|numeric|digits:10|unique:users,phone',
                'password' => 'required|max:30|regex:/^[A-Za-z0-9]/',
                'confirm_password' => 'required|max:30|regex:/^[A-Za-z0-9]/|same:password'
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
            'username.required' => 'Please enter username',
            'username.max' => 'Username max limit is 30 character',
            'username.regex' => 'Please enter proper username',
            'username.unique' => 'Username not available',
            'email.required' => 'Please enter email address',
            'email.email' => 'Please enter proper email address',
            'email.unique' => 'Email address must be unique',
            'phone.required' => 'Please enter phone no',
            'phone.numeric' => 'Please enter proper phone no ',
            'phone.digits' => 'Phone no must be 10 digits',
            'phone.unique' => 'Phone no must be unique',
            'password.required' => 'Please enter password',
            'password.max' => 'Password max limit is 30 character',
            'password.regex' => 'Please enter valid password',
            'confirm_password.required' => 'Please enter password',
            'confirm_password.max' => 'Confirm password max limit is 30 character',
            'confirm_password.regex' => 'Please enter valid password',
            'confirm_password.same' => 'Password must be same as confirm password'
        ];
    }
}

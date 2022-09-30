<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'            => ['required', 'string', 'min:2', 'max:100'],
            'last_name'             => ['required', 'string', 'min:2', 'max:100'],
            'username'              => ['required', 'string', 'max:100', 'unique:users'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users'],
            'password'              => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:255', 'same:password'],
            'grecaptcha'            => ['required'],
            'terms'                 => ['required'],
        ];
    }

//    public function attributes()
//    {
//        return [
//            'username' => 'email address',
//            'name' => 'email address',
//            'email' => 'email address',
//            'password' => 'email address',
//            'password_confirmation' => 'email address',
//        ];
//    }

    public function messages()
    {
        return [
            'first_name.required'            => 'First name is required',
            'last_name.required'             => 'Last name is required',
            'username.required'              => 'A username is required',
            'email.required'                 => 'An e-mail is required',
            'password.required'              => 'A password is required',
            'password_confirmation.required' => 'Confirm the password',
            'grecaptcha.required'            => 'Check reCaptcha',
            'terms.required'                 => 'Accept our terms of privacy and confidentiality',
        ];
    }

}

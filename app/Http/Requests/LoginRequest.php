<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username'   => 'required | string | max:255',
            'password'   => 'required | string | min:8 | max:255',
            'remember'   => 'nullable',
            'grecaptcha' => 'required'
        ];
    }

//    public function attributes()
//    {
//        return [
//            'email' => 'email address',
//        ];
//    }

    public function messages()
    {
        return [
            'username.required'   => 'A username or e-mail is required',
            'password.required'   => 'A password is required',
            'grecaptcha.required' => 'Check reCaptcha'
        ];
    }

}

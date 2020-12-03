<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
           'email'      => 'required|email',
           'password'   => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'email.required'      => 'Email must not be empty',
            'email.email'         => 'Must be a valid email',
            'password.required'   => 'Password must not be empty',        
            
        ];
    }
}

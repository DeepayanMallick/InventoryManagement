<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'      => 'required|max:150',
            'company'   => 'nullable|max:200',
            'phone'     => 'required|max:50|unique:suppliers,phone',
            'email'     => 'required|max:50|email|unique:suppliers,email',
            'address'   => 'nullable|max:200',
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'Name must not be empty',
            'name.max'       => 'Name is too long (maximum is 150 characters)',
            'phone.required' => 'Phone number must not be empty',            
            'phone.max'      => 'Phone number is too long (maximum is 50 characters)',
            'phone.unique'   => 'Phone number must be unique',
            'email.required' => 'Email must not be empty',
            'email.email'    => 'Must be a valid email',
            'email.unique'   => 'Email must be unique',
            'email.max'      => 'Email is too long (maximum is 50 characters)',
            'address.max'    => 'Address is too long (maximum is 200 characters)',
            'company.max'    => 'Company is too long (maximum is 200 characters)',
        ];
    }
}

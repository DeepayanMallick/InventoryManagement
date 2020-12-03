<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'      => 'required|max:150',
            'phone'     => 'required|max:50|unique:customers,phone,' . $this->customer->id,
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
            'address.max'    => 'Address is too long (maximum is 200 characters)',
        ];
    }
}

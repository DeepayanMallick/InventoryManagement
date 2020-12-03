<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'customer_id'     => 'required',
            'product_id.*'    => 'required',
            'amount.*'        => 'required',
            'unit.*'          => 'required|integer',
            'partial_amount'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'partial_amount.required'   => 'Payment amount must not be empty',         
            'customer_id.required'      => 'Customer must not be empty',           
            'product_id.*.required'     => 'Product must not be empty',           
            'amount.*.required'         => 'Amount must not be empty',
            'unit.*.required'           => 'Unit must not be empty',
            'unit.*.integer'            => 'Unit must be a countable number',
        ];
    }
}

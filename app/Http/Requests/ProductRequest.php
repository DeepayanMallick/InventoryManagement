<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title'            => 'required|max:150',
            'description'      => 'required|max:255',
            'supplier_id'      => 'required',
            'code'             => 'required|max:10',
            'retail_price'     => 'required|numeric',
            'sales_price'      => 'required|numeric',
            'stock'            => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'title.required'        => 'Title must not be empty',
            'title.max'             => 'Title is too long (maximum is 150 characters)',
            'description.required'  => 'Description must not be empty',
            'description.max'       => 'Description is too long (maximum is 255 characters)',
            'supplier_id.required'  => 'Supplier must be selected',
            'code.required'         => 'Code must not be empty',
            'code.max'              => 'Code is too long (maximum is 10 characters)',
            'retail_price.required' => 'Retail Price must not be empty',
            'retail_price.numeric'  => 'Retail Price must be a number',
            'sales_price.required'  => 'Sales Price must not be empty',
            'sales_price.numeric'   => 'Sales Price must be a number',
            'stock.required'        => 'Stock must not be empty',
            'stock.integer'         => 'Stock must be an integer',
        ];
    }
}

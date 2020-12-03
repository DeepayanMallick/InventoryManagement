<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtraProfitRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'amount'         => 'required|numeric',            
            'note'           => 'nullable|string|max:150',
        ];
    }

    public function messages()
    {
        return [
            'amount.required'  => 'Amount must not be empty',
            'amount.numeric'   => 'Amount must be a number',       
            'note.max'         => 'Note is too long (maximum is 150 characters)',
        ];
    }
}

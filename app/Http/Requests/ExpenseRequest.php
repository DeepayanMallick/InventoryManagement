<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'amount'         => 'required|numeric',
            'type'           => 'required|string|max:150',
            'note'           => 'nullable|string|max:150',
        ];
    }

    public function messages()
    {
        return [
            'amount.required'  => 'Amount must not be empty',
            'amount.numeric'   => 'Amount must be a number',         
            'type.required'    => 'Expense type must be selected',           
            'type.max'         => 'Expense type is too long (maximum is 150 characters)',
            'note.max'         => 'Note is too long (maximum is 150 characters)',
        ];
    }
}

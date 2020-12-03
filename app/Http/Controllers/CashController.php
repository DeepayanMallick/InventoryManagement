<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use Illuminate\Http\Request;

class CashController extends Controller
{
    public function index()
    {
        return view('backend.cash.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'income'    => 'required|numeric',
        ],
        [
            'income.required'    => 'Amount must not be empty',
            'income.numeric'     => 'Amount must be a number',
        ]);

        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'income' => $cash->income + $request->income
            ]);
        } else {
            Cash::create([
                'income' => $request->income
            ]);
        }

        return redirect()->back()->with('success', 'Cash Added Successfully!');
    }
}

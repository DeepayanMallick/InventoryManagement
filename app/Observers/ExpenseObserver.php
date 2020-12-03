<?php

namespace App\Observers;

use App\Models\Cash;
use App\Models\Expense;


class ExpenseObserver
{

    public function created(Expense $expense)
    {
        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'expense' => ($cash->expense + $expense->amount)
            ]);
        } else {
            Cash::create([
                'expense' => $expense->amount
            ]);
        }
    }


    public function updated(Expense $expense)
    {
        $original_value = $expense->getOriginal()['amount'];       
        
        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'expense' => ($cash->expense - floatval($original_value)) + $expense->amount
            ]);
        } else {
            Cash::create([
                'expense' => $expense->amount
            ]);
        }
    }


    public function deleted(Expense $expense)
    {
        $original_value = $expense->getOriginal()['amount'];       
        
        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'expense' => $cash->expense - floatval($original_value)
            ]);
        }
    }


    public function restored(Expense $expense)
    {
        //
    }

    public function forceDeleted(Expense $expense)
    {
        //
    }
}

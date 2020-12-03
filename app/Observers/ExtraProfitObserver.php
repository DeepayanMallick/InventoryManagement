<?php

namespace App\Observers;

use App\Models\Cash;
use App\Models\ExtraProfit;

class ExtraProfitObserver
{

    public function created(ExtraProfit $extraProfit)
    {
        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'income' => $cash->income + $extraProfit->amount
            ]);
        } else {
            Cash::create([
                'income' => $extraProfit->amount
            ]);
        }
    }


    public function updated(ExtraProfit $extraProfit)
    {
        $original_value = $extraProfit->getOriginal()['amount'];       
        
        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'income' => ($cash->income - floatval($original_value)) + $extraProfit->amount
            ]);
        } else {
            Cash::create([
                'income' => $extraProfit->amount
            ]);
        }
    }


    public function deleted(ExtraProfit $extraProfit)
    {
        $original_value = $extraProfit->getOriginal()['amount'];       
        
        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'income' => $cash->income - floatval($original_value)
            ]);
        }
    }


    public function restored(ExtraProfit $extraProfit)
    {
        //
    }


    public function forceDeleted(ExtraProfit $extraProfit)
    {
        //
    }
}

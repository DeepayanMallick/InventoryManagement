<?php

namespace App\Observers;

use App\Models\Cash;
use App\Models\Customer;
use App\Models\Order;

class OrderObserver
{

    public function created(Order $order)
    {
        $customer = Customer::find($order->customer_id);

        $customer_due = $customer->due + $order->due;

        $customer->update(['due' => $customer_due]);

        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'income' => $cash->income + ($order->total - $order->due)
            ]);
        } else {
            Cash::create([
                'income' => $order->total - $order->due
            ]);
        }
    }


    public function updated(Order $order)
    {
        //
    }


    public function deleted(Order $order)
    {
        $original_value_total = $order->getOriginal()['total'];       
        $original_value_due = $order->getOriginal()['due'];       
        
        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'income' => $cash->income - (floatval($original_value_total) - $original_value_due)
            ]);
        }
    }


    public function restored(Order $order)
    {
        //
    }


    public function forceDeleted(Order $order)
    {
        //
    }
}

<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{

    function generateOrderId()
    {
        $order_id = mt_rand(10000, 99999);

        if ($this->orderIdExists($order_id)) {
            return $this->generateOrderId();
        }

        return $order_id;
    }

    function orderIdExists($order_id)
    {
        return Order::where('order_id', $order_id)->exists();
    }
}

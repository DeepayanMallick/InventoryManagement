<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalDue = Customer::get()->sum('due');    
        
        $data['totalDue'] = number_format($totalDue);

        $orders = Order::orderBy('id', 'desc')->take(10)->get();

        $data['orders'] = $orders;

        $todaysExpense = Expense::whereDate('created_at', today())->get()->sum('amount');

        $data['todaysExpense'] = number_format($todaysExpense);

        $cash = Cash::get()->first();

        $totalExpense = !empty($cash) ? $cash->expense : null;

        $totalIncome = !empty($cash) ? $cash->income : null;

        $data['casInHand'] = number_format($totalIncome - $totalExpense);

        $stockPrice = Product::get()->sum('total_price');

        $data['stockPrice'] = number_format($stockPrice);

        $thisMonthSells = Order::whereMonth('created_at', date('m'))->sum('total');

        $data['thisMonthSells'] = number_format($thisMonthSells);

        $todaysSells = Order::whereDate('created_at', today())->sum('total');

        $data['todaysSells'] = number_format($todaysSells);

        $todaysOrder = Order::whereDate('created_at', today())->count();

        $data['todaysOrder'] = number_format($todaysOrder);

        $thisMonthOrder = Order::whereMonth('created_at', date('m'))->count();

        $data['thisMonthOrder'] = number_format($thisMonthOrder);

        $products = Product::orderBy('stock', 'asc')->take(10)->get();

        $data['products'] = $products;

        return view('backend.dashboard', $data);
    }
}

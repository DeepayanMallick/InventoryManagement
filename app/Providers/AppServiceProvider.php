<?php

namespace App\Providers;

use App\Models\Expense;
use App\Models\ExtraProfit;
use App\Models\Order;
use App\Observers\ExpenseObserver;
use App\Observers\ExtraProfitObserver;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        Paginator::useBootstrap();
        Order::observe(OrderObserver::class);              
        Expense::observe(ExpenseObserver::class);              
        ExtraProfit::observe(ExtraProfitObserver::class);              
    }
}

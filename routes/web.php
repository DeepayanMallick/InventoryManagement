<?php

use App\Http\Controllers\CashController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExtraProfitController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('customers/search', [CustomerController::class, 'search'])->name('customers.search');
Route::get('customers/details', [CustomerController::class, 'customerDetails'])->name('customer.details');
Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('products/price', [ProductController::class, 'price'])->name('products.price');
Route::get('orders/add-more', [OrderController::class, 'addMore'])->name('orders.add-more');
Route::get('orders/calculate-price', [OrderController::class, 'calculatePrice'])->name('orders.calculate-price');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    /******* Profile *********/
    Route::get('/profile/{user}', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/{user}', [ProfileController::class, 'changePassword'])->name('profile.change.password');

    /******* Manager *********/

    Route::group(['middleware' => 'manager'], function () {

        Route::get('extra-profit', [ExtraProfitController::class, 'index'])->name('extra-profit.index');
        Route::post('extra-profit', [ExtraProfitController::class, 'store'])->name('extra-profit.store');
        Route::get('expenses', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::post('expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
        Route::get('stocks/{id}/edit', [StockController::class, 'edit'])->name('stocks.edit');
        Route::PUT('stocks/{id}', [StockController::class, 'update'])->name('stocks.update');
        Route::post('orders/pay/{order}', [OrderController::class, 'pay'])->name('orders.pay');
        Route::post('orders/pay-to-customer/{order}', [OrderController::class, 'payToCustomer'])->name('orders.pay-to-customer');
        Route::get('orders/return', [OrderController::class, 'return'])->name('orders.return');
        Route::post('orders/return/{order}', [OrderController::class, 'returnProduct'])->name('orders.return-product');
        Route::get('orders/return/search-invoice', [OrderController::class, 'searchInvoice'])->name('orders.search-invoice');
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/print/{order}', [OrderController::class, 'print'])->name('orders.print');
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::post('suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('customers/due', [CustomerController::class, 'customerDue'])->name('customers.due');
        Route::get('customers/invoice/{id}', [CustomerController::class, 'customerInvoice'])->name('customers.invoice');
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');        
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'store'])->name('settings.store');
        Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/sales/csv', [ReportController::class, 'salesCsv'])->name('reports.sales.csv');
        Route::get('reports/sales/pdf', [ReportController::class, 'salesPdf'])->name('reports.sales.pdf');
        Route::get('reports/cash', [ReportController::class, 'cash'])->name('reports.cash');
        Route::get('reports/expenses/csv', [ReportController::class, 'expensesCsv'])->name('reports.expenses.csv');
        Route::get('reports/expenses/pdf', [ReportController::class, 'expensesPdf'])->name('reports.expenses.pdf');
    });


    /******* Admin *********/

    Route::group(['middleware' => 'admin'], function () {       
        Route::get('cashes', [CashController::class, 'index'])->name('cashes.index');
        Route::post('cashes', [CashController::class, 'store'])->name('cashes.store'); 
        Route::resource('stocks', StockController::class)->except(['index', 'edit', 'update']);
        Route::resource('orders', OrderController::class)->except(['index', 'show', 'store']);
        Route::resource('expenses', ExpenseController::class)->except(['index', 'show', 'store']);
        Route::resource('extra-profit', ExtraProfitController::class)->except(['index', 'show', 'store']);
        Route::resource('products', ProductController::class)->except(['index', 'show', 'store']);
        Route::resource('suppliers', SupplierController::class)->except(['index', 'show', 'store']);
        Route::resource('customers', CustomerController::class)->except(['index', 'show', 'store']);
    });
});

@extends('backend.layouts.master')
@section('title', 'Home')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Dashboard</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Dashboard</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row Dashboard">
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <span class="label label-info float-right">Today</span>
                    <h3>Today's Orders</h3>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $todaysOrder }}</h1>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <span class="label label-success float-right">Today</span>
                    <h3>Today's Sales (tk)</h3>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$todaysSells}}</h1>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <span class="label label-primary float-right">This Month</span>
                    <h3>Monthly Sales (tk)</h3>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$thisMonthSells}}</h1>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <span class="label label-danger float-right">This Month</span>
                    <h3>Monthly Orders</h3>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$thisMonthOrder}}</h1>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <a href="{{ route('customers.due') }}"><span class="label label-info float-right">Details</span></a>
                    <h3>Total Due (tk)</h3>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $totalDue }}</h1>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h3>Cash In Hand (tk)</h3>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $casInHand }}</h1>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <a href="{{ route('stocks.index') }}"><span class="label label-info float-right">Details</span></a>
                    <h3>Stock Price (tk)</h3>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $stockPrice }}</h1>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <a href="{{ route('expenses.index') }}"><span class="label label-success float-right">Today</span></a>
                    <h3>Today's Expense (tk)</h3>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $todaysExpense }}</h1>
                    <small></small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>Quick Access</h3>
                </div>
                <div class="ibox-content text-center">
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{ route('orders.index') }}" class="btn btn-danger NewOrderButton"><i
                                    class="fa fa-plus"></i> New Order</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('customers.index') }}" class="btn btn-info NewOrderButton"><i
                                    class="fa fa-plus"></i> New Customer</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('suppliers.index') }}" class="btn btn-primary NewOrderButton"><i
                                    class="fa fa-plus"></i> New Supplier</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('products.index') }}" class="btn btn-success NewOrderButton"><i
                                    class="fa fa-plus"></i> New Product</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('expenses.index') }}" class="btn btn-dark NewOrderButton"><i
                                    class="fa fa-plus"></i> New Expense</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('orders.return') }}" class="btn btn-warning NewOrderButton"><i
                                    class="fa fa-plus"></i> Return Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary float-right">All Orders</a>
                    <h3>Last Orders</h3>
                </div>
                <div class="ibox-content table-responsive">
                    @if(count($orders))
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Amount (tk)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="gradeX">
                                <td>{{ $order->order_id }}</td>
                                <td><i class="fa fa-clock-o"></i> {{ $order->created_at }}</td>
                                <td>{{ number_format($order->total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center">
                        <h4>No order available</h4>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <a href="{{ route('stocks.index') }}" class="btn btn-primary float-right">Check Stocks</a>
                    <h3>Low Stocks</h3>
                </div>
                <div class="ibox-content table-responsive">
                    @if(count($products))
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Product(s)</th>
                                <th>Initial Stock</th>
                                <th>Available Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="gradeX">
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->available_stock }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center">
                        <h4>No stock available</h4>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

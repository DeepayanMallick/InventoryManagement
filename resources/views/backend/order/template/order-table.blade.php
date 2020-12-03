@extends('backend.layouts.master')
@section('title', 'Order')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Order</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('orders.index') }}">Order</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Order Details</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins" style="margin-bottom: 0;">
        <div class="ibox-title">
            <h3>Order Details</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>From:</h4>
                        <address>
                            <strong>Decor House</strong><br>
                            152/1 Rustom Tower<br>
                            Songita Hall More<br>
                            Khulna-9100<br>
                            <span><strong>Phone:</strong> 01634 050506
                        </address>
                    </div>
                    <div class="col-sm-6 text-right">
                        <h4>Order ID: <span>{{ $order->order_id }}</span></h4>
                        <h4>To:</h4>
                        <address>
                            <strong>{{ $order->customer->name ?? '' }}</strong><br>
                            {{ $order->customer->address ?? '' }}<br>
                            <span><strong>Phone:</strong> {{ $order->customer->phone ?? '' }}
                        </address>
                        <p>
                            <span><strong>Date:</strong> {{ $order->created_at }}</span>
                        </p>
                    </div>
                </div>

                <div class="table-responsive m-t">
                    <table class="table invoice-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Unit Price (tk)</th>
                                <th>Amount (tk)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($order->order_products))
                            @foreach ($order->order_products as $order_product)
                            <tr>
                                <td>
                                    <div>{{ $order_product->product->title  }}</div>
                                </td>
                                <td>{{ $order_product->unit }}</td>
                                <td>{{ number_format($order_product->unit_price) }}</td>
                                <td>{{ number_format($order_product->amount) }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">
                    <tbody>
                        <tr>
                            <td><strong>Sub Total (tk):</strong></td>
                            <td>{{ number_format($order->sub_total) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tax ({{$tax}}%):</strong></td>
                            <td>{{ number_format($order->tax) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Discount (tk):</strong></td>
                            <td>{{ $order->discount }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total (tk):</strong></td>
                            <td>{{ number_format($order->total) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Paid Amount (tk):</strong></td>
                            <td>{{ number_format($order->partial_amount) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Due (tk):</strong></td>
                            <td>{{ number_format($order->due) }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-2">
                    <a href="{{ route('orders.print', $order->id) }}" target="_blank" class="btn btn-primary"><i
                            class="fa fa-print"></i> Print Order
                    </a>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="ibox-title">
                <h3>Payment History</h3>
            </div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Date</th>
                            <th>Paid Amount (tk)</th>
                            <th>Refund Amount (tk)</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($payments as $key=>$payment)                        
                        <tr class="gradeX">
                            <td class="text-center">{!! ($key+1)+(20*($payments->currentPage()-1)) !!}</td>
                            <td> {{ $payment->date }}</td>
                            <td>{{ number_format($payment->partial_amount) }}</td>
                            <td>{{ number_format($payment->refund_amount) }}</td>                     
                        </tr>                       
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th class="text-right">Total &nbsp; &nbsp; &nbsp;</th>
                            <td>{{ number_format($totalPaid) }}</td>                       
                            <td>{{ number_format($totalReturned) }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="dataTables_paginate paging_simple_numbers">
                    {{$payments->links()}}
                </div>
            </div>  
  
            @if($order->due > 0)
            <div class="ibox-title">
                @if(\Session::has('success'))
                <div class="alert alert-success">
                    <ul class="list-style-none">
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
                @endif
                <h3>Payment</h3>
            </div>
            
            <div class="ibox-content">                
                <form action="{{ route('orders.pay', $order->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group form-inline mt-1">
                                <label for="name" class="mr-4">Date</label>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control datepicker" name="date"
                                    value="{{ date('d-m-Y') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group form-inline @error('partial_amount') has-error @enderror">
                                <label for="name" class="mr-4">Amount</label>
                                <input type="text" class="form-control" name="partial_amount" value="" placeholder="">
                                @error('partial_amount')
                                <div class="inline-errors">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary" onclick="formSubmit(this)">Pay Now</button>
                        </div>
                    </div>
                </form>
            </div>
            @endif

            @if($order->due < 0)  
            <div class="ibox-title">
                @if(\Session::has('success'))
                <div class="alert alert-success">
                    <ul class="list-style-none">
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
                @endif
                <h3>Pay To Customer</h3>
            </div> 
                
            <div class="ibox-content">                
                <form action="{{ route('orders.pay-to-customer', $order->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group form-inline mt-1">
                                <label for="name" class="mr-4">Date</label>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control datepicker" name="pay_date"
                                    value="{{ date('d-m-Y') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group form-inline @error('refund_amount') has-error @enderror">
                                <label for="name" class="mr-4">Refund Amount</label>
                                <input type="text" class="form-control" name="refund_amount" value="" placeholder="">
                                @error('refund_amount')
                                <div class="inline-errors">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary" onclick="formSubmit(this)">Pay Now</button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('backend.layouts.master')
@section('title', 'Return Product')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Return Product</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Return Product</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins manager-order" style="margin-bottom: 0;">
                <div class="ibox-title">
                    <h3>Search Invoice</h3>
                </div>
            </div>
            <div class="ibox-content">
                @if(empty($order))
                @if(\Session::has('success'))
                <div class="alert alert-success">
                    <ul class="list-style-none">
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
                @endif
                @endif
                <form id="ReturnOrderForm" action="{{ route('orders.return') }}" method="GET" autocomplete="off">
                    <div class="row Filter">
                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <input type="text" style="height: 38px;" id="SearchField" onkeyup="searchOrder(this)"
                                    class="form-control"
                                    placeholder="Search by Order ID, Customer Name Or Customer Phone....">
                                <input type="hidden" id="OrderId" name="order_id">
                                <div class="ajax_loading OrderSearch">
                                    <img src="{{asset('img/ajax-loader.svg')}}" alt="">
                                </div>
                                <div id="order-suggestion-box"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-8">
            @if(!empty($order))
            <div class="ibox-title">
                <h3>Invoice Details</h3>
            </div>
            <div class="ibox-content p-xl">
                @if(\Session::has('success'))
                <div class="alert alert-success">
                    <ul class="list-style-none">
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
                @endif
                <form action="{{ route('orders.return-product', $order->id) }}" method="POST">
                    @csrf
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
                                    <th>Return Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($order->order_products))
                                @foreach ($order->order_products as $key => $order_product)
                                <tr>
                                    <td>
                                        <div>{{ $order_product->product->title  }}</div>
                                    </td>
                                    <td>{{ $order_product->unit }}</td>
                                    <td id="unit-price-{{$key}}">{{ number_format($order_product->unit_price) }}</td>
                                    <td id="amount-{{$key}}">{{ number_format($order_product->amount) }}</td>
                                    <td class="ReturnUnitSelectBox">
                                        <select class="form-control" id="ReturnUnit{{$key}}"
                                            onchange="ReturnUnit(this, {{ $order_product->unit }}, {{ $order_product->unit_price }}, {{$key}}, {{count($order->order_products)}}, {{$tax}})">
                                            <option value="">Select Unit</option>
                                            @for ($i = 1; $i <= $order_product->unit; $i++)
                                                <option value="{{ $i }}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </td>
                                </tr>
                                <input type="hidden" id="UnitValue{{$key}}" name="unit[]"
                                    value="{{$order_product->unit}}">
                                <input type="hidden" name="unit_price[]" value="{{$order_product->unit_price}}">
                                <input type="hidden" id="AmountValue{{$key}}" name="amount[]"
                                    value="{{$order_product->amount}}">
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div><!-- /table-responsive -->
                    <table class="table invoice-total">
                        <tbody>
                            <tr>
                                <td><strong>Sub Total (tk):</strong></td>
                                <td id="subTotal" class="text-left">{{ number_format($order->sub_total) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tax ({{$tax}}%):</strong></td>
                                <td id="taxAmount" class="text-left">{{ number_format($order->tax) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Discount (tk):</strong></td>
                                <td id="discount" class="text-left">{{ $order->discount }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total (tk):</strong></td>
                                <td id="total" class="text-left">{{ number_format($order->total) }}</td>
                            </tr>
                            <input type="hidden" id="subTotalValue" name="sub_total" value="{{$order->sub_total}}">
                            <input type="hidden" id="taxAmountValue" name="tax" value="{{$order->tax}}">
                            <input type="hidden" id="totalValue" name="total" value="{{$order->total}}">
                            <input type="hidden" id="ReturnAmountValue" name="return_amount" value="">
                        </tbody>
                    </table>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" onclick="formSubmit(this)">Return Order</a>
                    </div>
                </form>
            </div>
            @endif
        </div>
        <div class="col-md-4">
            @if(!empty($order))
            <div class="ibox-title">
                <h3>Return Amount</h3>
            </div>
            <div class="ibox-content" id="ReturnAmount">
                <p><strong>Return Amount: </strong>0</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

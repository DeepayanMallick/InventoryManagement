@extends('backend.layouts.master')
@section('title', 'Customers Invoice')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Customers Invoice</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Customers Invoice</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins" style="margin-bottom: 0;">
        <div class="ibox-title">
            <h3>Customers Invoice</h3>
        </div>
        <div class="ibox-content">               
            <p><strong>Name:&nbsp;&nbsp;</strong>{{ $customer->name }}</p>
            <p><strong>Phone:&nbsp;&nbsp;</strong>{{ $customer->phone }}</p>
            <p><strong>Address:&nbsp;&nbsp;</strong>{{ $customer->address }}</p>                      
        </div>
    </div>
    <div class="row">        
        <div class="col-md-12">
            <div class="ibox-content">
                @if(count($orders))
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Order ID</th>
                            <th>Date</th>                            
                            <th>Total (tk)</th>
                            <th>Due (tk)</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($orders as $key=>$order)
                        <tr class="gradeX">
                            <td class="text-center">{!! ($key+1)+(20*($orders->currentPage()-1)) !!}</td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->created_at }}</td>                           
                            <td>{{ number_format($order->total) }}</td>
                            <td>{{ number_format($order->due) }}</td>
                            <td class="action-column tooltip-suggestion">
                                <a class="btn btn-primary btn-sm" href="{{ route('orders.show', $order->id) }}"
                                    data-toggle="tooltip" data-placement="top" title="View">Invoice</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-right">Total &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                            <th>{{ $totalDue }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                <div class="dataTables_paginate paging_simple_numbers">
                    {{$orders->links()}}
                </div>
                @else
                <div class="text-center">
                    <h4>No invoice available</h4>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@extends('backend.layouts.master')
@section('title', 'Sales Report')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Sales Report</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Sales Report</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title download-report">
                    <h3>Sales Reports</h3>
                    <div class="text-right">
                        <a href="{{ route('reports.sales.csv','from_date='. $from_date .'&to_date='. $to_date ) }}" class="btn btn-default" title="CSV"><i class="fa fa-file-excel-o"></i>CSV</a>
                        <a href="{{ route('reports.sales.pdf','from_date='. $from_date .'&to_date='. $to_date ) }}" target="_blank" class="btn btn-default" title="PDF"><i class="fa fa-file-pdf-o"></i>PDF</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox-content">
                            <form action="{{ route('reports.sales') }}" method="GET">
                                <div class="row Filter">
                                    <div class="col-md-3">
                                        <div class="input-group form-inline mt-1">
                                            <label for="name" class="mr-4">Date From</label>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control datepicker" name="from_date"
                                                value="{{ !empty($from_date) ? $from_date : date('d-m-Y')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group form-inline mt-1">
                                            <label for="name" class="mr-4">Date To</label>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control datepicker" name="to_date"
                                                value="{{ !empty($to_date) ? $to_date : date('d-m-Y')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('reports.sales') }}" class="btn btn-danger ml-4">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="ibox-content">
                            @if(count($orders))
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total (tk)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($orders as $key=>$order)
                                    <tr class="gradeX">
                                        <td class="text-center">{!! ($key+1)+(20*($orders->currentPage()-1)) !!}</td>
                                        <td>{{ $order->order_id }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ number_format($order->total) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th class="text-right">Total &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</th>
                                        <th>{{ $totalSales }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="dataTables_paginate paging_simple_numbers">
                                {{$orders->links()}}
                            </div>
                            @else
                            <div class="text-center">
                                <h4>No sale available</h4>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

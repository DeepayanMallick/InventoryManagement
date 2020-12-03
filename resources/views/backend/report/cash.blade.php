@extends('backend.layouts.master')
@section('title', 'Cash Report')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Cash Report</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Cash Report</strong>
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
                    <h3>Cash Reports</h3>
                 </div>
                <div class="ibox-content">
                    <form action="{{ route('reports.cash') }}" method="GET">
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
                                <a href="{{ route('reports.cash') }}" class="btn btn-danger ml-4">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-6">  
                        <div class="ibox-title download-report">
                            <h3>Sales</h3> 
                            <div class="text-right">
                                <a href="{{ route('reports.sales.csv','from_date='. $from_date .'&to_date='. $to_date ) }}" class="btn btn-default" title="CSV"><i class="fa fa-file-excel-o"></i>CSV</a>
                                <a href="{{ route('reports.sales.pdf','from_date='. $from_date .'&to_date='. $to_date ) }}" target="_blank" class="btn btn-default" title="PDF"><i class="fa fa-file-pdf-o"></i>PDF</a>
                            </div>                   
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
                                        <td class="text-center">{!! $key+1 !!}</td>
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
                            @else
                            <div class="text-center">
                                <h4>No sales available</h4>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ibox-title download-report">
                            <h3>Expenses</h3> 
                            <div class="text-right">
                                <a href="{{ route('reports.expenses.csv','from_date='. $from_date .'&to_date='. $to_date ) }}" class="btn btn-default" title="CSV"><i class="fa fa-file-excel-o"></i>CSV</a>
                                <a href="{{ route('reports.expenses.pdf','from_date='. $from_date .'&to_date='. $to_date ) }}" target="_blank" class="btn btn-default" title="PDF"><i class="fa fa-file-pdf-o"></i>PDF</a>
                            </div>                    
                        </div>
                        <div class="ibox-content">
                            @if(count($expenses))
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount (tk)</th>
                                        <th>Note</th>                                       
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($expenses as $key=>$order)
                                    <tr class="gradeX">
                                        <td class="text-center">{!! $key+1 !!}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->type }}</td>
                                        <td>{{ number_format($order->amount) }}</td>
                                        <td>{{ $order->note }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>                                        
                                        <th></th>
                                        <th></th>
                                        <th class="text-right">Total &nbsp; &nbsp; &nbsp;</th>
                                        <th>{{ $totalExpenses }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                            @else
                            <div class="text-center">
                                <h4>No expense available</h4>
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

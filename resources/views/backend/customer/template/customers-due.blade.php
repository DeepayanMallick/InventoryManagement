@extends('backend.layouts.master')
@section('title', 'Customers Due')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Customers Due</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Customers Due</strong>
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox-title">
                            <h3>Customers Due</h3>
                        </div>
                        <div class="ibox-content">
                            @if(count($customers))
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Due</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($customers as $key => $customer)
                                    <tr class="gradeX">
                                        <td class="text-center">{!! ($key+1)+(20*($customers->currentPage()-1)) !!}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->address }}</td>
                                        <td>{{ number_format($customer->due) }}</td>
                                        <td class="action-column tooltip-suggestion">
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('customers.invoice', $customer->id) }}"
                                                data-toggle="tooltip" data-placement="top" title="View"></i>Invoice(s)</a>
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
                                {{$customers->links()}}
                            </div>
                            @else
                            <div class="text-center">
                                <h4>No customer due available</h4>
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

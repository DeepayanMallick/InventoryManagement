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
            <li class="breadcrumb-item active">
                <strong>Return Details</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins" style="margin-bottom: 0;">
        <div class="ibox-title">
            <h3>Return Details</h3>            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-6">
                    </div>

                    <div class="col-sm-6 text-right">
                        <h4>Order ID: <span>83975</span></h4>
                        <p>
                            <span><strong>Date:</strong> 12-09-2020 01:25 PM</span>
                        </p>
                    </div>
                </div>

                <div class="table-responsive m-t">
                    <table class="table invoice-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Unit Price (tk)</th>
                                <th>Amount (tk)</th>
                            </tr>
                        </thead>
                        <tbody>                     
                            @for ($i = 1; $i < 6; $i++) 
                            <tr>
                                <td>
                                    <div>John Doe</div>
                                </td>
                                <td>
                                    <div>Hot Dog</div>
                                </td>
                                <td>5</td>
                                <td>{{number_format(250)}}</td>
                                <td>{{number_format(5550)}}</td>
                            </tr>
                            @endfor
                           
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->

                <table class="table invoice-total">                   
                    <tbody>
                        <tr>                            
                            <td><strong>Sub Total (tk):</strong></td>
                            <td>{{number_format(55500)}}</td>
                        </tr>
                        <tr>                            
                            <td><strong>Tax (10%):</strong></td>
                            <td>50</td>
                        </tr>
                        <tr>                            
                            <td><strong>Discount (tk):</strong></td>
                            <td>0</td>
                        </tr>
                        <tr>                            
                            <td><strong>Total (tk):</strong></td>
                            <td>{{number_format(55550)}}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="col-md-2">
                    <a href="#" target="_blank" class="btn btn-primary">Return Order</a>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection

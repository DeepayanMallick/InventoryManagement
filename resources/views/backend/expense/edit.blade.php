@extends('backend.layouts.master')
@section('title', 'Expense')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Expense</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('expenses.index') }}">Expense</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit</strong>
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
                    <div class="col-md-4">
                        <div class="ibox-title">
                            <h3>Edit Expense</h3>
                        </div>
                        <div class="ibox-content">
                            @if(\Session::has('success'))
                            <div class="alert alert-success">
                                <ul class="list-style-none">
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                            @endif
                            <form action="{{route('expenses.update', $expense->id)}}" method="POST">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="supplier">Select Type *</label>
                                            <div class="form-group @error('type') has-error @enderror">
                                                {!! Form::select('type', $types , Str::slug($expense->type),
                                                array('class' =>
                                                'form-control selectpicker','data-live-search' =>
                                                'true','placeholder'=>'Select Type')
                                                ); !!}
                                                @error('type')
                                                <div class="inline-errors">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group @error('date') has-error @enderror">
                                            <label for="date">Date</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control datepicker" name="date"
                                                    value="{{ date("d-m-Y", strtotime($expense->date)) }}">
                                                @error('date')
                                                <div class="inline-errors">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group @error('amount') has-error @enderror">
                                            <label for="name">Amount (tk) *</label>
                                            <input type="text" name="amount" value="{{ $expense->amount }}"
                                                class="form-control">
                                            @error('amount')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group @error('note') has-error @enderror">
                                            <label for="name">Note</label>
                                            <input type="text" name="note" value="{{ $expense->note }}"
                                                class="form-control">
                                            @error('note')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group mt-4">
                                            <input type="submit" class="btn btn-primary" onclick="formSubmit(this)" value="Update Expense">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="ibox-title">
                            <h3>Manage Expenses</h3>
                        </div>
                        <div class="ibox-content">
                            <form action="{{ route('expenses.edit', $expense->id) }}" method="GET">
                                <div class="row Filter">
                                    <div class="col-md-3">
                                        <div class="input-group form-inline mt-1">
                                            <label for="name" class="mr-4">From</label>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control datepicker" name="from_date"
                                                value="{{ !empty($from_date) ? $from_date : date('d-m-Y')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group form-inline mt-1">
                                            <label for="name" class="mr-4">To</label>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control datepicker" name="to_date"
                                                value="{{ !empty($to_date) ? $to_date : date('d-m-Y')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="group-group form-inline mt-1">
                                            {{-- <label class="mr-4" for="supplier">Select Type</label> --}}
                                            {!! Form::select('type', $types , $type,
                                            array('class' =>
                                            'form-control selectpicker','data-live-search' =>
                                            'true','placeholder'=>'Select Type')
                                            ); !!}
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group Product">
                                            <input type="text" class="form-control" name="q" value="{{ $filter}}"
                                                placeholder="Note Or Amount">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('expenses.edit', $expense->id) }}"
                                            class="btn btn-danger ml-4">Reset</a>
                                    </div>
                                </div>
                            </form>
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
                                        @if(Auth::user()->role=='Admin')
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($expenses as $key => $expense)
                                    <tr class="gradeX">
                                        <td class="text-center">{!! ($key+1)+(20*($expenses->currentPage()-1)) !!}</td>
                                        <td>{{ $expense->date }}</td>
                                        <td>{{ $expense->type }}</td>
                                        <td>{{ $expense->amount }}</td>
                                        <td>{{ $expense->note }}</td>
                                        @if(Auth::user()->role=='Admin')
                                        <td class="action-column tooltip-suggestion">
                                            <a class="btn btn-success btn-circle"
                                                href="{{ route('expenses.edit', $expense->id) }}" data-toggle="tooltip"
                                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>

                                            <form id="DeleteExpenseForm-{{$expense->id}}" method="POST"
                                                action="{{ route('expenses.destroy', $expense->id) }}"
                                                class="action-form">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <a href="javascript:void(0)" onclick="deleteExpense({{$expense->id}})"
                                                    class="btn btn-danger btn-circle" data-toggle="tooltip"
                                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                            </form>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="dataTables_paginate paging_simple_numbers">
                                {{$expenses->appends(request()->query())->links()}}
                            </div>
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

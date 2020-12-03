@extends('backend.layouts.master')
@section('title', 'Cash')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Cash</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Cash</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-title">
                    <h3>Add Cash</h3>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-4">
                                    @if(\Session::has('success'))
                                    <div class="alert alert-success">
                                        <ul class="list-style-none">
                                            <li>{!! \Session::get('success') !!}</li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <form action="{{ route('cashes.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group @error('income') has-error @enderror">
                                            <label for="name">Amount (tk)</label>
                                            <input type="text" name="income" class="form-control" value="{{old('income')}}">
                                            @error('income')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group mt-4">
                                            <input type="submit" class="btn btn-primary" onclick="formSubmit(this)" value="Add">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('backend.layouts.master')
@section('title', 'Add New Stock')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Add New Stock</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}">Product</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add New Stock</strong>
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
                    <h3>Add New Stock</h3>
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

                            <form action="{{ route('stocks.update', $product->id) }}" method="POST">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Product</label>
                                            <input type="text" class="form-control" value="{{$product->title}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Code</label>
                                            <input type="text" class="form-control" value="{{$product->code}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Stock</label>
                                            <input type="text" class="form-control" value="{{$product->stock}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Available Stock</label>
                                            <input type="text" class="form-control" value="{{$product->available_stock}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group @error('new_stock') has-error @enderror">
                                            <label for="name">New Stock</label>
                                            <input type="text" name="new_stock" class="form-control" value="">
                                            @error('new_stock')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group mt-4">
                                            <button class="btn btn-primary" onclick="formSubmit(this)">Add Stock</button>
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

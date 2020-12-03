@extends('backend.layouts.master')
@section('title', 'Product')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Product</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}">Product</a>
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
                            <h3>Edit Product</h3>
                        </div>
                        <div class="ibox-content">
                            @if(\Session::has('success'))
                            <div class="alert alert-success">
                                <ul class="list-style-none">
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                            @endif
                            <form action="{{ route('products.update', $product->id) }}" method="POST">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group @error('title') has-error @enderror">
                                            <label for="name">Title *</label>
                                            <input type="text" name="title" value="{{ $product->title }}"
                                                class="form-control">
                                            @error('title')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group @error('description') has-error @enderror">
                                            <label for="name">Description *</label>
                                            <input type="text" name="description" value="{{ $product->description }}"
                                                class="form-control">
                                            @error('description')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="supplier">Select Supplier *</label>
                                            <div class="form-group @error('supplier_id') has-error @enderror">
                                                {!! Form::select('supplier_id', $suppliers , $product->supplier_id,
                                                array('class' =>
                                                'form-control selectpicker','data-live-search' =>
                                                'true','placeholder'=>'Select Supplier')
                                                ); !!}
                                                @error('supplier_id')
                                                <div class="inline-errors">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group @error('code') has-error @enderror">
                                            <label for="name">Code *</label>
                                            <input type="text" name="code" value="{{ $product->code }}"
                                                class="form-control">
                                            @error('code')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group @error('retail_price') has-error @enderror">
                                            <label for="retail_price">Retail Price *</label>
                                            <input type="text" name="retail_price" value="{{ $product->retail_price }}"
                                                class="form-control">
                                            @error('retail_price')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group @error('sales_price') has-error @enderror">
                                            <label for="sales_price">Sales Price *</label>
                                            <input type="text" name="sales_price" value="{{ $product->sales_price }}"
                                                class="form-control">
                                            @error('sales_price')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @if($product->stock==$product->available_stock)
                                <div class="row">
                                    <div class="col-md-12 @error('stock') has-error @enderror">
                                        <div class="form-group">
                                            <label for="stock">Stock *</label>
                                            <input type="text" name="stock" value="{{ $product->stock }}"
                                                class="form-control">
                                            @error('stock')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-12 @error('stock') has-error @enderror">
                                        <div class="form-group">
                                            <label for="stock">Stock * <span style="color: #ed5565;">(You can't edit
                                                    stock because the product already ordered)</span></label>
                                            <input type="text" name="stock" value="{{ $product->stock }}"
                                                class="form-control" readonly>
                                            @error('stock')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group mt-4">
                                            <input type="submit" class="btn btn-primary" onclick="formSubmit(this)" value="Update Product">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="ibox-title">
                            <h3>Manage Products</h3>
                        </div>
                        <div class="ibox-content">
                            <form action="{{ route('products.edit', $product->id) }}" method="GET">
                                <div class="row Filter">
                                    <div class="col-md-8">
                                        <div class="form-group Product">
                                            <input type="text" class="form-control" name="q" value="{{ $filter}}"
                                                placeholder="Search by Product Title, Code, Or Description ....">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-danger ml-4">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="ibox-content">
                            @if(count($products))
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Product</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Supplier</th>
                                        <th>Retail Price (tk)</th>
                                        <th>Sales Price (tk)</th>
                                        <th>Stock</th>                                       
                                        <th>Action</th>                                        
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($products as $key => $product)
                                    <tr class="gradeX">
                                        <td class="text-center">{!! ($key+1)+(20*($products->currentPage()-1)) !!}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->supplier->name ?? '' }}</td>
                                        <td>{{ $product->retail_price }}</td>
                                        <td>{{ $product->sales_price }}</td>
                                        <td>{{ $product->available_stock }}/{{ $product->stock }}</td>
                                        <td class="action-column tooltip-suggestion">
                                            <a class="btn btn-success btn-circle" href="{{ route('stocks.edit', $product->id) }}"
                                                data-toggle="tooltip" data-placement="top" title="Add New Stock"><i
                                                    class="fa fa-plus"></i></a>
                                            @if(Auth::user()->role=='Admin')
                                            <a class="btn btn-success btn-circle" href="{{ route('products.edit', $product->id) }}"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            <form id="DeleteProductForm-{{$product->id}}" method="POST"
                                                action="{{ route('products.destroy', $product->id) }}" class="action-form">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <a href="javascript:void(0)" onclick="deleteProduct({{$product->id}})"
                                                    class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top"
                                                    title="Delete"><i class="fa fa-trash"></i></a>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="dataTables_paginate paging_simple_numbers">
                                {{$products->appends(request()->query())->links()}}
                            </div>
                            @else
                            <div class="text-center">
                                <h4>No product available</h4>
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

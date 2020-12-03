@extends('backend.layouts.master')
@section('title', 'Setting')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Setting</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Setting</strong>
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
                    <h3>Manage Settings</h3>
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
                            
                            <form action="{{ route('settings.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group @error('tax') has-error @enderror">
                                            <label for="name">Tax (percent)</label>
                                            <input type="text" name="tax" class="form-control" value="{{$tax}}">
                                            @error('tax')
                                            <div class="inline-errors">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group mt-4">
                                            <button class="btn btn-primary" onclick="formSubmit(this)">Update</button>
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

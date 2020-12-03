@extends('backend.layouts.master')
@section('title', 'Profile')
@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profile</h2>
        <ol class="breadcrumb">          
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Home</a>
            </li>           
            <li class="breadcrumb-item active">
                <strong>Profile</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="col-md-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Change Password</h5>
            </div>

            <div class="ibox-content">
                @if(\Session::has('success'))
                <div class="alert alert-success">
                    <ul class="list-style-none">
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
                @endif
                <form action="{{ route('profile.change.password', $user) }}" method="POST">
                    @csrf

                    <div class="form-group @error('new_password') has-error @enderror">
                        <label>New Password *</label>
                        <input id="password" name="new_password" type="password" class="form-control required">
                        @error('new_password')
                        <div class="inline-errors">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group @error('new_confirm_password') has-error @enderror">
                        <label>Confirm Password *</label>
                        <input id="confirm" name="new_confirm_password" type="password" class="form-control required">
                        @error('new_confirm_password')
                        <div class="inline-errors">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="submit" value="Update" class="btn btn-primary">
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

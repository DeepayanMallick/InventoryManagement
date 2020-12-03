@extends('auth.app')
@section('title', 'Login')
@section('content')

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>

        <div>
            <h2 class="login-title">Login</h2>
        </div>


        <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid has-error @enderror"
                    name="email" value="{{ old('email') }}" placeholder="Email Address" autocomplete="email" autofocus>
            </div>
            <div class="form-group">
                <input id="password" type="password" placeholder="Password"
                    class="form-control @error('password') is-invalid has-error @enderror" name="password"
                    autocomplete="current-password">
            </div>

            <div class="form-group">
                <div class="text-left"><label> <input type="checkbox"><i></i> Remember me </label></div>
            </div>


            <button type="submit" class="btn btn-primary block full-width m-b">LOGIN</button>
            <p>
                <a class="btn btn-sm btn-white btn-block" href="#">
                    <strong>Forget Password?<strong>
                </a>
            </p>
            @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'inline-errors') }}">{{ Session::get('message') }}</div>
            @endif
            @error('email') <div class="inline-errors" role="alert">{{ $message }}</div> @enderror
            @error('password') <div class="inline-errors" role="alert">{{ $message }}</div> @enderror
            
        </form>

    </div>
</div>

@endsection

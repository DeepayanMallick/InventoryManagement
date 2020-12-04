<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inventory Management | @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <script>
        const base_url = window.location.origin;
    </script>
</head>

<body>
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg dashbard-1">

            @include('backend.layouts.header')

            @yield('content')

            @include('backend.layouts.footer')
        </div>

    </div>
    <script src="{{asset('js/app.js')}}"></script>


</body>

</html>

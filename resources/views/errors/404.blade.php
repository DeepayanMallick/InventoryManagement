<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Decor House | 404 Error</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">


</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>404</h1>
        <h3 class="font-bold">Page Not Found</h3>

        <div class="error-desc">
            Sorry, but the page you are looking for has not been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.
            <br>
            <a href="{{route('dashboard')}}" class="btn btn-primary m-t">Dashboard</a>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{asset('js/app.js')}}"></script>

</body>

</html>
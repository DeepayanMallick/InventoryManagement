
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Decor House | 500 Error</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>500</h1>
        <h3 class="font-bold">Internal Server Error</h3>

        <div class="error-desc">
            The server encountered something unexpected that didn't allow it to complete the request. We apologize.<br/>
            You can go back to main page: <br/>
            <a href="{{route('dashboard')}}" class="btn btn-primary m-t">Dashboard</a>
        </div>
    </div>

    
    <script src="{{asset('backend/js/app.js')}}"></script> 
</body>

</html>

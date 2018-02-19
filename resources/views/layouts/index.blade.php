<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Makertasks</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Styles -->
        
            
    </head>
    <body>
        <div class="container">
        <ul class="nav nav-inline">
            <li class="nav-item">
                <a class="btn btn-lg btn-outline-secondary" href="http://makertask/" role="button">Task list</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-lg btn-outline-secondary" href="http://makertask/create">Create task</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-lg btn-outline-secondary" href="http://makertask/information">Information</a>
            </li>
        </ul>
    </div>
       <div class="flex-center position-ref full-height">
             @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif 
        @yield('content')
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TaskMaker</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">
</head>
<body>
    <div>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        TaskMaker
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" > 
                                    @if(Auth::user()->avatar != null)
                                    <div style="display: inline-block; float: left; border-radius: 50%; width: 25px; height: 25px; overflow: hidden; margin-right: 10px;"><img src="{{asset('/images/').'/'.Auth::user()->avatar}}" alt="placeholder+image" style="width: 100%; height: 100%;"></div>
                                    @else 
                                    <i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i>
                                    @endif
                                    <span style="margin-top: 10px;">{{ Auth::user()->name }} </span><span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" >
                                    <li>
                                        <a href="{{ route('cabinet') }}">
                                            Cabinet
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
                <ul class="nav navbar-nav navbar-left ">
                    <li class="nav-item">
                        <a class="btn btn-lg btn-secondary" href="http://makertask/" role="button"><i class="fa fa-list" aria-hidden="true"></i>  Task list</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-lg btn-secondary" href="http://makertask/create" role="button"><i class="fa fa-plus-square-o" aria-hidden="true"></i>  Create task</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-lg btn-secondary" href="http://makertask/information" role="button"><i class="fa fa-info" aria-hidden="true"></i>  Information</a>
                    </li>
                </ul>

            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
</body>
</html>

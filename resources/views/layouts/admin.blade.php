<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') SkyCems</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- endinject -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('/images/logo.png') }}">

</head>

<body>
    <div id="app">
        <!--wrapper start-->
        <div class="wrapper">
            <!--header menu start-->
            <div class="header">
                <div class="header-menu">
                    <div class="title">Sky <span>Cems</span></div>
                    <div class="sidebar-btn">
                        <i class="fas fa-bars"></i>
                    </div>
                    <ul>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <!--header menu end-->
            <!--sidebar start-->
            <div class="sidebar">
                <div class="sidebar-menu">
                    <center class="profile">
                        <!-- <img class="profile_image" src="/uploads/avatars/default.jpg" alt=""> -->
                        <div class="mt-5">
                        <p>{{ Auth::user()->firstname }}</p>
                        </div>
                        
                    </center>
                    <li class="item">
                        <a href="{{ route('admin.dashboard') }}" class="menu-btn">
                            <i class="fas fa-desktop">
                                <span>Dashboard</span>
                            </i>
                        </a>
                    </li>
                    <li class="item" id="profile">
                        <a href="{{ route('admin.view') }}" class="menu-btn">
                            <i class="fas fa-user-circle">
                                <span>View Facility</span>
                            </i>
                        </a>
                    </li>
                    <li class="item" id="messages">
                        <a href="{{route('admin.report')}}" class="menu-btn">
                            <i class="fas fa-envelope">
                                <span>Listing Report</span>
                            </i>
                        </a>
                    </li>
                    <li class="item" id="settings">
                        <a href="{{route('admin.audit')}}" class="menu-btn">
                            <i class="fas fa-cog">
                                <span>Audit Logs </span>
                            </i>
                        </a>
                    </li>
                </div>
            </div>
            <!--sidebar end-->
            <!--main container start-->
            <div class="main-container">

                <p>@yield('content')</p>

            </div>
            <!--main container end-->
        </div>
        <!--wrapper end-->

        <script type="text/javascript">
            $(document).ready(function () {
                $(".sidebar-btn").click(function () {
                    $(".wrapper").toggleClass("hide");
                });
            });
        </script>
    </div>
</body>

</html>

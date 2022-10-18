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
    <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('/images/logo.png') }}">

    @stack('hostcalendar')

</head>

<body>
    <div id="app">
        <!--wrapper start-->
        <div class="wrapper">
        @if (auth()->user()->status == 1)
            <!--header menu start-->
            <div class="header">
                <div class="header-menu">
                    <div class="title">Sky <span>Cems</span></div>
                    <div class="sidebar-btn">
                        <i class="fas fa-bars"></i>
                    </div>
                    <ul>
                        <div class="dropdown justify-content-align">
                            <span>
                                <li><a href="#"><i class="fas fa-bell">{{auth()->user()->unreadNotifications->count()}}</i></a></li>
                            </span>
                            <div class="dropdown-content">
                                <!-- Notification -->
                                @forelse (auth()->user()->unreadNotifications as $notification)
                                
                                    <h4>{{$notification->data['name']}}</h4>
                                    <p>Contact No.{{$notification->data['contact']}}</p>
                                    <p>Reason: {{$notification->data['reason']}}</p>
                                    <p>Status: {{$notification->data['status']}}</p>
                                    <p>Date: {{date('F d, Y', strtotime($notification->data['start_date']))}} -
                                        {{date('F d, Y', strtotime($notification->data['end_time']))}}</p>
                                    <p><a href="{{ route('markRead') }}">Mark As Read</a></p>
                                <hr>
                                @empty
                                <p>No notifications</p>
                                @endforelse
                            </div>
                        </div>
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
                        <img class="profile_image" src="/uploads/avatars/{{ $user->avatar }}" alt="">
                        <p>{{ Auth::user()->brgy }}</p>
                    </center>
                    <li class="item">
                        <a href="{{ route('host.index') }}" class="menu-btn">
                            <i class="fas fa-desktop">
                                <span>Dashboard</span>
                            </i>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('host_profile.index') }}" class="menu-btn">
                            <i class="fas fa-user-circle">
                                <span>Profile</span>
                            </i>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('status.index') }}" class="menu-btn">
                            <i class="fas fa-calendar-check">
                                <span>Manage Request Status</span>
                            </i>
                        </a>
                    </li>
                    <li class="item" id="settings">
                        <a href="#settings" class="menu-btn">

                            <i class="fas fa-cog"><span> Facility Management<i
                                        class="fas fa-chevron-down drop-down"></i></span></i>
                        </a>
                        <div class="sub-menu">
                            <a href="{{ route('facility.index') }}" class="menu-btn">
                                <i class="fas fa-tasks">
                                    <span>Manage Facility</span>
                                </i>
                            </a>
                            <a href="{{ route('calendar.index') }}" class="menu-btn">
                                <i class="fas fa-calendar-plus">
                                    <span>Book Facility</span>
                                </i>
                            </a>
                        </div>
                    </li>
                    <li class="item" id="settings">
                        <a href="{{ route('reservation.index') }}" class="menu-btn">
                            <i class="fas fa-book">
                                <span>Reservation Logs</span>
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
        @else
        <!--header menu start-->
        <div class="header">
            <div class="header-menu">
                <div class="title">Sky <span>Cems</span></div>
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
        <div class="ml-5 main-container">

            <div class="container">
                <div class=" text-center mt-5 ">
                    <h1>Account Status</h1>
                </div>
                <div class="row ">
                    <div class="col-lg-7 mx-auto">
                        <div class="card mt-2 mx-auto p-4 bg-light">
                            <div class="card-body bg-light">
                                <div class="container">
                                @if(auth()->user()->status == false)
                                    <div class="alert alert-danger" role="alert">
                                        Your account is not activated. Please wait for the Admin to activate your account and try again later.
                                    </div>
                                @endif
                                    <h4>{{auth()->user()->firstname}} {{auth()->user()->lastname}}</h4>
                                    <h4>{{auth()->user()->address}}</h4>
                                    <h4>{{auth()->user()->brgy}}</h4>
                                    <h4>{{auth()->user()->phone}}</h4>
                                </div>
                            </div>
                        </div> <!-- /.8 -->
                    </div> <!-- /.row-->
                </div>
            </div>
        </div>
        @endif
        <!--wrapper end-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
            integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
        </script>

        

        <script>var bookings = @json($events);</script>
        <script>
             $(document).ready(function () {

                    var down = false;

                    $('#bell').click(function (e) {
                    
                        var color = $(this).text();
                        if (down) {
                        
                            $('#box').css('height', '0px');
                            $('#box').css('opacity', '0');
                            down = false;
                        } else {
                        
                            $('#box').css('height', 'auto');
                            $('#box').css('opacity', '1');
                            down = true;
                        
                        }
                    });
                });
        </script>
        <script type="text/javascript" src="{{ asset('js/calendar.js') }}"></script>
        @stack('submit')
    </div>
</body>

</html>

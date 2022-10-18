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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    <link rel="icon" href="{{asset('/images/logo.png')}}">

    @stack('calendar')

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
                        <p>{{ Auth::user()->firstname }}</p>
                    </center>
                    <li class="item">
                        <a href="{{ route('organizer.index') }}" class="menu-btn">
                            <i class="fas fa-desktop">
                                <span>Dashboard</span>
                            </i>
                        </a>
                    </li>
                    <li class="item" id="profile">
                        <a href="{{ route('org_profile.index') }}" class="menu-btn">
                            <i class="fas fa-user-circle">
                                <span>Profile</span>
                            </i>
                        </a>
                    </li>
                    <li class="item" id="settings">
                        <a href="{{ route('manage.index') }}" class="menu-btn">
                            <i class="fas fa-tasks">
                                <span>Manage Reservation Status</span>
                            </i>
                        </a>
                    </li>
                    <li class="item" id="settings">
                        <a href="{{ route('event.index') }}" class="menu-btn">
                            <i class="fas fa-tasks">
                                <span>Manage Event</span>
                            </i>
                        </a>
                    </li>
                    <li class="item" id="settings">
                        <a href="{{ route('record.index') }}" class="menu-btn">
                            <i class="fas fa-history">
                                <span>Record Reservation</span>
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

        <!-- bootstrap js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
            integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
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

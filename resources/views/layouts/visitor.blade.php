<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') SkyCems</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{url('/images/logo.png')}}">

</head>

<body class="antialiased">
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="{{ route('visitor.index')}}"><div class="logotitle">Sky <span>Cems</span></div></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

            @if (Route::has('login'))
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                    <li class="nav-item"><a href="{{ route('visitor.index')}}" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="{{ route('manage_event.index')}}" class="nav-link">Joined Event</a></li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="/uploads/avatars/{{ $user->avatar }}" width="30" height="30"
                                class="rounded-circle">
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('visitor_profile.index')}}">Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                    <div class="dropdown justify-content-align">
                        <span>
                            <li class="nav-item"><a href="#" class="fas fa-bell nav-link"> {{auth()->user()->unreadNotifications->count()}}</a></li>
                        </span>
                        <div class="dropdown-content">
                            <h4>Notification</h4>
                            @forelse (auth()->user()->unreadNotifications as $notification)
                            <p><a href="{{ route('markRead') }}">Mark As Read</a></p>
                            <a>Name: {{$notification->data['name']}}</a>
                            <p>Event: {{$notification->data['reason']}} </p>
                            <a>Date: {{date('F d, Y h:i a', strtotime($notification->data['start_date']))}} - {{date('F d, Y h:i a', strtotime($notification->data['end_time']))}}</a>
                            <p>Status: {{ $notification->data['status'] }}</p>

                            <hr>
                            @empty

                            <p>No notifications</p>
                            
                            @endforelse
                        </div>
                    </div>
                    @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Log in</a></li>

                    @if (Route::has('register'))
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                    @endif
                    @endauth
                </ul>
            </div>
            @endif
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center my-5">
                        <h1 class="display-5 fw-bolder text-white mb-2">Cavite Community Event Management System</h1>
                        <p class="lead text-white-50 mb-4">Manage your event in one place</p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="py-5 border-bottom">
        <div class="container px-5 my-5 px-5">
            <div class="text-center mb-5">
                <h2 class="fw-bolder mb-5">Barangay</h2>
                @yield('facility')
            </div>
        </div>
    </section>

    <section class="py-5 border-bottom">
        <div class="container px-5 my-5 px-5">
            <div class="text-center mb-5">
                <h2 class="fw-bolder">How to Join?</h2>
            </div>
            <div class="lead mb-0">
                <p>5 steps to join an event!</p>
                <p>Step 1: Select a barangay and click view events</p>
                <p>Step 2: Select a facility</p>
                <p>Step 3: Select an event</p>
                <p>Step 4: Click join and your name will be listed in the event attendee list</p>
                <p>Step 5: You can now check your events and send feedback to the organizer in joined event</p>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container px-5">
            <p class="m-0 text-center text-white">Information System &copy; SkyCems 2022</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') SkyCems</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/standard.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('/images/logo.png') }}">

</head>

<body class="antialiased">
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="">
                <div class="logotitle">Sky <span>Cems</span></div>
            </a>
            @if (Route::has('login'))
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link">Home</a></li>
                @else

                @if (Route::has('register'))
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                @endif
                @endauth
            </ul>
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
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                            <a class="btn btn-primary btn-lg px-4 me-sm-3" href="#start">Get Started</a>
                            <a class="btn btn-outline-light btn-lg px-4" href="#about">About Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Login Section -->
    <main class="py-4" id="start">
        @yield('content')
    </main>
    <section class="py-5 border-bottom">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                            class="bi bi-collection"></i></div>
                    <h2 class="h4 fw-bolder">Simple and easy to use</h2>
                    <p>Planning an event has never been easier. </p>
                </div>
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-building"></i>
                    </div>
                    <h2 class="h4 fw-bolder">Everything is online</h2>
                    <p>It eliminates the need for large face to face process since most processes are online.</p>
                </div>
                <div class="col-lg-4">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i>
                    </div>
                    <h2 class="h4 fw-bolder">Smooth workflows</h2>
                    <p>Smooth workflows in the entire lifecycle of the event ensuring greater success.</p>
                </div>
            </div>
        </div>
    </section>
    <main class="py-4" id="start">
            <div class="text-center mb-5">
                <h2 class="fw-bolder">Upcoming Events</h2>
            </div>
            @forelse($event = \App\Models\Eventregister::join('facility_management',
            'event_register_detail.facility_id','facility_management.facility_id')
            ->where('event_register_detail.status', 'Approved')->paginate(3) as $events)
            <br>
            <div class="row justify-content-center">
                <div class="col-md-auto">
                    <img src="/image/{{ $events->image }}" style="width: 430px;height: 310px;" class="img-thumbnail"
                        alt="" />
                </div>
                <div class="col-md-4">
                    <h4>{{$events['facility']}}</h4>
                    <h4 class="subheading">{{$events['address']}}</h4>
                    <p class="text-muted">Start at {{date('F d, Y h:i a', strtotime($events['start_datetime']))}} - End
                        at {{date('F d, Y h:i a', strtotime($events['end_datetime']))}}</p>
                    <p class="text-muted">Contact#: {{$events['contact']}} {{$events['email']}}</p>
                    <p class="text-muted">{{$events['reason']}}</p>
                </div>         
            </div>
            @empty
                <h4>No Events</h4>
            @endforelse
            <div class="mt-4 d-flex justify-content-center text-center">
            {{$event->links()}}
            </div>
        </main>
    <!-- Pricing section-->
    <section class="bg-light py-5 border-bottom">
        <div class="container px-5 my-5">
            <div class="text-center mb-5">
                <h2 class="fw-bolder">Hosting Plan</h2>
                <p class="lead mb-0">With our no hassle pricing plans</p>
            </div>
            <div class="row gx-5 justify-content-center">
                <!-- Pricing card free-->
                <!-- <div class="col-lg-6 col-xl-4">
                    <div class="card mb-5 mb-xl-0">
                        <div class="card-body p-5">
                            <div class="small text-uppercase fw-bold text-muted">Basic</div>
                            <div class="mb-3">
                                <span class="display-4 fw-bold">P0</span>
                                <span class="text-muted">/ mo.</span>
                            </div>

                            <ul class="list-unstyled mb-4">
                                <li class="mb-2">
                                    <i class="bi bi-check text-primary"></i>
                                    <strong>1 month free trial</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-primary"></i>
                                    Add unlimited facilities
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-primary"></i>
                                    Unlimited public projects
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-primary"></i>
                                    Manage schedule for facilities
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-primary"></i>
                                    View Reservation History
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->
                <!-- Pricing card pro-->
                <div class="col-lg-6 col-xl-4">
                    <div class="card mb-5 mb-xl-0">
                        <div class="card-body p-5">
                            <div class="small text-uppercase fw-bold">
                                <i class="bi bi-star-fill text-warning"></i>
                                Premium
                            </div>
                            <div class="mb-3">
                                <span class="display-4 fw-bold">P1299</span>
                                <span class="text-muted">/ mo.</span>
                            </div>

                            <ul class="list-unstyled mb-4">
                                <li class="mb-2">
                                    <i class="bi bi-check text-primary"></i>
                                    <strong>Unlimited Access</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-primary"></i>
                                    Add unlimited facilities
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-primary"></i>
                                    Unlimited public projects
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-primary"></i>
                                    Manage schedule for facilities
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check text-primary"></i>
                                    View Reservation History
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Pricing card enterprise-->
                <div class="col-lg-6 col-xl-4">
                    <div class="card">
                        <div class="card-body p-5">
                            <div class="small text-uppercase fw-bold text-muted">Barangay Payment Supports</div>
                            <div class="mb-5">
                                <!-- <p><a class="lead mb-0" href="{{ route('guest.payment') }}">To activate your account you
                                        must
                                        pay here. Click Here.</a></p> -->
                            </div>
                            <img class="py-4" style="width: 80%;height: 80%;" class="img-fluid"
                                src="{{ asset('/images/GCASH-PAYMAYA.jpg') }}" alt="">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5" id="about">
        <div class="container px-5 my-5 px-5">
            <div class="text-center mb-5">
                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-envelope"></i>
                </div>
                <h2 class="fw-bolder">About Us</h2>
                <p class="lead mb-0">
                    <p class="lead mb-0">We are students at De La Salle of Saint Benilde who are taking up a Bachelor of
                        Science Major in Information System. We are conducting a study called "The Efficiency of a
                        Web-based Event Management System
                        Platform for Communities in Cavite". We look forward to successfully connecting with you.</p>
                </p>
            </div>
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">

                </div>
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
    @stack('submit')
</body>

</html>

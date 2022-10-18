<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('name', 'SkyCems') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- endinject -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="antialiased">
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="{{ route('host.index')}}">SkyCems</a>
            
        </div>
    </nav>

    <section class="py-5">
        <div class="container px-5 my-5 px-5">
            <div class="mb-5">
                <div class="text-center">
                    <h2>Page not found</h2>
                    <p>We are sorry, the page you requested could not be found.</p>
                    <a type="button" href="{{ route('host.index') }}" class="btn btn-primary">Go back</a>

                </div>
            </div>
        </div>
    </section>

</body>

</html>

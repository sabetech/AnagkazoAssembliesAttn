<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:site_name" content="{{ $council->council }} FLOW Forms">
    <meta property="og:title" content="{{ $council->council }} FLOW Forms" />
    <meta property="og:description" content="Data about the FLOW prayer for the various councils/missions" />
    <meta property="og:image" itemprop="image" content="https://images.unsplash.com/photo-1521178010706-baefe2334211?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=675&q=80">
    <meta property="og:type" content="website" />
    <meta property="og:updated_time" content="1440432930" />



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $council->council }} FLOW Prayer<br>Attendance Form
</title>

    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @if(isset($page_title))
                        {{$page_title}}
                        @else
                        {{ $council->council }} FLOW Prayer<br>Attendance Form
                    @endif

                </a>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>


<script type="text/javascript" src="{{ url('js/jquery.min.js?v=2') }}"></script>
<script type="text/javascript" src="{{ url('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/popper.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="{{ url('js/daterangepicker.js') }}"></script>
<script src="{{ url('js/select2.full.min.js') }}" ></script>


@yield('scripts')
</body>
</html>

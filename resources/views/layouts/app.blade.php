<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.1/trix.css">

    <!-- Scripts -->
    <script>
        {{--window.App = {!! json_encode([--}}
            {{--'csrfToken' => csrf_token(),--}}
            {{--'user' => Auth::user(),--}}
            {{--'signedIn' => Auth::check()--}}
        {{--]) !!};--}}
    </script>

    <style>
        body { padding-bottom: 100px; }
        .level { display: flex; align-items: center; }
        .level-item { margin-right: 1em; }
        .flex { flex: 1; }
        .mr-1 { margin-right: 1em; }
        .ml-a { margin-left: auto; }

        [v-cloak] { display: none; }
        .ais-highlight > em { background: yellow; font-style: normal; }
        .navbar-static-top {
            border-color: #e7e7e7;
            background-color: #fff;
            -webkit-box-shadow: 0px 1px 11px 2px rgba(42, 42, 42, 0.1);
            border-top: 4px solid #00b5ad;
            border-top-color: rgb(0, 181, 173);
            margin-bottom: 40px;
        }
    </style>

    @yield('head')
</head>
<body>
<div id="app">
    @include ('layouts.nav')
    @yield('content')

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>

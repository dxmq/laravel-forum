<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/trix.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <!-- Scripts -->
    <script>
        window.App = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user(),
        'signedIn' => Auth::check()
    ]) !!};
    </script>

    @yield('css')

</head>
<body style="padding-bottom: 100px;">
<div id="app" class="topics-index-page">
    @include ('layouts.nav')

    @yield('content')

    <go-top></go-top>

    @include('layouts.partials.footer')

    <flash message="{{ session('flash') }}"></flash>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>

<script>window.search_url = '{{ route("searching") }}';</script>
<script src="{{ asset('js/searching.js') }}" defer></script>

@yield('js')
</body>
</html>

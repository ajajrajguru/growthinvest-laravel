<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,700" rel="stylesheet">
        <!-- <link href="https://use.fontawesome.com/releases/v5.0.3/css/all.css" rel="stylesheet"> -->
        <script src="https://use.fontawesome.com/f78b0fef8f.js"></script>

        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        @yield('css')
        <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
 
            ]) !!};
        </script>
        <title>{{ (isset($pageTitle)) ? $pageTitle : config('app.name', 'Growthinvest') }}</title>
    </head>
    <body>
        @include ('layouts.navigation-menu') 
        <!-- The part of the page that begins to differ between templates -->
        @yield('content')

        <script type="text/javascript" src="{{ asset('/bower_components/jquery/dist/jquery.min.js') }}"></script>

        <!-- BS Script -->
        <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
 
        <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
        @yield('js')
    </body>
</html>
 

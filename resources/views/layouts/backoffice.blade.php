@extends('layouts.app')
@section('css')
    <!-- Datatables -->
    <link href="{{ asset('/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bower_components/jQuery.mmenu/dist/jquery.mmenu.all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hamburgers.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading-btn.css') }}">
@endsection

@section('js')

    <!-- Datatables -->
    <script src="{{ asset('/bower_components/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('/bower_components/jQuery.mmenu/dist/jquery.mmenu.all.js') }}"></script>


    <!-- Parsley text validation -->
    <script type="text/javascript" src="{{ asset('/bower_components/parsleyjs/dist/parsley.min.js') }}" ></script>


@endsection

@section('content')
<!-- content -->
 	<div style="position: relative; background-position: center center; background-size: cover; background-image: url({{ asset('img/London-skyline.jpg') }}); height:470px"></div>


    @yield('backoffice-content')

@endsection
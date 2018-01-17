@extends('layouts.app')
@section('css')
    <!-- Datatables -->
    <link href="{{ asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('js')
 
    <!-- Datatables -->
    <script src="{{ asset('/bower_components/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script src="{{ asset('/js/jquery.mmenu.all.js') }}"></script>


    <!-- Parsley text validation -->
    <script type="text/javascript" src="{{ asset('/bower_components/parsleyjs/dist/parsley.min.js') }}" ></script>

   
@endsection

@section('content')
<!-- content -->
 	<div style="position: relative; background-position: center center; background-size: cover; background-image: url({{ asset('img/London-skyline.jpg') }}); height:470px"></div>
 	

    @yield('backoffice-content')
     
@endsection
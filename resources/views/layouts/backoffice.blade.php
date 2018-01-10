@extends('layouts.app')
@section('title', 'Admin-Dashboard')
@section('css')
    <!-- Datatables -->
    <link href="{{ asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('js')
 
    <!-- Datatables -->
    <script src="{{ asset('/bower_components/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

   
@endsection

@section('content')
<!-- content -->
 

    @yield('backoffice-content')
     
@endsection
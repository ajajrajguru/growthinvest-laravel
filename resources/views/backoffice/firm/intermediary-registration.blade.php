@extends('layouts.backoffice')


@section('js')
  @parent

  <script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('backoffice-content')

<div class="container">

	@php
        echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
    @endphp

    @include('includes.notification')

	<div class="mt-4 bg-white border border-gray p-4">
		@include('backoffice.firm.firm-navigation')

 
  		 @include('backoffice.user.intermediary-registration')
	</div>

</div>
  
<style type="text/css">
        #datatable-users_filter{
            display: none;
        }
    </style>

@endsection

@extends('layouts.backoffice')


@section('js')
  @parent
<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/backoffice-investors.js') }}"></script>

<script type="text/javascript" src="{{ asset('/bower_components/select2/dist/js/select2.min.js') }}" ></script>
<link rel="stylesheet" href="{{ asset('/bower_components/select2/dist/css/select2.min.css') }}" >

<script type="text/javascript">
    
    $(document).ready(function() {
        // select2
        $('.select2-single').select2({
            // placeholder: "Search here"
        });

        $(document).on('change', '.investor_actions', function() {
           var editUrl = $('option:selected', this).attr('edit-url');
           if(editUrl!=''){
            window.open(editUrl);
           }
           
        });
    });


</script>
@endsection

@section('backoffice-content')

<div class="container">

	@php
        echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
    @endphp

    @include('includes.notification')

	<div class="mt-4 bg-white border border-gray p-4">
		@include('backoffice.firm.firm-navigation')

		 
  		 @include('backoffice.clients.investors-list')
	</div>

</div>
  
<style type="text/css">
        #datatable-users_filter{
            display: none;
        }
    </style>

@endsection

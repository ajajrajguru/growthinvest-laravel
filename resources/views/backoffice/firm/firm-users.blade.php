@extends('layouts.backoffice')


@section('js')
  @parent
<script type="text/javascript">

    var userRoles = <?php echo json_encode($roles);?>;
    console.log(userRoles)
</script>
<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {
        $( ".firm_actions" ).change(function() {
           var editUrl = $(this).attr('edit-url')
           window.open(editUrl);
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

		<div class="row">
            <div class="col-md-6">
                <h1 class="section-title font-weight-medium text-primary mb-0">View Users</h1>

                <p class="text-muted">View all Intermediaries registered with us.</p>

            </div>
            <div class="col-md-6">
                <div class="float-right">
                    <a href="{{ url('backoffice/firm/'.$firm->gi_code.'/intermediary-registration')}}" class="btn btn-primary">Add User</a>
                    <a href="{{ url('backoffice/firm/'.$firm->gi_code.'/export-users')}}" class="btn btn-outline-primary">Download CSV</a>

                </div>
            </div>
        </div>

		<!-- <h1 class="section-title font-weight-medium text-primary mb-0">Add Firm</h1> -->
  		 @include('backoffice.user.userlist')
	</div>

</div>
  
<style type="text/css">
        #datatable-users_filter{
            display: none;
        }
    </style>

@endsection

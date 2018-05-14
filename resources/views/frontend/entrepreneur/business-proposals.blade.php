@extends('layouts.frontend')

 
@section('frontend-content')


<div class="container pb-5">

<!-- mobile filter --> 
<div class="mobile-filter-btn rounded-circle pulse d-md-none"> 
	<i class="fa fa-filter"></i> 
</div> 
<!-- /mobile filter -->

 
<!-- tabs -->
<div class="squareline-tabs mt-5">
	@include('frontend.entrepreneur.topmenu')
	
</div>
<!-- /tabs -->
 
	<div class="row mt-5">
		 			
		<div class="col-sm-12">
			<p>This dashboard will allow you to review your Business Proposals, and to edit and add information onto existing proposals as it becomes available. In order to proceed with your application, we need as much information as possible on every aspect of your business and requirements. We will then review the application and get back to you within 2 working days. To get started with an application - please click on the Create new proposal button below.
			</p>

            <div class="float-right">

                <a href="{{ url('/add-business-proposals/')}}" class="btn btn-primary">Create new proposal</a>
            </div>

        </div>

        <div class="col-sm-12">
        	<hr class="my-3">
         	{!! View::make('frontend.entrepreneur.business-card', compact('businessListings'))->render() !!}
         </div>        
	  
	</div>
</div>
	 
 
 
</div> <!-- /container -->
 
 
 


@include('includes.footer')
@endsection
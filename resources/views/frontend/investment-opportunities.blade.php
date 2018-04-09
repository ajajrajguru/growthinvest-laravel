@extends('layouts.frontend')


@section('frontend-content')

 @section('css')

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css" /> -->
<link rel="stylesheet" href="{{ asset('/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" />
@endsection


@section('js')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script> -->
<script src="{{ asset('/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<script src="{{ asset('/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/investment-opportinities.js') }}"></script>

<script>
	$(document).ready(function() {
		$(".filter-options").mCustomScrollbar({
			theme:"dark"
		});
	});
</script>
 
@endsection


<div class="container pb-5">
	 
	<div class="row mt-5">
		@if($business_listing_type == 'proposal')
			@include('frontend.business-listings.single-company-sidebar')
		@endif
		<div class="col-sm-9">
			<!-- card -->

			<div class="d-sm-flex justify-content-sm-between mb-3">
				<div class="input-group mt-3 mt-sm-0 mb-3 mb-sm-0 mr-sm-5 media-body">
					<input type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
				  	<div class="input-group-append">
				    	<button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
				  	</div>
				</div>

				<div class="media-body mb-3 mb-sm-0">
					<select name="" id="" class="form-control">
						<option value="">All</option>
						<option value="">Most Active</option>
						<option value="">Least Active</option>
						<option value="">Most Funded</option>
						<option value="">Least Funded</option>
						<option value="">Newest First</option>
						<option value="">Oldest First</option>
						<option value="">Sort A-Z</option>
					</select>
				</div>
			</div>
			
			<div class="alert bg-primary text-uppercase text-white text-center rounded-0">open investment offers</div>
			<div class="business-listing"></div>
			<div class="platform-listing-section d-none">
				
					<div class="alert bg-primary text-uppercase text-white text-center rounded-0">PLATFORM LISTINGS</div>
				
			</div>	
			<div class="platform-listing">
			</div>
	</div>
	 
 
 
</div> <!-- /container -->
 
 
 



@endsection
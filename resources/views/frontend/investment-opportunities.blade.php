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
		// custom scrollbar
		$(".filter-options").mCustomScrollbar({
			theme:"dark"
		});


		// mobile filter - floating btn
		$( ".mobile-filter-btn" ).click(function() { 
	      $( ".mobile-filters" ).toggleClass( "slideIn SlideOut" ); 
	      $( "body" ).toggleClass( "modal-open" ); 
	    }); 
	 
	    $( ".mobile-filter-btn" ).on( "click", function( event ) { 
	      $( this ).removeClass('pulse'); 
	      $( this ).off( event ); 
	    });
	    
	});


</script>

 
@endsection


<div class="container pb-5">

<!-- mobile filter --> 
<div class="mobile-filter-btn rounded-circle pulse d-md-none"> 
	<i class="fa fa-filter"></i> 
</div> 
<!-- /mobile filter -->

<!-- test -->
<!-- <p class="mb-3 h6">Tax efficient investments offer various tax benefits to qualifying investments whilst simultaneously encouraging investment into the UK entrepreneurial business scene and are made through government-backed schemes such as <strong>SEIS, EIS &amp; VCTs</strong>. The benefits of these types of investments vary from income tax relief to capital gains relief, through to loss relief and inheritance tax relief.</p>

<p class="mb-3 h6">We offer a range of tax efficient investments on GrowthInvest. Further information on each type is included on the dedicated sections below:</p>

<div class="card-deck">
  	<div class="card card-animated">
  		<a href="" class="d-flex justify-content-center align-items-center card-link">
	  		<div class="animate-border">SEIS <span class="slideInLeft">»</span></div>
  		</a>
  	</div>

  	<div class="card card-animated">
  		<a href="" class="d-flex justify-content-center align-items-center card-link">
	  		<div class="animate-border">EIS <span class="slideInLeft">»</span></div>
  		</a>
  	</div>

  	<div class="card card-animated">
  		<a href="" class="d-flex justify-content-center align-items-center card-link">
	  		<div class="animate-border">VCT <span class="slideInLeft">»</span></div>
  		</a>
  	</div>
</div> -->
<!-- /test -->

<!-- tabs -->
<div class="squareline-tabs mt-5">
	<ul class="nav nav-tabs">
		@if($business_listing_type != 'proposal')
		<li class="nav-item">
	   		<a class="nav-link active d-none d-sm-block px-5" data-toggle="tab" href="{{ url('investment-opportunities/single-company/') }}">Single Companies</a>
		</li>
		@endif
		@if($business_listing_type != 'fund')
		<li class="nav-item">
	    	<a class="nav-link d-none d-sm-block px-5" data-toggle="tab" href="{{ url('investment-opportunities/funds/') }}">Funds</a>
		</li>
		@endif
		@if($business_listing_type != 'vct')
		<li class="nav-item">
	    	<a class="nav-link d-none d-sm-block px-5" data-toggle="tab" href="{{ url('investment-opportunities/vct/') }}">VCTs</a>
		</li>
		@endif
						
		
	</ul>
</div>
<!-- /tabs -->

	<div class="row mt-5">
		@if($business_listing_type == 'proposal')
			@include('frontend.business-listings.single-company-sidebar')
		@elseif($business_listing_type == 'fund')
			@include('frontend.business-listings.fund-sidebar')
		@elseif($business_listing_type == 'vct')
			@include('frontend.business-listings.vct-sidebar')
		@endif
		<div class="col-sm-9">
			<!-- card -->

			<div class="d-sm-flex justify-content-sm-between mb-3">
				<div class="input-group mt-3 mt-sm-0 mb-3 mb-sm-0 mr-sm-5 media-body">
					<input type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" name="search_title" aria-describedby="basic-addon2">
				  	<div class="input-group-append">
				    	<button class="btn btn-outline-secondary search-by-title" type="button"><i class="fa fa-search"></i></button>
				  	</div>
				</div>

				<div class="media-body mb-3 mb-sm-0">
					<select name="order_by" id="" class="form-control">
						<option value="">All</option>
						<option value="most_active">Most Active</option>
						<option value="least_active">Least Active</option>
						<option value="most_funded">Most Funded</option>
						<option value="least_funded">Least Funded</option>
						<option value="newest_first">Newest First</option>
						<option value="oldest_first">Oldest First</option>
						<option value="a_z">Sort A-Z</option>
					</select>
				</div>
			</div>
			
			<div class="alert bg-primary text-uppercase text-white text-center rounded-0 mb-4">open investment offers</div>
			<div class="business-listing"></div>
			<div class="platform-listing-section d-none mb-4">
				<div class="alert bg-primary text-uppercase text-white text-center rounded-0">PLATFORM LISTINGS</div>
			</div>	
			<div class="platform-listing">
			</div>

			<div class=" justify-content-center align-items-center mh-150 investment-loader d-none">
				<h1><i class="fa fa-spinner fa-spin"></i></h1>
			</div>

			<div class=" justify-content-center align-items-center mh-150 no-data-conatiner d-none">
				<h3 class="">No Data Found!</h3>
			</div>
	</div>
	 
 
 
</div> <!-- /container -->
 
 
 



@endsection
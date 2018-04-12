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
@section('frontend-content')


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
  		<a href="{{ url('investment-opportunities/single-company/') }}" class="d-flex justify-content-center align-items-center card-link">
	  		<div class="animate-border">SEIS <span class="slideInLeft">»</span></div>
  		</a>
  	</div>

  	<div class="card card-animated">
  		<a href="{{ url('investment-opportunities/funds/') }}" class="d-flex justify-content-center align-items-center card-link">
	  		<div class="animate-border">EIS <span class="slideInLeft">»</span></div>
  		</a>
  	</div>

  	<div class="card card-animated">
  		<a href="{{ url('investment-opportunities/vct/') }}" class="d-flex justify-content-center align-items-center card-link">
	  		<div class="animate-border">VCT <span class="slideInLeft">»</span></div>
  		</a>
  	</div>
</div> -->
<!-- /test -->

<!-- tabs -->
<div class="squareline-tabs mt-5">
	<ul class="nav nav-tabs">
 
		
		<li class="nav-item ">
	   		<a class="nav-link px-sm-5 @if($business_listing_type == 'proposal') active @endif"  href="{{ url('investment-opportunities/single-company/') }}">Single Companies</a>
		</li>
		
 
		<li class="nav-item ">
	    	<a class="nav-link px-sm-5 @if($business_listing_type == 'fund') active @endif"  href="{{ url('investment-opportunities/funds/') }}">Funds</a>
		</li>
 
		<li class="nav-item ">
	    	<a class="nav-link px-sm-5 @if($business_listing_type == 'vct') active @endif"  href="{{ url('investment-opportunities/vct/') }}">VCTs</a>
 
		</li>
		 
						
		
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

		<div>
		@if($business_listing_type == 'proposal')	 

			<b>EIS & SEIS - Single Companies</b> <br>
			The Enterprise Investment Scheme (EIS) was introduced by the government in 1994 to promote investment into smaller, and therefore typically higher risk, companies. To encourage such investment, there is a range of tax reliefs available to qualifying investors.  <br> <br>

			The Seed Enterprise Investment Scheme was introduced in 2012, and is similar to the EIS, though to qualify the companies must be smaller and earlier stage than for EIS. As these are therefore typically riskier investments, there are more substantial reliefs available. <br> <br>
			NOTE: Investments of this nature carry risks to your capital as well as potential rewards. Please read our risk warning before deciding to invest.

		@elseif($business_listing_type == 'fund')
			<b>EIS & SEIS - Funds</b> <br>
			The Enterprise Investment Scheme (EIS) was introduced by the government in 1994 to promote investment into smaller, and therefore typically higher risk, companies. To encourage such investment, there is a range of tax reliefs available to qualifying investors.  <br> <br>

			The Seed Enterprise Investment Scheme was introduced in 2012, and is similar to the EIS, though to qualify the companies must be smaller and earlier stage than for EIS. As these are therefore typically riskier investments, there are more substantial reliefs available.  <br> <br>

			Whilst the original schemes were intended to encourage investments into direct companies, there are now a number of Funds and Portfolio services run by professional fund managers, providing a portfolio.of earlier stage UK companies. <br> <br>
			NOTE: Investments of this nature carry risks to your capital as well as potential rewards. Please read our risk warning before deciding to invest.
		@elseif($business_listing_type == 'vct')
			<b>VCTs</b> <br>
			A Venture Capital Trust (VCT) is a publicly listed company. The company, run by a fund manager, invests in a number of small unquoted companies. <br> <br>Therefore an investor into a VCT is investing in the fund manager’s selected portfolio of earlier stage UK companies, and thereby helps them to grow. To encourage investment of this sort, the government provides a number of tax benefits to qualifying UK investors.<br> <br>
			NOTE: Investments of this nature carry risks to your capital as well as potential rewards. Please read our risk warning before deciding to invest.
		@endif
		</div>	
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
			
			<div class="alert bg-primary text-uppercase text-white text-center rounded-0 mb-4 open-investment-offers">open investment offers</div>
			<div class="business-listing"></div>
			<div class="platform-listing-section d-none mb-4">
				@if($business_listing_type == 'vct')
				<div class="alert bg-primary text-uppercase text-white text-center rounded-0">LIVE MARKET OFFERS</div>
				@else
				<div class="alert bg-primary text-uppercase text-white text-center rounded-0">PLATFORM LISTINGS</div>
				@endif 
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
</div>
	 
 
 
</div> <!-- /container -->
 
 
 


@include('includes.footer')
@endsection
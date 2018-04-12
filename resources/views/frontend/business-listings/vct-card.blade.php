@foreach($businessListings as $businessListing)
	@php

	$businessDefaults = $businessListing->business_defaults; 
	$sectors = (isset($businessDefaults['business-sector']))? $businessDefaults['business-sector'] : [];
 	
 	 $fundVctDetails = $businessListing->businessFundVctDetails();  
 	 $fundCloseDate = $businessListing->businessFundCloseDate();  
	$proposalDetails = $businessListing->businessProposalDetails();
	@endphp
<!-- VCT -->
<div class="row d-sm-flex border mb-3 box-shadow-1 mx-xs-0">
	<div class="col-sm-4 border-right px-0">
		<a href="">
			<div style="background: url('https://dummyimage.com/1000x1000') no-repeat center; background-size: cover;" class="mh-150 position-relative">
				<div class="position-absolute text-center w-100" style="bottom: -30px;">
					<img src="https://dummyimage.com/60x60" alt="" class="img-fluid border">
				</div>
			</div>
		</a>

		<div class="d-flex justify-content-between mt-5 px-3 mb-3">
			<div data-toggle="tooltip" title="{{ (isset($proposalDetails['address'])) ? $proposalDetails['address'] :'' }}"><i class="fa fa-map-marker"></i> LOCATION</div>
			<div>
				@foreach($businessListing->tax_status as $taxStatus)
				<span class="badge bg-primary text-white mr-1 py-1">{{ $taxStatus }}</span>
				@endforeach
			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<h5 class="mt-3"><a href="{{ url('investment-opportunities/single-company/'.$businessListing->slug) }}" class="text-primary">{{ $businessListing->title }}</a></h5>
		<p class="mb-2"><strong>Investment Strategy:</strong> {{ $businessListing->businessInvestmentStrategy() }}</p>
		<p>{{ $businessListing->short_content }}</p>
		<hr class="mt-2 mb-2">
		
		<div class="row">
			<div class="col-sm-6">
				<p class="mb-2"><strong>AIC Sector:</strong> 
					@foreach($sectors as $sector)
					 {!! $sector !!} 
					@endforeach
				</p>
				<p class="mb-2"><strong>Close Date:</strong> {{ $fundCloseDate }}</p>
			</div>
			<div class="col-sm-6">
				<p class="mb-2"><strong>Overall Offer Size:</strong> @if(isset($fundVctDetails['overalloffersize'])) {{ $fundVctDetails['overalloffersize'] }} @endif</p>
				<p class="mb-2"><strong>Funds Raised to Date :</strong> @if(isset($fundVctDetails['fundstaisedtodate'])) {{ $fundVctDetails['fundstaisedtodate'] }} @endif</p>
			</div>
		</div>

		<div class="text-right"><a href="" class="btn btn-sm btn-link mb-3">View Details &raquo;</a></div>
	</div>
</div>
@endforeach
		 
@foreach($businessListings as $businessListing)
	@php

	$businessDefaults = $businessListing->business_defaults; 
	$dueDeligence = (isset($businessDefaults['approver']))? implode('',$businessDefaults['approver']) : '';
	$stageOfBusiness = (isset($businessDefaults['stage_of_business']))? implode('',$businessDefaults['stage_of_business']) : '';
	$sectors = (isset($businessDefaults['business-sector']))? $businessDefaults['business-sector'] : [];
 	$proposalDetails = $businessListing->businessProposalDetails();
	
	@endphp
<div class="row d-sm-flex border mb-4 box-shadow-1 mx-0 is-hovered">
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
	<div class="col-sm-8 d-sm-flex flex-sm-wrap">
		<div class="w-100">
			<h5 class="mt-3"><a href="{{ url('investment-opportunities/funds/'.$businessListing->slug) }}" class="text-primary card-link">{{ $businessListing->title }}</a></h5>
			<p class="mb-2"><strong>Fund Type:</strong> {{ $businessListing->businessFundType() }}</p>
			<p>{{ $businessListing->short_content }}</p>
			<hr class="mt-2 mb-2">
			<div><strong>Investment Sector:</strong></div>
			<div class="mb-3">
				@foreach($sectors as $sector)
				<span class="badge bg-dark text-white mr-1 py-1">{!! $sector !!}</span>
				@endforeach
			</div>
		</div>

		<div class="w-100 text-center mt-sm-0 mb-sm-0 d-sm-flex flex-sm-wrap flex-sm-column justify-content-sm-end align-items-sm-end">
			<a href="{{ url('investment-opportunities/funds/'.$businessListing->slug) }}" class="btn btn-sm btn-link mt-3 mb-3 card-link">View Details &raquo;</a>
		</div>
		
	</div>
</div>
@endforeach
@foreach($businessListings as $businessListing)
	@php

	$businessDefaults = $businessListing->business_defaults; 
	$dueDeligence = (isset($businessDefaults['approver']))? implode('',$businessDefaults['approver']) : '';
	$stageOfBusiness = (isset($businessDefaults['stage_of_business']))? implode('',$businessDefaults['stage_of_business']) : '';
	$sectors = (isset($businessDefaults['business-sector']))? $businessDefaults['business-sector'] : [];
 
	
	@endphp
<div class="row d-sm-flex border mb-4 box-shadow-1 mx-0">
	<div class="col-sm-4 border-right px-0">
		
		<!-- due diligence -->
		<div class="position-absolute mw-150 mh-60" style="top: -10px; left: -10px; z-index: 1;">
    		<img src="https://dummyimage.com/150x60" alt="" class="img-fluid border">
    	</div>
		<a href="">
			{{ $dueDeligence }}
			<div style="background: url('https://dummyimage.com/1000x1000') no-repeat center; background-size: cover;" class="mh-150 position-relative">
				<div class="position-absolute m-auto left-0 right-0 mw-60 mh-60" style="bottom: -30px;">
					<img src="https://dummyimage.com/60x60" alt="" class="img-fluid border">
				</div>
			</div>
		</a>

		<div class="d-flex justify-content-between mt-5 px-3 mb-3">
			<div data-toggle="tooltip" title="221 B, Baker Street, London"><i class="fa fa-map-marker"></i> LOCATION</div>
			<div>
				@foreach($businessListing->tax_status as $taxStatus)
				<span class="badge bg-primary text-white mr-1 py-1">{{ $taxStatus }}</span>
				@endforeach

			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="row d-sm-flex h-100">
			<div class="@if($dueDeligence!='Platform Listing') col-sm-8 @else col-sm-12 @endif border-right">
				<h5 class="mt-3"><a href="{{ url('investment-opportunities/single-company/'.$businessListing->slug) }}" target="_blank" class="text-primary card-link">{{ $businessListing->title }}</a></h5>
				<p class="mb-2"><strong>Stage of Business:</strong> {{ $stageOfBusiness }}</p>
				<p>{{ $businessListing->short_content }}</p>
				<hr>
				<div><strong>Business Sector:</strong></div>
				<div class="mb-3">
					@foreach($sectors as $sector)
					<span class="badge bg-dark text-white mr-1 py-1">{!! $sector !!}</span>
					@endforeach
				</div>

			</div>
			@if($dueDeligence!='Platform Listing')
			<div class="col-sm-4 text-center">
				<div class="mt-2">
					<input type="text" class="knob animated" data-width="70" data-height="70" data-cursor="false" data-thickness=".2" rel=" " value="{{ round($businessListing->fund_raised_percentage) }}">
				</div>
				<h4 class="mb-0"> {{ format_amount($businessListing->target_amount, 0, true) }}</h4>
				<div>Investment Sought</div>
				<hr class="mt-2 mb-2">
				<h4 class="mb-0"> {{ format_amount($businessListing->amount_raised, 0, true) }}</h4>
				<div>funded</div>
				<div class="mt-2"><a href="{{ url('investment-opportunities/single-company/'.$businessListing->slug) }}" target="_blank" class="btn btn-sm btn-link">View Details &raquo;</a></div>
			</div>
		@endif
		</div>
	</div>
</div>
@endforeach
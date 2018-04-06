@foreach($businessListings as $businessListing)
	@php

	$businessDefaults = $businessListing->getBusinessDefaultsData(); 
	$stageOfBusiness = (isset($businessDefaults['stage_of_business']))? implode('',$businessDefaults['stage_of_business']) : '';
	$sectors = (isset($businessDefaults['business-sector']))? $businessDefaults['business-sector'] : [];
	
	
	@endphp
<div class="row d-sm-flex border mb-3 box-shadow-1 mx-0">
	<div class="col-sm-4 border-right px-0">
		<a href="">
			<div style="background: url('https://dummyimage.com/1000x1000') no-repeat center; background-size: cover;" class="mh-150 position-relative">
				<div class="position-absolute text-center w-100" style="bottom: -30px;">
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
		<div class="row d-sm-flex">
			<div class="col-sm-8 border-right">
				<h5 class="mt-3"><a href="" class="text-primary">{{ $businessListing->title }}</a></h5>
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
			<div class="col-sm-4 text-center">
				<div class="mt-2">
					<input type="text" class="knob animated" data-width="70" data-height="70" data-cursor="false" data-thickness=".2" rel=" " value="{{ $businessListing->percentage }}">
				</div>
				<h4 class="mb-0"> {{ format_amount($businessListing->target_amount, 0, true) }}</h4>
				<div>Investment Sought</div>
				<hr class="mt-2 mb-2">
				<h4 class="mb-0"> {{ format_amount($businessListing->amount_raised, 0, true) }}</h4>
				<div>funded</div>
				<div class="mt-2"><a href="" class="btn btn-sm btn-link">View Details &raquo;</a></div>
			</div>
		</div>
	</div>
</div>
@endforeach
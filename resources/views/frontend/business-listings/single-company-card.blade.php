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
		
		<!-- due diligence -->
		<div class="position-absolute mw-150 mh-60" data-container="body" data-toggle="popover" data-placement="left" data-html="true" style="top: -10px; left: -10px; z-index: 1;">
    		<img src="https://dummyimage.com/150x60" alt="" class="img-fluid border">
    	</div>
    	<!-- popover markup -->
    	<div id="popover-content" class="d-none">

    		@if($dueDeligence == 'Independent Report')
			<!-- Independent Report -->
	      	<h6>Independent Report</h6><hr class="mb-2 mt-2">
	      	<div>The Gold tier requires the provision of information in accordance with the Bronze tier and for the investment opportunity to be subjected to an independent third party review and reporting process. The Gold Tier report will be written by an independent leading analyst and will contain a review of the efficacy of the investment proposition relative to others in the market, while also identifying key factors that will impact upon the successful outcome of the investment. Overall the Gold Tier report is designed to provide investors and advisers with high quality research to allow them to make informed decisions with greater confidence and reassurance.</div>

	      	@elseif($dueDeligence == 'Analyst Report')
    		<!-- Analyst Report	 -->
	      	<h6>Analyst Report</h6><hr class="mb-2 mt-2">
	      	<div> The Silver tier requires the provision of information in accordance with the Bronze tier and for the business to provide a report prepared by a business analyst appointed by us. The Analyst Report is designed to provide additional information and the businesses response to key characteristics and potential risks and opportunities contained within the investment proposal.</div>
	      	@elseif($dueDeligence == 'Initial Due Diligence')
	      	<!-- Initial Due Diligence -->
	      	<h6>Initial Due Diligence</h6><hr class="mb-2 mt-2">
	      	<div>The Bronze tier is designed to confirm that the investment strategy is in compliance with HMRC rules for SEIS or EIS eligibility , test the rationale of the business proposition and also includes a third party check on the creditworthiness of the business and its directors. The GrowthInvest in-house analyst will review the business plan and financial projections and collect a list of statutory and business related documents related to the companies good standing and the investment proposition. This is the minimum stage of due diligence that must be completed for a business to become live on our platform in order to receive investments.</div>
	      	@elseif($dueDeligence == 'Platform Listing')
	      	<!-- Platform Listing -->
	      	<h6>Platform Listing</h6><hr class="mb-2 mt-2">
	      	<div>Once a business has successfully answered the business profile and due diligence questionnaires, and provided related information , we will place the business onto the Listings tier. This allows the business to be visible to investors, however investments cannot be received until a further level of due diligence has been completed in accordance with one of the tiers below.</div>
	      	@endif

	    </div>
		<a href="">
			{{ $dueDeligence }}
			<div style="background: url('https://dummyimage.com/1000x1000') no-repeat center; background-size: cover;" class="mh-150 position-relative">
				<div class="position-absolute m-auto left-0 right-0 mw-60 mh-60" style="bottom: -30px;">
					<img src="https://dummyimage.com/60x60" alt="" class="img-fluid border">
				</div>
			</div>
		</a>

		<div class="d-flex justify-content-between mt-5 px-3 pb-3 border-xs-bottom">
			<div data-toggle="tooltip" title="{{ (isset($proposalDetails['address'])) ? $proposalDetails['address'] :'' }}"><i class="fa fa-map-marker"></i> LOCATION</div>
			<div>
				@foreach($businessListing->tax_status as $taxStatus)
				<span class="badge bg-primary text-white mr-1 py-1">{{ $taxStatus }}</span>
				@endforeach

			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="row d-sm-flex h-100">
			<div class="@if($dueDeligence!='Platform Listing') col-sm-8 @else col-sm-12 @endif">
				<h5 class="mt-3"><a href="{{ url('investment-opportunities/single-company/'.$businessListing->slug) }}" target="_blank" class="text-primary card-link">{{ $businessListing->title }}</a></h5>
				<p class="mb-2"><strong>Stage of Business:</strong> {{ $stageOfBusiness }}</p>
				<p>{{ (isset($proposalDetails['business_proposal_details'])) ? $proposalDetails['business_proposal_details'] : '' }}</p>
				<hr>
				<div><strong>Business Sector:</strong></div>
				<div class="mb-3">
					@foreach($sectors as $sector)
					<span class="badge bg-dark text-white mr-1 py-1">{!! $sector !!}</span>
					@endforeach
				</div>

			</div>
			@if($dueDeligence!='Platform Listing')
			<div class="col-sm-4 text-center bg-gray">
				<div class="mt-2">
					<input type="text" class="knob animated" data-width="70" data-height="70" data-cursor="false" data-thickness=".2" rel=" " value="{{ round($businessListing->fund_raised_percentage) }}">
				</div>

				<div class="d-sm-block d-flex">
					<div class="media-body">
						<h4 class="mb-0"> {{ format_amount($businessListing->target_amount, 0, true) }}</h4>
						<div>Investment Sought</div>
					</div>

					<hr class="mt-2 mb-2 d-sm-block d-none">

					<div class="media-body">
						<h4 class="mb-0"> {{ format_amount($businessListing->amount_raised, 0, true) }}</h4>
						<div>funded</div>
					</div>
				</div>
				
				
				
				<div class="mt-3 mb-3"><a href="{{ url('investment-opportunities/single-company/'.$businessListing->slug) }}" target="_blank" class="btn btn-sm btn-link">View Details &raquo;</a></div>
			</div>
		@endif
		</div>
	</div>
</div>
@endforeach
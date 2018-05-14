@if($businessListings->count())
	@foreach($businessListings as $businessListing)
	@php
		$logo = $businessListing->getBusinessLogo('thumb_1x1');    
		$logoUrl = $logo['url'];

		if($businessListing->type =='proposal')
			$businessUrl = url('investment-opportunities/single-company/'.$businessListing->slug);
		else
			$businessUrl = url('investment-opportunities/funds/'.$businessListing->slug);

	@endphp
	<div class="row">                    
		<div class="col-md-2 col-sm-2 p-15"> 
		    <div class="img-div img-120">                            
		    	<a href="{{ $businessUrl }}"> <img src="{{ $logoUrl }}">   </a>                        
		    </div>                    
		</div>                    
		<div class="col-md-7 col-sm-7">                        
			<div class="tour_list_desc">                            
				<h5><a href="{{ $businessUrl }}"> {{ $businessListing->title }}  </a></h5>                            <!-- test -->                            
				<div class="row">                                
					<div class="col-md-4 col-sm-4 text-center">                                    
						<span>{{ $businessListing->watchListCount }}</span>                                    
						<p>Added to watchlist</p>                                
					</div>                                
					<div class="col-md-4 col-sm-4 text-center">                                    
						<span>{{ $businessListing->pledgeCount }}</span>                                    
						<p>Pledgers</p>                                
					</div>                                
					<div class="col-md-4 col-sm-4 text-center">
						<span>{{ $businessListing->investedCount }}</span>
						<p>Investors</p>
					</div>                            
				</div>                            
			</div>
		</div>
	<div class="col-md-3 col-sm-3 text-center btn-holder">    
		<div class="price_list">         {{ $businessListing->investedAmount }}    </div>
		    <p>Total Investment</p>    
		    <hr>    
		    <p>Number of Questions <span class="question">({{ $businessListing->questionCount }})</span></p>
		        <a href="{{ $businessUrl }}" class="btn_1">View Proposal</a>
		    </div>
	</div>
	<div class="text-center"><a href="javascript:void(0)" class="btn btn-primary btn-sm ">Create new investment round</a></div>
	<hr class="my-3">
	@endforeach

@else
	<div class="row">                    
		 No Business Proposals
	</div>
@endif

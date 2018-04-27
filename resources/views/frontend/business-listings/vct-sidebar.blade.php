<div class="col-sm-3 mobile-filters slideIn pt-3 pt-sm-0 border-xs-right d-none d-sm-block">
	<div class="d-flex justify-content-between mb-3">
		<div class="text-uppercase">refine your search</div>
		<a href="javascript:void(0)" class="btn btn-primary btn-sm apply-investment-opportunity">Apply</a>
		<a href="javascript:void(0)" class="btn btn-sm btn-outline-primary reset-investment-opportunity">RESET</a>
	</div>
	<!-- accordion -->
	<div id="accordion" class="gi-collapse-2 pb-3 pb-sm-0">
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingOne">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
	          VCT Type
	        </button>
	      </h5>
	    </div>

	    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="vct_type[]" id="ch_limited_life" value="limited_life" slug-val="limited-life" @if(isset($requestFilters['vct-type']) && in_array('limited-life',$requestFilters['vct-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_limited_life">Limited Life</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="vct_type[]" id="ch_evergreen" value="evergreen"  slug-val="evergreen" @if(isset($requestFilters['vct-type']) && in_array('evergreen',$requestFilters['vct-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_evergreen">Evergreen</label>
				</div>
	 
			 
			</div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingTwo">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
	          Investment Strategy
	        </button>
	      </h5>
	    </div>
	    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
				 
	                <div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input filter-business-list" name="vct_investmentstrategy[]" id="ch_generalist" value="generalist" slug-val="generalist" @if(isset($requestFilters['vct-investment-strategy']) && in_array('generalist',$requestFilters['vct-investment-strategy'])) checked @endif>
					  <label class="custom-control-label" for="ch_generalist">Generalist</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input filter-business-list" name="vct_investmentstrategy[]" id="ch_aim" value="aim" slug-val="aim" @if(isset($requestFilters['vct-investment-strategy']) && in_array('aim',$requestFilters['vct-investment-strategy'])) checked @endif>
					  <label class="custom-control-label" for="ch_aim">AIM</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input filter-business-list" name="vct_investmentstrategy[]" id="ch_specialist" value="specialist" slug-val="specialist" @if(isset($requestFilters['vct-investment-strategy']) && in_array('specialist',$requestFilters['vct-investment-strategy'])) checked @endif>
					  <label class="custom-control-label" for="ch_specialist">Specialist</label>
					</div>
	              
			</div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingFour">
	      <h5 class="mb-0">
	        <button class="btn btn-link  w-100 text-left" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
	         Offering Type
	        </button>
	      </h5>
	    </div>
	    <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
				 
                <div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="vct_offeringtype[]" id="ch_Approved_Fund" value="new offer" slug-val="new-offer" @if(isset($requestFilters['vct-offering-type']) && in_array('new-offer',$requestFilters['vct-offering-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_Approved_Fund">New Offer</label>
				</div>

				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="vct_offeringtype[]" id="ch_Unapproved_Fund" value="topup" slug-val="topup" @if(isset($requestFilters['vct-offering-type']) && in_array('topup',$requestFilters['vct-offering-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_Unapproved_Fund">Top-Up</label>
				</div>

				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="vct_offeringtype[]" id="ch_Managed_portfolio" value="multiple" slug-val="multiple" @if(isset($requestFilters['vct-offering-type']) && in_array('multiple',$requestFilters['vct-offering-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_Managed_portfolio">Multiple</label>
				</div>
	              
			</div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingThree">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
	          AIC Sector
	        </button>
	      </h5>
	    </div>
	    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
	        	 
               	@foreach($aicsector as $sectorId => $sector)
	                <div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input filter-business-list" name="aic_sector[]" id="ch_aic_{{ $sectorId }}" value="{{ $sectorId }}" slug-val="{{ str_slug($sector) }}" @if(isset($requestFilters['aic-sector']) && in_array(str_slug($sector),$requestFilters['aic-sector'])) checked @endif>
					  <label class="custom-control-label" for="ch_aic_{{ $sectorId }}">{{ ucfirst($sector) }}</label>
 
					</div>
	             @endforeach
				  
	             
				
			</div>
	      </div>
	    </div>
	  </div>
	  
	   
	   
	</div>
	<!-- /accordion -->

	<div class="card text-center p-3 mb-3 mb-sm-0">
		<div class="h1 mb-0"><i class="fa fa-phone"></i></h3></div>
		<h5>Need Help?</h5>
		<a href="" class="h3 card-link d-block">020 7071 3945</a>
		<div><p>Mail us at:<br><a class="card-link" href="mailto:enquiries@growthinvest.com">enquiries@growthinvest.com</a></p></div>
	</div>
	<input type="hidden" name="business_listing_type" value="{{ $business_listing_type }}">
</div>
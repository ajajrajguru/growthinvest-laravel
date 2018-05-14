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
	          Investment Type
	        </button>
	      </h5>
	    </div>

	    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_esis" value="eis" slug-val="all" @if(isset($requestFilters['investment-type']) && in_array('all',$requestFilters['investment-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_esis">EIS</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_sesis" value="seis" slug-val="seis" @if(isset($requestFilters['investment-type']) && in_array('seis',$requestFilters['investment-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_sesis">SEIS</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_combined" value="combined" slug-val="combined" @if(isset($requestFilters['investment-type']) && in_array('combined',$requestFilters['investment-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_combined">Combined</label>
				</div>
			 
			</div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingTwo">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
	          Due Diligence
	        </button>
	      </h5>
	    </div>
	    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
				@foreach($dueDeligence as $dueDeligenceValue)
	                <div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input filter-business-list" name="due_deligence[]" id="ch_{{ $dueDeligenceValue->id }}" value="{{ $dueDeligenceValue->id }}" slug-val="{{ $dueDeligenceValue->slug }}" @if(isset($requestFilters['due-diligence']) && in_array($dueDeligenceValue->slug,$requestFilters['due-diligence'])) checked @endif>
					  <label class="custom-control-label" for="ch_{{ $dueDeligenceValue->id }}">{{ ucfirst($dueDeligenceValue->name) }}</label>
					</div>
	             @endforeach
			</div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingThree">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
	          Sector Focus
	        </button>
	      </h5>
	    </div>
	    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
	        	@foreach($sectors as $sector)
	                <div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input filter-business-list" name="business_sector[]" id="ch_{{ $sector->id }}" value="{{ $sector->id }}" slug-val="{{ $sector->slug }}" @if(isset($requestFilters['business-sector']) && in_array($sector->slug,$requestFilters['business-sector'])) checked @endif>
					  <label class="custom-control-label" for="ch_{{ $sector->id }}">{{ ucfirst($sector->name) }}</label>
					</div>
	             @endforeach
				
			</div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingFour">
	      <h5 class="mb-0">
	        <button class="btn btn-link  w-100 text-left" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
	          Fund Regulatory Status
	        </button>
	      </h5>
	    </div>
	    <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
				 
                <div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="fund_type[]" id="ch_Approved_Fund" value="Approved_Fund" slug-val="approved-fund" @if(isset($requestFilters['fund-regulatory-status']) && in_array('approved-fund',$requestFilters['fund-regulatory-status'])) checked @endif>
				  <label class="custom-control-label" for="ch_Approved_Fund">Approved Fund</label>
				</div>

				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="fund_type[]" id="ch_Unapproved_Fund" value="Unapproved_Fund" slug-val="unapproved-fund" @if(isset($requestFilters['fund-regulatory-status']) && in_array('unapproved-fund',$requestFilters['fund-regulatory-status'])) checked @endif>
				  <label class="custom-control-label" for="ch_Unapproved_Fund">Unapproved Fund</label>
				</div>

				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="fund_type[]" id="ch_Managed_portfolio" value="managed-portfolio" slug-val="managed-portfolio" @if(isset($requestFilters['fund-regulatory-status']) && in_array('managed-portfolio',$requestFilters['fund-regulatory-status'])) checked @endif>
				  <label class="custom-control-label" for="ch_Managed_portfolio">Managed portfolio</label>
				</div>
	              
			</div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingFive">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
	          Open Status
	        </button>
	      </h5>
	    </div>
	    <div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
	        	 
                <div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="fund_status[]" id="ch_open" value="open" slug-val="open" @if(isset($requestFilters['fund-status']) && in_array('open',$requestFilters['fund-status'])) checked @endif>
				  <label class="custom-control-label" for="ch_open"> Single/Non Evergreen </label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="fund_status[]" id="ch_closed" value="closed" slug-val="closed" @if(isset($requestFilters['fund-status']) && in_array('closed',$requestFilters['fund-status'])) checked @endif>
				  <label class="custom-control-label" for="ch_closed"> Closed </label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="fund_status[]" id="ch_evergreen" value="evergreen" slug-val="evergreen" @if(isset($requestFilters['fund-status']) && in_array('evergreen',$requestFilters['fund-status'])) checked @endif>
				  <label class="custom-control-label" for="ch_evergreen"> Evergreen </label>
				</div>
	             
	        </div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingSix">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
	          Investment Focus
	        </button>
	      </h5>
	    </div>
	    <div id="collapseSix" class="collapse show" aria-labelledby="headingSix" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
	        	 
                <div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="fund_investmentobjective[]" id="ch_Capital_Preservation" value="Capital Preservation" slug-val="capital-preservation" @if(isset($requestFilters['investment-focus']) && in_array('capital-preservation',$requestFilters['investment-focus'])) checked @endif>
				  <label class="custom-control-label" for="ch_Capital_Preservation">Capital Preservation</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="fund_investmentobjective[]" id="ch_Mixed" value="Mixed (Preservation & Growth)" slug-val="mixed" @if(isset($requestFilters['investment-focus']) && in_array('mixed',$requestFilters['investment-focus'])) checked @endif>
				  <label class="custom-control-label" for="ch_Mixed"> Mixed </label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="fund_investmentobjective[]" id="ch_Growth" value="Growth" slug-val="growth" @if(isset($requestFilters['investment-focus']) && in_array('growth',$requestFilters['investment-focus'])) checked @endif>
				  <label class="custom-control-label" for="ch_Growth">  Growth </label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="fund_investmentobjective[]" id="ch_High Growth" value="High Growth" slug-val="high-growth" @if(isset($requestFilters['investment-focus']) && in_array('high-growth',$requestFilters['investment-focus'])) checked @endif>
				  <label class="custom-control-label" for="ch_High Growth">  High Growth </label>
				</div>
			 
	             
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
<div class="col-sm-3 mobile-filters slideIn pt-3 pt-sm-0 border-xs-right d-none d-sm-block">
	<div class="d-flex justify-content-between mb-3">
		<div class="text-uppercase">refine your search</div>
		<a href="javascript:void(0)" class="btn btn-primary btn-sm apply-investment-opportunity">Apply</a>
		<a href="javascript:void(0)" class="btn btn-sm btn-outline-primary reset-investment-opportunity">RESET</a>
	</div>
	<!-- accordion -->
	<div id="accordion" class="gi-collapse-2 pb-3">
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
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_all" value="all" slug-val="all" @if(isset($requestFilters['investment-type']) && in_array('all',$requestFilters['investment-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_all">All</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_esis" value="eis" slug-val="eis" @if(isset($requestFilters['investment-type']) && in_array('eis',$requestFilters['investment-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_esis">EIS Qualifying</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_sesis" value="seis" slug-val="seis" @if(isset($requestFilters['investment-type']) && in_array('seis',$requestFilters['investment-type'])) checked @endif >
				  <label class="custom-control-label" for="ch_sesis">SEIS Qualifying</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_tier1" value="tier1" slug-val="tier1" @if(isset($requestFilters['investment-type']) && in_array('tier1',$requestFilters['investment-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_tier1">Tier1 Visa</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_previously_funded" value="previously_funded" slug-val="previously-funded" @if(isset($requestFilters['investment-type']) && in_array('previously-funded',$requestFilters['investment-type'])) checked @endif>
				  <label class="custom-control-label" for="ch_previously_funded">Previously Funded</label>
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
	          Business Sector
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
	          Business Stage
	        </button>
	      </h5>
	    </div>
	    <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
				@foreach($stageOfBusiness as $stage)
	                <div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input filter-business-list" name="business_stage[]" id="ch_{{ $stage->id }}" value="{{ $stage->id }}" slug-val="{{ $stage->slug }}" @if(isset($requestFilters['business-stage']) && in_array($stage->slug,$requestFilters['business-stage'])) checked @endif>
					  <label class="custom-control-label" for="ch_{{ $stage->id }}">{{ ucfirst($stage->name) }}</label>
					</div>
	             @endforeach
			</div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingFive">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
	          % Funded
	        </button>
	      </h5>
	    </div>
	    <div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
	        	 
                <div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="funded_per[]" id="ch_below_25" value="below_25" slug-val="below_25" @if(isset($requestFilters['funded']) && in_array('below_25',$requestFilters['funded'])) checked @endif>
				  <label class="custom-control-label" for="ch_below_25"> Below 25% </label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="funded_per[]" id="ch_25_50" value="25_50" slug-val="25_50" @if(isset($requestFilters['funded']) && in_array('25_50',$requestFilters['funded'])) checked @endif>
				  <label class="custom-control-label" for="ch_25_50"> 25% to 50% </label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="funded_per[]" id="ch_50_75" value="50_75" slug-val="50_75" @if(isset($requestFilters['funded']) && in_array('50_75',$requestFilters['funded'])) checked @endif>
				  <label class="custom-control-label" for="ch_50_75"> 50% to 75% </label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="funded_per[]" id="ch_75_above" value="75_above" slug-val="75_above" @if(isset($requestFilters['funded']) && in_array('75_above',$requestFilters['funded'])) checked @endif>
				  <label class="custom-control-label" for="ch_75_above"> 75% and Above </label>
				</div>
	             
	        </div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingSix">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
	          Investment Sought
	        </button>
	      </h5>
	    </div>
	    <div id="collapseSix" class="collapse show" aria-labelledby="headingSix" data-parent="">
	      <div class="card-body ">
	        <div class="filter-options">
	        	 
                <div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="investment_sought[]" id="ch_below_250k" value="below_250k" slug-val="below_250k" @if(isset($requestFilters['investment-sought']) && in_array('below_250k',$requestFilters['investment-sought'])) checked @endif>
				  <label class="custom-control-label" for="ch_below_250k">< £250k </label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="investment_sought[]" id="ch_251k_500k" value="251k_500k"  slug-val="251k_500k" @if(isset($requestFilters['investment-sought']) && in_array('251k_500k',$requestFilters['investment-sought'])) checked @endif>
				  <label class="custom-control-label" for="ch_251k_500k"> £251k - £500k </label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="investment_sought[]" id="ch_501k_1m" value="501k_1m"  slug-val="501k_1m" @if(isset($requestFilters['investment-sought']) && in_array('501k_1m',$requestFilters['investment-sought'])) checked @endif>
				  <label class="custom-control-label" for="ch_501k_1m">  £501k - £1m </label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="investment_sought[]" id="ch_1m_above" value="1m_above" slug-val="1m_above" @if(isset($requestFilters['investment-sought']) && in_array('1m_above',$requestFilters['investment-sought'])) checked @endif>
				  <label class="custom-control-label" for="ch_1m_above"> > £1m </label>
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
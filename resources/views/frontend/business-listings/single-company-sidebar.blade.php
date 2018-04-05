<div class="col-sm-3">
	<div class="d-flex justify-content-between mb-3">
		<div class="text-uppercase">refine your search</div>
		<a href="" class="btn btn-sm btn-outline-primary">RESET</a>
	</div>
	<!-- accordion -->
	<div id="accordion" class="gi-collapse-2">
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingOne">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
	          Investment Type
	        </button>
	      </h5>
	    </div>

	    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
	      <div class="card-body ">
	        <div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_all" value="all">
				  <label class="custom-control-label" for="ch_all">All</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_esis" value="eis" >
				  <label class="custom-control-label" for="ch_esis">EIS Qualifying</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_sesis" value="seis">
				  <label class="custom-control-label" for="ch_sesis">SEIS Qualifying</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_tier1" value="tier1">
				  <label class="custom-control-label" for="ch_tier1">Tier1 Visa</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input filter-business-list" name="tax_status[]" id="ch_previously_funded" value="previously_funded">
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
	    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
	      <div class="card-body ">
	        <div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch2">
				  <label class="custom-control-label" for="ch3">Generalist</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch4" >
				  <label class="custom-control-label" for="ch4">AIM</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch5" >
				  <label class="custom-control-label" for="ch5">Specialist</label>
				</div>
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
	    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
	      <div class="card-body ">
	        <div>
	        	@foreach($sectors as $sector)
	                <div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input filter-business-list" name="business_sector[]" id="ch_{{ $sector->id }}" value="{{ $sector->id }}">
					  <label class="custom-control-label" for="ch_{{ $sector->id }}">{{ ucfirst($sector->name) }}</label>
					</div>
	             @endforeach
				
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch7" >
				  <label class="custom-control-label" for="ch7">Top-Up</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch8" >
				  <label class="custom-control-label" for="ch8">Multiple</label>
				</div>
			</div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingFour">
	      <h5 class="mb-0">
	        <button class="btn btn-link  w-100 text-left" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
	          AIC Sector
	        </button>
	      </h5>
	    </div>
	    <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordion">
	      <div class="card-body ">
	        <div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch9">
				  <label class="custom-control-label" for="ch9">Generalist</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch10" >
				  <label class="custom-control-label" for="ch10">Generalist Pre-Qualifying</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch11" >
				  <label class="custom-control-label" for="ch11">AIM Quoted</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch12">
				  <label class="custom-control-label" for="ch12">Specialist Environmental</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch13" >
				  <label class="custom-control-label" for="ch13">Specialist Technology</label>
				</div>
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="ch14" >
				  <label class="custom-control-label" for="ch14">Specialist Infrastructure</label>
				</div>
			</div>
	      </div>
	    </div>
	  </div>
	  <div class="card rounded-0">
	    <div class="card-header p-0" id="headingFive">
	      <h5 class="mb-0">
	        <button class="btn btn-link w-100 text-left" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
	          Fund Manager
	        </button>
	      </h5>
	    </div>
	    <div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="#accordion">
	      <div class="card-body ">
	        <div class="">
	        	<select name="" id="" class="form-control">
	        		<option value="">1</option>
	        		<option value="">2</option>
	        		<option value="">3</option>
	        	</select>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- /accordion -->
	<input type="hidden" name="business_listing_type" value="{{ $business_listing_type }}">
</div>
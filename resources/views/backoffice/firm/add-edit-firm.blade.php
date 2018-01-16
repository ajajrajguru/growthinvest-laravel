@extends('layouts.backoffice')

@section('js')
  @parent

  <script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
  <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js" onload="loadCkeditor();"></script>

@endsection

@section('backoffice-content')

<div class="container">

	@php
        echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
    @endphp

	<div class="mt-4 bg-white border border-gray p-4">
		<h1 class="section-title font-weight-medium text-primary mb-0">Add Firm</h1>

		<div class="p-4">

			 <form method="post" action="{{ url('backoffice/firms/save-firm') }}"   data-parsley-validate  name="form-add-edit-firm" id="form-add-edit-firm" enctype="multipart/form-data">

				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Firm Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="" name="name" value="{{$firm->name}}"  data-parsley-required data-parsley-required-message="Please enter Firm Name" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>FCA Firm Reference Number</label>
							<input type="text" class="form-control" placeholder="" name="fca_ref_no" value="{{$firm->fca_ref_no}}" >
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control"  name="description" value="{{$firm->description}}" ></textarea>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<fieldset>
							<legend>Firm Address</legend>
							<div class="form-group">
								<label>Address Line 1 <span class="text-danger">*</span></label>
								<textarea class="form-control" name="address1" value="{{$firm->address1}}"  data-parsley-required data-parsley-required-message="Please enter Address 1" ></textarea>
							</div>
							<div class="form-group">
								<label>Address Line 2</label>
								<textarea class="form-control" name="address2" value="{{$firm->address2}}" ></textarea>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Town/City</label>
										<input type="text" class="form-control" placeholder="" name="town" value="{{$firm->town}}" >
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>County</label>
										<select class="form-control" name="county" value="{{$firm->county}}" >
											<option value="">Please Select</option>
											@php
			                                $countyName = '';
			                                @endphp
			                                @foreach($countyList as $county)
			                                    @php
			                                    if($firm->county == $county)
			                                        $countyName = $county;

			                                    @endphp
			                                    <option value="{{ $county }}" @if($firm->county == $county) selected @endif>{{ $county }}</option>
			                                @endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Postcode <span class="text-danger">*</span></label>
										<input type="text" class="form-control" placeholder=""  name="postcode" value="{{$firm->postcode}}"  data-parsley-required data-parsley-required-message="Please enter Postcode"  >
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Country</label>
										<select class="form-control"  name="country" value="{{$firm->country}}" >
											<option value="">Please Select</option>
											@php
			                                $countryName = '';
			                                @endphp
			                                @foreach($countryList as $code=>$country)
			                                    @php
			                                    if($firm->country == $code)
			                                        $countryName = $country;

			                                    @endphp
			                                    <option value="{{ $code }}" @if($firm->country == $code) selected @endif>{{ $country }}</option>
			                                @endforeach
										</select>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="" name="pri_contactname" value="{{$firm->pri_contactname}}" data-parsley-required data-parsley-required-message="Please enter Primary Contact Name">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact’s FCA Number </label>
							<input type="text" class="form-control" placeholder="" name="pri_contactfcano" value="{{$firm->pri_contactfcano}}">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact Email Address <span class="text-danger">*</span></label>
							<input type="email" class="form-control" placeholder=""  name="pri_contactemail" value="{{$firm->pri_contactemail}}" data-parsley-required data-parsley-required-message="Please enter Primary Contact Email">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact Phone Number <span class="text-danger">*</span></label>
							<input type="tel" class="form-control" placeholder=""   name="pri_contactphoneno" value="{{$firm->pri_contactphoneno}}" data-parsley-required data-parsley-required-message="Please enter Primary Contact Phone No">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Firm Type </label>
							<select class="form-control"  name="type" value="{{$firm->type}}">
								<option value="">Please Select</option>
								@php
                                $firmtypeName = '';
                                @endphp
                                @foreach($firm_types as $firm_type)
                                    @php
                                    if($firm->type == $firm_type->id)
                                        $firmtypeName = $firm_type->name;


                                    @endphp
                                <option value="{{ $firm_type->id }}" @if($firm->type == $firm_type->id) selected @endif>{{ $firm_type->name }}</option>
                                @endforeach

							</select>
							<small>Please contact the GrowthInvest team to amend your firm type to add investors, entrepreneurs or other intermediaries</small>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Parent Firm </label>
							<select class="form-control" name="parent_id" value="{{$firm->parent_id}}">
								<option value="">Please Select</option>
								@php
                                $firmName = '';
                                @endphp
                                @foreach($network_firms as $firm)
                                    @php
                                    if($firm->parent_id == $firm->id)
                                        $firmName = $firm->name;


                                    @endphp
                                <option value="{{ $firm->id }}" @if($firm->parent_id == $firm->id) selected @endif>{{ $firm->name }}</option>
                                @endforeach
							</select>
						</div>
					</div>
				</div>

				<div id="" role="tablist" class="gi-collapse">
				  <div class="card">
				    <div class="card-header" role="tab" id="headingOne">
				        <a data-toggle="collapse" href="#financials" role="button">
				          Financials
				          <i class="fa fa-lg fa-plus-square-o"></i>
				          <i class="fa fa-lg fa-minus-square-o"></i>
				        </a>
				    </div>

				    <div id="financials" class="collapse show" role="tabpanel" >
				    	<div class="card-body">
				      		<div class="row">
				      			<div class="col-md-3">
				      				<div class="form-group">
				      					<label>WM Commission %</label>
				      					<div class="input-group">
				      						<input type="text" class="form-control" placeholder="" name="wm_commission" value="{{$firm->wm_commission}}">
				      						<div class="input-group-append">
				      							<span class="input-group-text">%</span>
				      						</div>
				      					</div>
				      				</div>
				      			</div>
				      			<div class="col-md-3">
				      				<div class="form-group">
				      					<label>Introducer Commission %</label>
				      					<div class="input-group">
				      						<input type="text" class="form-control" placeholder="" name="introducer_commission" value="{{$firm->introducer_commission}}">
				      						<div class="input-group-append">
				      							<span class="input-group-text">%</span>
				      						</div>
				      					</div>
				      				</div>
				      			</div>
				      		</div>
				    	</div>
				    </div>
				  </div>
				  <div class="card">
				    <div class="card-header" role="tab" id="headingTwo">
				        <a class="" data-toggle="collapse" href="#invitations" role="button">
				        	Invitations
				        	<i class="fa fa-lg fa-plus-square-o"></i>
				        	<i class="fa fa-lg fa-minus-square-o"></i>
				        </a>
				    </div>
				    <div id="invitations" class="collapse show" role="tabpanel">
				    	<div class="card-body">
				    		<div class="row mb-4">
				    			<div class="col-md-3">
				    				<label>Entrepreneur invite content</label>
				    			</div>
				    			<div class="col-md-9">
				    				<textarea class="rich-editor" name="ent_invite_content" value="{{$firm->ent_invite_content}}"></textarea>
				    			</div>
				    		</div>

				    		<div class="row mb-4">
				    			<div class="col-md-3">
				    				<label>Investor invite content</label>
				    			</div>
				    			<div class="col-md-9">
				    				<textarea class="rich-editor"  name="inv_invite_content" value="{{$firm->inv_invite_content}}"></textarea>
				    			</div>
				    		</div>

				    		<div class="row mb-4">
				    			<div class="col-md-3">
				    				<label>Fund Manager invite content</label>
				    			</div>
				    			<div class="col-md-9">
				    				<textarea class="rich-editor"  name="fundmanager_invite_content" value="{{$firm->fundmanager_invite_content}}"></textarea>
				    			</div>
				    		</div>
				    	</div>
				    </div>
				  </div>
				</div>

				<div class="row mb-4">
					<div class="col-md-3">
						<label>Logo</label>
					</div>
					<div class="col-md-3">
						<input type="hidden" name="logoid" value="" />
					</div>
				</div>

				<div class="row mb-4">
					<div class="col-md-3">
						<label>Background Image</label>
					</div>
					<div class="col-md-3">

						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="imgFrontEnd" name="frontend_display" >
							<label class="form-check-label" for="imgFrontEnd">
						    	Display Image for Frontend Users
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="imgBackEnd" name="backend_display" >
							<label class="form-check-label" for="imgBackEnd">
						    	Display Image for Backend Users
							</label>
						</div>
						<input type="hidden" name="backgroundid" value="" />
					</div>
				</div>



				<button type="submit" class="btn btn-primary mt-3">Save</button>
				<button type="button" class="btn btn-secondary mt-3">Cancel</button>

			</form>
		</div>
	</div>

</div>

<script type="text/javascript">


	 function loadCkeditor(){
		// CKEDITOR.replace( 'rich-editor' );
		// CKEDITOR.replaceClass('rich-editor');
		var elements = CKEDITOR.document.find( '.rich-editor' ),
		    i = 0,
		    element;

		while ( ( element = elements.getItem( i++ ) ) ) {
		    CKEDITOR.replace( element );
		}
	}



</script>




@endsection

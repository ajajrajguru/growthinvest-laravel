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

    @include('includes.notification')

	<div class="mt-4 bg-white border border-gray p-4">
		<!-- <h1 class="section-title font-weight-medium text-primary mb-0">Add Firm</h1> -->
		<div class="row">
		    <div class="col-6">
		        <h1 class="section-title font-weight-medium text-primary mb-0">@if($firm->id) Edit 
		        @else Add @endif Firm</h1> 
		    </div>
		    <div class="col-6">
		    @if($firm->id)
		    	<div class="float-right">
			        <a href="javascript:void(0)" class="btn btn-primary editFirmBtn">Edit Details</a>
			        <a href="javascript:void(0)" class="btn btn-primary d-none cancelFirmUpdateBtn">Cancel Updates</a>
		        </div>
		    @endif
		    </div>
		</div>

		<div class="p-4">

			 <form method="post" action="{{ url('backoffice/firms/save-firm') }}"   data-parsley-validate  name="form-add-edit-firm" id="form-add-edit-firm" enctype="multipart/form-data">

				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Firm Name <span class="text-danger reqField @if($mode=='view') d-none @endif"">*</span></label>
							<input type="text" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder="" name="name" value="{{$firm->name}}"  data-parsley-required data-parsley-required-message="Please enter Firm Name" >
							<div class="viewmode @if($mode=='edit') d-none @endif">{{$firm->name}}</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>FCA Firm Reference Number</label>
							<input type="text" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder="" name="fca_ref_no" value="{{$firm->fca_ref_no}}" >
							<div class="viewmode @if($mode=='edit') d-none @endif">{{$firm->fca_ref_no}}</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control editmode @if($mode=='view') d-none @endif""  name="description">{{$firm->description}}</textarea>
							<div class="viewmode @if($mode=='edit') d-none @endif">{{$firm->description}}</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<fieldset>
							<legend>Firm Address</legend>
							<div class="form-group">
								<label>Address Line 1 <span class="text-danger reqField @if($mode=='view') d-none @endif"">*</span></label>
								<textarea class="form-control editmode @if($mode=='view') d-none @endif"" name="address1" data-parsley-required data-parsley-required-message="Please enter Address 1" >{{$firm->address1}}</textarea>
								<div class="viewmode @if($mode=='edit') d-none @endif">{{$firm->address1}}</div>
							</div>
							<div class="form-group">
								<label>Address Line 2</label>
								<textarea class="form-control editmode @if($mode=='view') d-none @endif"" name="address2">{{$firm->address2}}</textarea>
								<div class="viewmode @if($mode=='edit') d-none @endif">{{$firm->address2}}</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Town/City</label>
										<input type="text" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder="" name="town" value="{{$firm->town}}" >
										<div class="viewmode @if($mode=='edit') d-none @endif">{{$firm->town}}</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>County</label>
										<select class="form-control editmode @if($mode=='view') d-none @endif"" name="county" value="{{$firm->county}}" >
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
										<div class="viewmode @if($mode=='edit') d-none @endif">{{ $countyName}}</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Postcode <span class="text-danger  @if($mode=='view') d-none @endif"">*</span></label>
										<input type="text" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder=""  name="postcode" value="{{$firm->postcode}}"  data-parsley-required data-parsley-required-message="Please enter Postcode"  >
										<div class="viewmode @if($mode=='edit') d-none @endif">{{$firm->postcode}}</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Country</label>
										<select class="form-control editmode @if($mode=='view') d-none @endif""  name="country" value="{{$firm->country}}" >
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
										<div class="viewmode @if($mode=='edit') d-none @endif">{{ $countryName }}</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact Name <span class="text-danger reqField @if($mode=='view') d-none @endif"">*</span></label>
							<input type="text" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder="" name="pri_contactname" value="{{ (isset($additional_details['pri_contactname'])) ? $additional_details['pri_contactname'] : ''}}" data-parsley-required data-parsley-required-message="Please enter Primary Contact Name">
							<div class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($additional_details['pri_contactname'])) ? $additional_details['pri_contactname'] : ''}}</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact’s FCA Number </label>
							<input type="text" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder="" name="pri_contactfcano" value="{{ (isset($additional_details['pri_contactfcano'])) ? $additional_details['pri_contactfcano'] : ''}}">
							<div class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($additional_details['pri_contactfcano'])) ? $additional_details['pri_contactfcano'] : ''}}</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact Email Address <span class="text-danger reqField @if($mode=='view') d-none @endif"">*</span></label>
							<input type="email" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder=""  name="pri_contactemail" value="{{ (isset($additional_details['pri_contactemail'])) ? $additional_details['pri_contactemail'] : ''}}" data-parsley-required data-parsley-required-message="Please enter Primary Contact Email">
							<div class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($additional_details['pri_contactemail'])) ? $additional_details['pri_contactemail'] : ''}}</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact Phone Number <span class="text-danger reqField @if($mode=='view') d-none @endif"">*</span></label>
							<input type="tel" class="form-control editmode @if($mode=='view') d-none @endif"" name="pri_contactphoneno" value="{{ (isset($additional_details['pri_contactphoneno'])) ? $additional_details['pri_contactphoneno'] : ''}}" data-parsley-required data-parsley-type="number" placeholder="Eg: 020 7071 3945" data-parsley-required-message="Please enter Primary Contact Phone No">
							<div class="viewmode @if($mode=='edit') d-none @endif">{{ (isset($additional_details['pri_contactphoneno'])) ? $additional_details['pri_contactphoneno'] : ''}}</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Firm Type <span class="text-danger reqField @if($mode=='view') d-none @endif"">*</span></label>
							<select class="form-control editmode @if($mode=='view') d-none @endif""  name="type" value="{{$firm->type}}"  data-parsley-required data-parsley-required-message="Please select firm type" >
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
							<div class="viewmode @if($mode=='edit') d-none @endif">{{ $firmtypeName}}</div>
							<small class="editmode @if($mode=='view') d-none @endif">Please contact the GrowthInvest team to amend your firm type to add investors, entrepreneurs or other intermediaries</small>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Parent Firm </label>
							<select class="form-control editmode @if($mode=='view') d-none @endif" name="parent_id" value="{{$firm->parent_id}}">
								<option value="">Please Select</option>
								@php
                                $n_firmName = '';
                                @endphp
                                @foreach($network_firms as $n_firm)
                                    @php
                                    if($firm->parent_id == $n_firm->id)
                                        $n_firmName = $n_firm->name;


                                    @endphp
                                <option value="{{ $n_firm->id }}" @if($firm->parent_id == $n_firm->id) selected @endif>{{ $n_firm->name }}</option>
                                @endforeach
							</select>
							<div class="viewmode @if($mode=='edit') d-none @endif">{{ $n_firmName}}</div>
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
				      						<input type="text" class="form-control editmode @if($mode=='view') d-none @endif" placeholder="" name="wm_commission" value="{{$firm->wm_commission}}" data-parsley-type="number" >
				      						<div class="input-group-append percentlbl @if($mode=='view') d-none @endif">
				      							<span class="input-group-text">%</span>
				      						</div>
				      						<span class="viewmode @if($mode=='edit') d-none @endif">{{$firm->wm_commission}}%</span>
				      					</div>
				      				</div>
				      			</div>
				      			<div class="col-md-3">
				      				<div class="form-group">
				      					<label>Introducer Commission %</label>
				      					<div class="input-group">
				      						<input type="text" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder="" name="introducer_commission" value="{{$firm->introducer_commission}}" data-parsley-type="number" >
				      						<div class="input-group-append  percentlbl @if($mode=='view') d-none @endif">
				      							<span class="input-group-text">%</span>
				      						</div>
				      						<span class="viewmode @if($mode=='edit') d-none @endif">{{$firm->introducer_commission}}%</span>
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

				    	@if($firm->id)
				    	<div class="form-group mt-4">
								<label>Investor Invite Link</label>
								<input type="text" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder="" name="inv_invite_link" value="http://seedtwin.ajency.in/register/?{{$firm->invite_key}}#investor" disabled>
								<div class="viewmode @if($mode=='edit') d-none @endif">http://seedtwin.ajency.in/register/?{{$firm->invite_key}}#investor</div>
						</div>
						<div class="form-group">
								<label>Entrepreneur Invite Link</label>
								<input type="text" class="form-control editmode @if($mode=='view') d-none @endif"" placeholder="" name="ent_invite_link" value="http://seedtwin.ajency.in/register/?{{$firm->invite_key}}#businessowner" disabled>
								<div class="viewmode @if($mode=='edit') d-none @endif">http://seedtwin.ajency.in/register/?{{$firm->invite_key}}#businessowner</div>
						</div>
						@endif
						
						<input type="hidden" name="invite_key" value="{{$firm->invite_key}}" />

				    	<div class="card-body">
				    		<div class="row mb-4">
				    			<div class="col-md-3">
				    				<label>Entrepreneur invite content</label>
				    			</div>
				    			<div class="col-md-9">
				    				<textarea class="rich-editor editmode @if($mode=='view') d-none @endif"" name="ent_invite_content" >{{ (isset($invite_content['ent_invite_content'])) ? $invite_content['ent_invite_content'] : ''}}</textarea>
				    				<span class="viewmode @if($mode=='edit') d-none @endif @if($mode!='edit') scrollable @endif">{{ (isset($invite_content['ent_invite_content'])) ? $invite_content['ent_invite_content'] : ''}}</span>
				    			</div>
				    		</div>

				    		<div class="row mb-4">
				    			<div class="col-md-3">
				    				<label>Investor invite content</label>
				    			</div>
				    			<div class="col-md-9">
				    				<textarea class="rich-editor editmode @if($mode=='view') d-none @endif""  name="inv_invite_content"  >{{ (isset($invite_content['inv_invite_content'])) ? $invite_content['inv_invite_content'] : ''}}</textarea>
				    				<span class="viewmode @if($mode=='edit') d-none @endif @if($mode!='edit') scrollable @endif">{{ (isset($invite_content['inv_invite_content'])) ? $invite_content['inv_invite_content'] : ''}}</span>
				    			</div>
				    		</div>

				    		<div class="row mb-4">
				    			<div class="col-md-3">
				    				<label>Fund Manager invite content</label>
				    			</div>
				    			<div class="col-md-9">
				    				<textarea class="rich-editor editmode @if($mode=='view') d-none @endif""  name="fundmanager_invite_content" >{{ (isset($invite_content['fundmanager_invite_content'])) ? $invite_content['fundmanager_invite_content'] : ''}}</textarea>
				    				<span class="viewmode @if($mode=='edit') d-none @endif @if($mode!='edit') scrollable @endif">{{ (isset($invite_content['fundmanager_invite_content'])) ? $invite_content['fundmanager_invite_content'] : ''}}</span>
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
						<input type="hidden" name="logoid" value="{{$firm->logoid}}" />
					</div>
				</div>

				<div class="row mb-4">
					<div class="col-md-3">
						<label>Background Image</label>
					</div>
					<div class="col-md-3">

						<div class="form-check">
							<input class="form-check-input editmode @if($mode=='view') d-none @endif"" type="checkbox" value="1" id="imgFrontEnd" name="frontend_display" @if($firm->frontend_display) checked @endif >
							<label class="form-check-label" for="imgFrontEnd">
						    	Display Image for Frontend Users
							</label>
							<span class="viewmode @if($mode=='edit') d-none @endif">{{ ($firm->frontend_display) ?  'Yes' : 'No' }}</span>
						</div>
						<div class="form-check">
							<input class="form-check-input editmode @if($mode=='view') d-none @endif"" type="checkbox" value="1"  @if($firm->backend_display) checked @endif id="imgBackEnd" name="backend_display" >
							<label class="form-check-label" for="imgBackEnd">
						    	Display Image for Backend Users
							</label>
							<span class="viewmode @if($mode=='edit') d-none @endif">{{ ($firm->backend_display) ?  'Yes' : 'No' }}</span>
						</div>
						<input type="hidden" name="backgroundid" value="{{$firm->backgroundid}}" />
					</div>
				</div>
				<input type="hidden" name="blog" value="{{$firm->blog}}"/>



				<button type="submit" class="btn btn-primary mt-3">Save</button>
				<button type="button" class="btn btn-secondary mt-3">Cancel</button>

			</form>
		</div>
	</div>

</div>

<script type="text/javascript">

	<?php if($firm->id){
		 
		echo "var edit_mode = 'yes' ";
	} 
	else{
		echo "var edit_mode = 'no' ";	
	}
	?>

	 function loadCkeditor(){  
		// CKEDITOR.replace( 'rich-editor' );
		// CKEDITOR.replaceClass('rich-editor');
		var elements = CKEDITOR.document.find( '.rich-editor' ),
		    i = 0,
		    element;

		while ( ( element = elements.getItem( i++ ) ) ) {			

			var t = element.InnerText ;

		    var inst = CKEDITOR.replace( element );
		    inst.setData(t)

		}

 		setTimeout(function(){ 
 			 

 			if(edit_mode=="yes"){
 				$('#cke_ent_invite_content').addClass('d-none')
 				$('#cke_inv_invite_content').addClass('d-none')
 				$('#cke_fundmanager_invite_content').addClass('d-none')
 			}
 			 

 		 }, 2000);


	}



</script>




@endsection

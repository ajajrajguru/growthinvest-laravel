@extends('layouts.backoffice')

@section('js')
  @parent
 
  <script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
    
@endsection

@section('backoffice-content') 

<div class="container">

	@php
        echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
    @endphp

	<div class="mt-4 bg-white border border-gray p-4">
		<h1 class="section-title font-weight-medium text-primary mb-0">Add Firm</h1>

		<div class="p-4">

			<form>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Firm Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>FCA Firm Reference Number</label>
							<input type="text" class="form-control" placeholder="">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control"></textarea>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<fieldset>
							<legend>Firm Address</legend>
							<div class="form-group">
								<label>Address Line 1 <span class="text-danger">*</span></label>
								<textarea class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label>Address Line 2</label>
								<textarea class="form-control"></textarea>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Town/City</label>
										<input type="text" class="form-control" placeholder="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>County</label>
										<select class="form-control">
											<option>Please Select</option>
											<option>County 1</option>
											<option>County 2</option>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Postcode <span class="text-danger">*</span></label>
										<input type="text" class="form-control" placeholder="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Country</label>
										<select class="form-control">
											<option>Please Select</option>
											<option>India</option>
											<option>USA</option>
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
							<input type="text" class="form-control" placeholder="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact’s FCA Number </label>
							<input type="text" class="form-control" placeholder="">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact Email Address <span class="text-danger">*</span></label>
							<input type="email" class="form-control" placeholder="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Primary Contact Phone Number <span class="text-danger">*</span></label>
							<input type="tel" class="form-control" placeholder="">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Firm Type </label>
							<select class="form-control">
								<option>Please Select</option>
								<option>Accountant</option>
								<option>Legal</option>
							</select>
							<small>Please contact the GrowthInvest team to amend your firm type to add investors, entrepreneurs or other intermediaries</small>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Parent Firm </label>
							<select class="form-control">
								<option>Please Select</option>
								<option>88</option>
								<option>AV Trinity</option>
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
				      						<input type="text" class="form-control" placeholder="">
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
				      						<input type="text" class="form-control" placeholder="">
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
				    				<textarea class="rich-editor"></textarea>
				    			</div>
				    		</div>

				    		<div class="row mb-4">
				    			<div class="col-md-3">
				    				<label>Investor invite content</label>
				    			</div>
				    			<div class="col-md-9">
				    				<textarea class="rich-editor"></textarea>
				    			</div>
				    		</div>

				    		<div class="row mb-4">
				    			<div class="col-md-3">
				    				<label>Fund Manager invite content</label>
				    			</div>
				    			<div class="col-md-9">
				    				<textarea class="rich-editor"></textarea>
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

					</div>
				</div>

				<div class="row mb-4">
					<div class="col-md-3">
						<label>Background Image</label>
					</div>
					<div class="col-md-3">

						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="imgFrontEnd">
							<label class="form-check-label" for="imgFrontEnd">
						    	Display Image for Frontend Users
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="imgBackEnd">
							<label class="form-check-label" for="imgBackEnd">
						    	Display Image for Backend Users
							</label>
						</div>
					</div>
				</div>



				<button type="submit" class="btn btn-primary mt-3">Save</button>
				<button type="button" class="btn btn-secondary mt-3">Cancel</button>

			</form>
		</div>
	</div>

</div>

<script type="text/javascript">
	  // CKEDITOR.replace( 'rich-editor' );
	  // CKEDITOR.replaceClass('rich-editor');
	  var elements = CKEDITOR.document.find( '.rich-editor' ),
	      i = 0,
	      element;

	  while ( ( element = elements.getItem( i++ ) ) ) {
	      CKEDITOR.replace( element );
	  }
</script>
 



@endsection
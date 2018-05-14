@extends('layouts.frontend')

 
@section('js')
  @parent

  <script type="text/javascript" src="{{ asset('js/business-proposals.js') }}"></script>

@endsection
@section('frontend-content')


<div class="container pb-5">

<!-- mobile filter --> 
<div class="mobile-filter-btn rounded-circle pulse d-md-none"> 
	<i class="fa fa-filter"></i> 
</div> 
<!-- /mobile filter -->

 
	<div class="row mt-5">
		 			
		<div class="col-sm-3">
			<h3>Business Proposal</h3>

           

        </div>

        <div class="col-sm-9">
        	
		<p>To begin the process of getting your business proposal live on the site and visible to the wider Platform network of investors, please start by answering the questionnaires below, and providing us with as much information as possible. If you are able to complete all sections, and provide us with the required documents such as your business plan, that is great news. However, if you are not yet that far down the line, or have some questions on the best way to answer questions, please do not worry: Simply fill out the top Business Idea section, and we will review and get back to you within 2 working days. Our team is ready to help take you right through the process of getting your business proposal Investment Ready.<br>

		Once we have the information we need, we can kick off the next stage of the process, which is to select an appropriate Due Diligence tier, before your Business proposal goes live.<br>

		If you have any questions or queries, please do not hesitate to contact us at any time on Email support@growthinvest.com, phone 020 7071 3945, or via our online form here</p>
 		
 		<form method="post" data-parsley-validate name="add-business" id="add-business" enctype="multipart/form-data">
		<div id="" role="tablist" class="gi-collapse">
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" href="#collapse1" role="button">
                        <span class="px-0 col-md-10 col-8">
                            Business Idea
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">

                            <small class="mr-sm-3 mr-0 d-block d-md-inline-block section1-status"></small>
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            <input type="hidden" name="section_status[1]" class="section1-status-input sectionstatus-input" value="">
                        </span>
                    </a>
                </div>

                <div id="collapse1" class="collapse show parent-tabpanel" role="tabpanel" data-section='1' >
                    <div class="card-body">
                        <div class="row">
                        	<p>In order for us to assess your business proposition and match you with possible investors it is important that you complete the following sections as articulately and accurately as possible.</p>
                            <div class="col-sm-12">
                                 

                                <div class="form-group">
                                    <label>Please describe your business</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="aboutbusiness" placeholder="" ></textarea>
                                    <small class="form-text text-muted">Please describe your business in less than 100</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>What stage is the business at?</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="businessstage" placeholder="" ></textarea>
                                    <small class="form-text text-muted">Please explain in less than 300 word, what stage is the Business at? Ex: The business produced it’s first prototypeproduct in March 2014, spent the summer testing this on potential customers and started trading in November 2014</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Funding to this point</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="businessfunded" placeholder="" ></textarea>
                                    <small class="form-text text-muted">Please explain in less then 100 words, how has the business been funded to date? Ex loans/equity/grants – how much?</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Has the business generated any income/turnover so far? If so, how much?</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="incomegenerated" placeholder="" ></textarea>
                                    <small class="form-text text-muted">Has the business generated any income/turnover so far? If so, how much?</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Please summarize the team</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="aboutteam" placeholder="" ></textarea>
                                    <small class="form-text text-muted">Please summarize your Team. Each member in less than 250 words.</small>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Please summarize the market/industry</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="marketscope" placeholder="" ></textarea>
                                    <small class="form-text text-muted">Please summarize the market/industry in less than 300 words.</small>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Please describe your exit strategy</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="exit_strategy" placeholder="" ></textarea>
                                    <small class="form-text text-muted">Please describe your exit strategy in less than 450 words.</small>
                                    
                                </div>

                                 
                                <button type="button" class="btn btn-primary text-right editmode @if($mode=='view') d-none @endif save-section" submit-type="business_idea" >Save</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" role="tab" id="headingTwo">
                    <a data-toggle="collapse" href="#collapse2" role="button">
                        <span class="px-0 col-md-10 col-8">
                           Business Proposal Details
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">

                            <small class="mr-sm-3 mr-0 d-block d-md-inline-block section1-status"></small>
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            <input type="hidden" name="section_status[1]" class="section1-status-input sectionstatus-input" value="">
                        </span>
                    </a>
                </div>

                <div id="collapse2" class="collapse parent-tabpanel" role="tabpanel" data-section='2' >
                    <div class="card-body">
                        <div class="row">
                        	 
                            <div class="col-sm-12">
                                 

                                <div class="form-group">
                                    <label>Trading Name<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                    <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="title" placeholder="" data-parsley-required data-parsley-required-message="Please enter the trading name." value="">
                                     
                                    <small class="form-text text-muted">This is the name under which you market your company and the display name of a proposal - Eg. GrowthInvest</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Business Proposal Round<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                   <select type="text" name="proposal_round" id="proposal_round" placeholder="" class="form-control" data-parsley-required data-parsley-required-message="Please select business proposal round." >                         
	                                   	<option value=""> Select Business Proposal  Round  </option>                                                                 
	                                   	<option value="1">1st Round</option>                                                                                      
	                                   	<option value="2">2nd Round</option>                                                         
	                                   	<option value="3">3rd Round</option>                                                              
	                                   	<option value="4">4th Round</option>                                                         
	                                   	<option value="5">5th Round</option>                                                         
	                                   	<option value="6">6th Round</option>                                                          
	                                   	<option value="7">7th Round</option>                                                          
	                                   	<option value="8">8th Round</option>                                                         
	                                   	<option value="9">9th Round</option>                                                       
	                                   	<option value="10">10th Round</option>                                                                              
                                   </select>
                                    <small class="form-text text-muted">This is the Funding Round for your Business Proposal on GrowthInvest.</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Elevator pitch</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="business_proposal_details" placeholder="" ></textarea>
                                    <small class="form-text text-muted">Briefly describe your business in no more than 450 characters</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Company Name</label>
                                     <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="tradingname" placeholder="" value="">
                                    <small class="form-text text-muted">Has the business generated any income/turnover so far? If so, how much?</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Registered Address<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="address" placeholder="" ></textarea>
                                    <small class="form-text text-muted">Eg: 28 Highgrove Avenue, Ascot, Berkshire.</small>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Postcode<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                    <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="postcode" placeholder="" data-parsley-required data-parsley-required-message="Please enter the postcode." value="">
                                    <small class="form-text text-muted">Eg: SL5 7HR.</small>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="website" placeholder=""  value="">
                                    <small class="form-text text-muted">Eg: www.berkshire-library.com.</small>
                                    
                                </div>

                                <fieldset>
            						<legend>Social Media</legend>

            						<div class="form-group">
	                                    <label>Facebook<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
	                                    <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="social-facebook" placeholder="" data-parsley-required data-parsley-required-message="Please enter the postcode." value="">
	                                    <small class="form-text text-muted">Eg: www.facebook.com/Berkshire-Library.</small>
	                                    
	                                </div>
	                                <div class="form-group">
	                                    <label>Linkedin</label>
	                                    <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="social-linkedin" placeholder=""  value="">
	                                    <small class="form-text text-muted">Eg: www.linkedin.com/john-smith.</small>
	                                    
	                                </div>

	                                <div class="form-group">
	                                    <label>Twitter</label>
	                                    <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="social-twitter" placeholder=""  value="">
	                                    <small class="form-text text-muted">Eg: www.twitter.com/Berkshire-Library.</small>
	                                    
	                                </div>

	                                <div class="form-group">
	                                    <label>Google +</label>
	                                    <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="social-google" placeholder=""  value="">
	                                    <small class="form-text text-muted">Eg: www.googleplus.com/john-smith.</small>
	                                    
	                                </div>

	                                <div class="form-group">
	                                    <label>Companies House</label>
	                                    <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="social-companyhouse" placeholder=""  value="">
	                            
	                                    
	                                </div>

            					</fieldset>

            					<div class="form-group">
                                    <label>Started Trading</label>
                                    <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="started-trading" placeholder=""  value="">
                                    <small class="form-text text-muted">This is the date when the first commercial transaction was made on your company’s bank account.</small>
                                    
                                </div>


								<div class="form-group">
									<label>Expected Tax Status</label>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input completion_status disabledInput" @if($mode=='view') disabled @endif value="seis" id="chseis" name="exp_tax_status">
                                      <label class="custom-control-label" for="chseis">SEIS</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input completion_status disabledInput" @if($mode=='view') disabled @endif value="eis" id="cheis" name="exp_tax_status">
                                      <label class="custom-control-label" for="chseis">EIS</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input completion_status disabledInput" @if($mode=='view') disabled @endif value="tier1" id="chstier1" name="exp_tax_status">
                                      <label class="custom-control-label" for="chtier1"> Tier1 Visa</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>HMRC Approval Status</label>
                                    <select type="text" name="hmrc_status" id="hmrc_status" placeholder="" class="form-control" data-parsley-required data-parsley-required-message="Please select business proposal round." >                         
	                                   	<option>Application under review </option>                                                                 
	                                   	<option>Approved</option>                                                                                   
	                                   	<option>Application not submitted</option>                                                                              
                                   </select>                                   
                                    
                                </div>

                                <div class="form-group">
									<label>Business Sector</label>
									@foreach($sectors as $sector)
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input completion_status disabledInput" @if($mode=='view') disabled @endif value="{{ $sector->id }}" id="ch{{ $sector->id }}" name="tags_input">
                                      <label class="custom-control-label" for="ch{{ $sector->id }}">{{ $sector->name }}</label>
                                    </div>
                                    @endforeach
                                    
                                </div>

                                <div class="form-group">
                                    <label>Stage of Business</label>
                                    <select type="text" name="lst_stages_of_business" id="lst_stages_of_business" placeholder="" class="form-control" > 
                                    	<option value="">Select</option> 
                                    	@foreach($stageOfBusiness as $stage)                        
	                                   	<option value="{{ $stage->id }}">{{ $stage->name }} </option> 
	                                   @endforeach                                                                
	                                                                                               
                                   </select>                                   
                                    
                                </div>
                                
                                <div class="form-group">
									<label>Milestones achieved</label>
                                    @foreach($milestones as $milestone)
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input completion_status disabledInput" @if($mode=='view') disabled @endif value="{{ $milestone->id }}" id="ch{{ $milestone->id }}" name="chk_milestones">
                                      <label class="custom-control-label" for="ch{{ $milestone->id }}">{{ $milestone->name }}</label>
                                    </div>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn btn-primary editmode @if($mode=='view') d-none @endif" >Save</button> 

                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="d-md-flex justify-content-md-between ">
	        <button type="submit" class="btn btn-primary editmode @if($mode=='view') d-none @endif" >Save</button>
	        <input type="hidden" name="_token" value="{{ csrf_token() }}">
	        <input type="hidden" name="section">
			<input type="hidden" name="gi_code" value="{{ $businessListing->gi_code }}">
 		</div>
        </form>     



         </div>        
	 	 
		</div>
 		 
 
</div>
	 
 
 
</div> <!-- /container -->
 
@include('includes.footer')
@endsection
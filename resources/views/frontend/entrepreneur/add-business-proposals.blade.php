@extends('layouts.frontend')

 @section('css')
  @parent
    <link  href="{{ asset('bower_components/cropper/dist/cropper.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/bower_components/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css') }}" >
@endsection
@section('js')
  @parent

  <script type="text/javascript" src="{{ asset('js/business-proposals.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/cropper/dist/cropper.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/plupload/js/plupload.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js') }}"></script>
  
  
  <script type="text/javascript" src="{{ asset('js/aj-uploads.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {
        // select2
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });

        $('[data-toggle="tooltip"]').tooltip()

        uploadFiles('public-additional-doc','{{ url("upload-files") }}','public');
        uploadFiles('private-addtional-doc','{{ url("upload-files") }}','private');

        @php
            $memberCount = 0;
        @endphp
        @if(isset($teamMemberDetails['team-members']) && !empty($teamMemberDetails['team-members']))
            @foreach($teamMemberDetails['team-members'] as $teamMemberDetail)
                @php
                    $memberCount = $memberCount+1;
                    $containerId   = 'member-picture-' . $memberCount;
                    $pickFile      = 'mem-picfile-' . $memberCount;
                    $imageCLass    = 'member-profile-picture-' . $memberCount;
                    $postUrl       = url("upload-cropper-image");
                @endphp

                uploadCropImage('{{ $containerId }}','{{ $pickFile }}','{{ $imageCLass }}','{{ $postUrl }}');
            @endforeach
        @endif

        uploadSingleFile('upload-proposal-summary','proposal-summary','{{ url("upload-files") }}');
        uploadSingleFile('upload-generate-summary','generate-summary','{{ url("upload-files") }}');
        uploadSingleFile('upload-information-memorandum','information-memorandum','{{ url("upload-files") }}');
        uploadSingleFile('upload-kid-document','kid-document','{{ url("upload-files") }}');
        uploadSingleFile('upload-application-form-1','application-form-1','{{ url("upload-files") }}');
        uploadSingleFile('upload-application-form-2','application-form-2','{{ url("upload-files") }}');
        uploadSingleFile('upload-application-form-3','application-form-3','{{ url("upload-files") }}');
        uploadSingleFile('upload-presentation','presentation','{{ url("upload-files") }}');
        uploadSingleFile('upload-financial-projection','financial-projection','{{ url("upload-files") }}');

        uploadSingleFile('upload-due-deligence-report','due-deligence-report','{{ url("upload-files") }}');
        uploadSingleFile('upload-hardman-document','hardman-document','{{ url("upload-files") }}');
        uploadSingleFile('upload-tax-efficient-review','tax-efficient-review','{{ url("upload-files") }}');
        uploadSingleFile('upload-allenbridge','allenbridge','{{ url("upload-files") }}');
        uploadSingleFile('upload-micap','micap','{{ url("upload-files") }}');
        uploadSingleFile('upload-all-street','all-street','{{ url("upload-files") }}');

        uploadCropImage('business-logo-picture','pickfiles','business-logo-img','{{ url("upload-cropper-image") }}');
        uploadCropImage('business-background-cont','pickbackground','business-background-img','{{ url("upload-cropper-image") }}');


       
    });
        


  </script>
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
            @if(!$businessListing->id)
			     <h3>Business Proposal</h3>
            @else
                <a href="{{ url('/investment-opportunities/single-company/'.$businessListing->slug.'/edit') }}" class="">Edit Proposal</a><br>
                <a href="{{ url('/investment-opportunities/single-company/'.$businessListing->slug.'/edit-due-deligence-questionnaire') }}">Edit Due Deligence Questionnaire</a><br>
                <a href="{{ url('/investment-opportunities/single-company/'.$businessListing->slug.'/edit-tier-1-visa') }}">Edit Tier 1 Visa</a><br>
            @endif

           

        </div>

        <div class="col-sm-9">
        	
		<p>To begin the process of getting your business proposal live on the site and visible to the wider Platform network of investors, please start by answering the questionnaires below, and providing us with as much information as possible. If you are able to complete all sections, and provide us with the required documents such as your business plan, that is great news. However, if you are not yet that far down the line, or have some questions on the best way to answer questions, please do not worry: Simply fill out the top Business Idea section, and we will review and get back to you within 2 working days. Our team is ready to help take you right through the process of getting your business proposal Investment Ready.<br>

		Once we have the information we need, we can kick off the next stage of the process, which is to select an appropriate Due Diligence tier, before your Business proposal goes live.<br>

		If you have any questions or queries, please do not hesitate to contact us at any time on Email support@growthinvest.com, phone 020 7071 3945, or via our online form here</p>


       
        <div class="is_published_config  @if($businessListing->id && (!empty($publishedBusiness))) @else d-none @endif" >
        <a href="{{ url('/investment-opportunities/single-company/'.$businessListing->slug.'/edit?mode=draft') }}">Draft</a> | 
        <a href="{{ url('/investment-opportunities/single-company/'.$businessListing->slug.'/edit?mode=publish') }}">Publish</a>
        </div>
        
 		@include('includes.notification')
 		<form method="post"  data-parsley-validate name="add-business" id="add-business" enctype="multipart/form-data">
		<div id="" role="tablist" class="gi-collapse">
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" href="#collapse1" role="button">
                        <span class="px-0 col-md-10 col-8">
                            Business Idea
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">

                            <small class="mr-sm-3 mr-0 d-block d-md-inline-block section1-status">@if(!empty($sectionStatus) && isset($sectionStatus['section_status_1'])){{ $sectionStatus['section_status_1'] }}@else Not Started @endif</small>
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            <input type="hidden" name="section_status_1" class="section1-status-input sectionstatus-input" value="@if(!empty($sectionStatus) && isset($sectionStatus['section_status_1'])){{ $sectionStatus['section_status_1'] }}@else Not Started @endif">
                        </span>
                    </a>
                </div>

                <div id="collapse1" class="collapse show parent-tabpanel" role="tabpanel" data-section='1' >
                    <div class="card-body">
                        <div class="row">
                        	<p>In order for us to assess your business proposition and match you with possible investors it is important that you complete the following sections as articulately and accurately as possible.</p>
                            <div class="col-sm-12">
                                 
                                @php
                                $businessIdeasData = (!empty($businessIdeas)) ? unserialize($businessIdeas->data_value) :[];
                                @endphp
                                <div class="form-group">
                                    <label>Please describe your business</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="aboutbusiness" placeholder="" >@if(!empty($businessIdeasData) && isset($businessIdeasData['aboutbusiness'])){{ $businessIdeasData['aboutbusiness'] }}@endif</textarea>
                                    <small class="form-text text-muted">Please describe your business in less than 100</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>What stage is the business at?</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="businessstage" placeholder="" >@if(!empty($businessIdeasData) && isset($businessIdeasData['businessstage'])) {{ $businessIdeasData['businessstage'] }}  @endif</textarea>
                                    <small class="form-text text-muted">Please explain in less than 300 word, what stage is the Business at? Ex: The business produced it’s first prototypeproduct in March 2014, spent the summer testing this on potential customers and started trading in November 2014</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Funding to this point</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="businessfunded" placeholder="" >@if(!empty($businessIdeasData) && isset($businessIdeasData['businessfunded'])) {{ $businessIdeasData['businessfunded'] }}  @endif</textarea>
                                    <small class="form-text text-muted">Please explain in less then 100 words, how has the business been funded to date? Ex loans/equity/grants – how much?</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Has the business generated any income/turnover so far? If so, how much?</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="incomegenerated" placeholder="" >@if(!empty($businessIdeasData) && isset($businessIdeasData['incomegenerated'])) {{ $businessIdeasData['incomegenerated'] }}  @endif</textarea>
                                    <small class="form-text text-muted">Has the business generated any income/turnover so far? If so, how much?</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Please summarize the team</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="aboutteam" placeholder="" >@if(!empty($businessIdeasData) && isset($businessIdeasData['aboutteam'])) {{ $businessIdeasData['aboutteam'] }}  @endif</textarea>
                                    <small class="form-text text-muted">Please summarize your Team. Each member in less than 250 words.</small>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Please summarize the market/industry</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="marketscope" placeholder="" >@if(!empty($businessIdeasData) && isset($businessIdeasData['marketscope'])) {{ $businessIdeasData['marketscope'] }}  @endif</textarea>
                                    <small class="form-text text-muted">Please summarize the market/industry in less than 300 words.</small>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Please describe your exit strategy</label>
                                    <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="exit_strategy" placeholder="" >@if(!empty($businessIdeasData) && isset($businessIdeasData['exit_strategy'])) {{ $businessIdeasData['exit_strategy'] }}  @endif</textarea>
                                    <small class="form-text text-muted">Please describe your exit strategy in less than 450 words.</small>
                                    
                                </div>

                                @if($display_mode != 'publish') 
                                <button type="button" class="btn btn-primary text-right editmode @if($mode=='view') d-none @endif save-section" submit-type="business_idea" >Save</button>
                                <span id="business_idea_msg" class="text-success d-none">Business idea successfully saved</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" role="tab" id="headingTwo">
                    <a data-toggle="collapse" href="#collapse2" role="button" class="collapsed" aria-expanded="false">
                        <span class="px-0 col-md-10 col-8">
                           Business Proposal Details
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">

                            <small class="mr-sm-3 mr-0 d-block d-md-inline-block section2-status">@if(!empty($sectionStatus) && isset($sectionStatus['section_status_2'])){{ $sectionStatus['section_status_2'] }}@else Not Started @endif</small>
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            <input type="hidden" name="section_status_2" class="section2-status-input sectionstatus-input" value="@if(!empty($sectionStatus) && isset($sectionStatus['section_status_2'])){{ $sectionStatus['section_status_2'] }}@else Not Started @endif">
                        </span>
                    </a>
                </div>

                <div id="collapse2" class="collapse parent-tabpanel" role="tabpanel" data-section='2' >
                    <div class="card-body">
                        <div class="row">
                        	 
                            <div class="col-sm-12">
                                 

                                <div class="form-group">
                                    <label>Trading Name<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                    <input type="text" class="form-control text-input-status valid_input completion_status editmode @if($mode=='view') d-none @endif" name="title" placeholder="" data-parsley-required data-parsley-required-message="Please enter the trading name." value="{{ $businessListing->title }}">
                                     
                                    <small class="form-text text-muted">This is the name under which you market your company and the display name of a proposal - Eg. GrowthInvest</small>
                                    
                                </div>

                                @php
                                $proposalRounds = businessRounds();
                                @endphp
                                <div class="form-group">
                                    <label>Business Proposal Round<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                   <select type="text" name="proposal_round" id="proposal_round" placeholder="" class="form-control valid_input completion_status" data-parsley-required data-parsley-required-message="Please select business proposal round." >                         
	                                   	<option value=""> Select Business Proposal  Round  </option>                                                                 
	                                    @foreach($proposalRounds as $key=> $proposalRound)
                                            <option value="{{ $key }}" @if($key == $businessListing->round) selected @endif>{{ $proposalRound }}</option>     
                                        @endforeach                                                                    
                                   </select>
                                    <small class="form-text text-muted">This is the Funding Round for your Business Proposal on GrowthInvest.</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Elevator pitch</label>
                                    <textarea class="form-control text-input-status editmode @if($mode=='view') d-none @endif" name="business_proposal_details" placeholder="" >@if(!empty($businessProposalDetails) && isset($businessProposalDetails['business_proposal_details'])){{ $businessProposalDetails['business_proposal_details'] }}@endif</textarea>
                                    <small class="form-text text-muted">Briefly describe your business in no more than 450 characters</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Company Name</label>
                                     <input type="text" class="form-control text-input-status editmode @if($mode=='view') d-none @endif" name="tradingname" placeholder="" value="@if(!empty($businessProposalDetails) && isset($businessProposalDetails['tradingname'])){{ $businessProposalDetails['tradingname'] }}@endif">
                                    <small class="form-text text-muted">Has the business generated any income/turnover so far? If so, how much?</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Registered Address<span class="text-danger editmode  @if($mode=='view') d-none @endif">*</span></label>
                                    <textarea class="form-control completion_status valid_input text-input-status editmode @if($mode=='view') d-none @endif" name="address" placeholder="" data-parsley-required data-parsley-required-message="Please enter registred address." >@if(!empty($businessProposalDetails) && isset($businessProposalDetails['address'])){{ $businessProposalDetails['address'] }}@endif</textarea>
                                    <small class="form-text text-muted">Eg: 28 Highgrove Avenue, Ascot, Berkshire.</small>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Postcode<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                    <input type="text" class="form-control text-input-status valid_input completion_status editmode @if($mode=='view') d-none @endif" name="postcode" placeholder="" data-parsley-required data-parsley-required-message="Please enter the postcode." data-parsley-required data-parsley-required-message="Please enter postcode."  value="@if(!empty($businessProposalDetails) && isset($businessProposalDetails['postcode'])){{ $businessProposalDetails['postcode'] }}@endif">
                                    <small class="form-text text-muted">Eg: SL5 7HR.</small>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="text" class="form-control text-input-status editmode @if($mode=='view') d-none @endif" name="website" placeholder=""  value="@if(!empty($businessProposalDetails) && isset($businessProposalDetails['website'])){{ $businessProposalDetails['website'] }}@endif">
                                    <small class="form-text text-muted">Eg: www.berkshire-library.com.</small>
                                    
                                </div>

                                <fieldset>
            						<legend>Social Media</legend>

            						<div class="form-group">
	                                    <label>Facebook</label>
	                                    <input type="text" class="form-control text-input-status editmode @if($mode=='view') d-none @endif" name="social-facebook" placeholder=""  value="@if(!empty($businessProposalDetails) && isset($businessProposalDetails['social-facebook'])){{ $businessProposalDetails['social-facebook'] }}@endif">
	                                    <small class="form-text text-muted">Eg: www.facebook.com/Berkshire-Library.</small>
	                                    
	                                </div>
	                                <div class="form-group">
	                                    <label>Linkedin</label>
	                                    <input type="text" class="form-control text-input-status  editmode @if($mode=='view') d-none @endif" name="social-linkedin" placeholder=""  value="@if(!empty($businessProposalDetails) && isset($businessProposalDetails['social-linkedin'])){{ $businessProposalDetails['social-linkedin'] }}@endif">
	                                    <small class="form-text text-muted">Eg: www.linkedin.com/john-smith.</small>
	                                    
	                                </div>

	                                <div class="form-group">
	                                    <label>Twitter</label>
	                                    <input type="text" class="form-control text-input-status  editmode @if($mode=='view') d-none @endif" name="social-twitter" placeholder=""  value="@if(!empty($businessProposalDetails) && isset($businessProposalDetails['social-twitter'])){{ $businessProposalDetails['social-twitter'] }}@endif">
	                                    <small class="form-text text-muted">Eg: www.twitter.com/Berkshire-Library.</small>
	                                    
	                                </div>

	                                <div class="form-group">
	                                    <label>Google +</label>
	                                    <input type="text" class="form-control text-input-status  editmode @if($mode=='view') d-none @endif" name="social-google" placeholder=""  value="@if(!empty($businessProposalDetails) && isset($businessProposalDetails['social-google'])){{ $businessProposalDetails['social-google'] }}@endif">
	                                    <small class="form-text text-muted">Eg: www.googleplus.com/john-smith.</small>
	                                    
	                                </div>

	                                <div class="form-group">
	                                    <label>Companies House</label>
	                                    <input type="text" class="form-control text-input-status  editmode @if($mode=='view') d-none @endif" name="social-companyhouse" placeholder=""  value="@if(!empty($businessProposalDetails) && isset($businessProposalDetails['social-companyhouse'])){{ $businessProposalDetails['social-companyhouse'] }}@endif">
	                            
	                                    
	                                </div>

            					</fieldset>

            					<div class="form-group">
                                    <label>Started Trading</label>
                                    <input type="text" class="form-control text-input-status  editmode @if($mode=='view') d-none @endif" name="started-trading" placeholder=""  value="@if(!empty($businessProposalDetails) && isset($businessProposalDetails['started-trading'])){{ $businessProposalDetails['started-trading'] }}@endif">
                                    <small class="form-text text-muted">This is the date when the first commercial transaction was made on your company’s bank account.</small>
                                    
                                </div>


								<div class="form-group">
									<label>Expected Tax Status</label>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input  disabledInput" @if($mode=='view') disabled @endif value="seis" id="chseis" name="exp_tax_status" @if(!empty($businessListing->tax_status) && in_array('SEIS',$businessListing->tax_status)) checked @endif>
                                      <label class="custom-control-label" for="chseis">SEIS</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input  disabledInput" @if($mode=='view') disabled @endif value="eis" id="cheis" name="exp_tax_status" @if(!empty($businessListing->tax_status) && in_array('EIS',$businessListing->tax_status)) checked @endif>
                                      <label class="custom-control-label" for="cheis">EIS</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input  disabledInput" @if($mode=='view') disabled @endif value="tier1" id="chstier1" name="exp_tax_status" @if(!empty($businessListing->tax_status) && in_array('TIER1',$businessListing->tax_status)) checked @endif>
                                      <label class="custom-control-label" for="chstier1"> Tier1 Visa</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>HMRC Approval Status</label>
                                    <select type="text" name="hmrc_status" id="hmrc_status" placeholder="" class="form-control completion_status" >                         
	                                   	<option @if($businessHmrcStatus == 'Application under review') selected @endif>Application under review </option>  
	                                   	<option @if($businessHmrcStatus == 'Approved') selected @endif>Approved</option>  
	                                   	<option @if($businessHmrcStatus == 'Application not submitted') selected @endif>Application not submitted</option>                                                                              
                                   </select>                                   
                                    
                                </div>

                                <div class="form-group">
									<label>Business Sector</label>
									@foreach($sectors as $sector)
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input completion_status disabledInput" @if($mode=='view') disabled @endif value="{{ $sector->id }}" id="ch{{ $sector->id }}" name="tags_input" @if(!empty($defaultIds) && in_array($sector->id,$defaultIds)) checked @endif>
                                      <label class="custom-control-label" for="ch{{ $sector->id }}">{{ $sector->name }}</label>
                                    </div>
                                    @endforeach
                                    
                                </div>

                                <div class="form-group">
                                    <label>Stage of Business</label>
                                    <select type="text" name="lst_stages_of_business" id="lst_stages_of_business" placeholder="" class="form-control" > 
                                    	<option value="">Select</option> 
                                    	@foreach($stageOfBusiness as $stage)                        
	                                   	<option value="{{ $stage->id }}" @if(!empty($defaultIds) && in_array($stage->id,$defaultIds)) selected @endif>{{ $stage->name }} </option> 
	                                   @endforeach                                                                
	                                                                                               
                                   </select>                                   
                                    
                                </div>
                                
                                <div class="form-group">
									<label>Milestones achieved</label>
                                    @foreach($milestones as $milestone)
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input  disabledInput" @if($mode=='view') disabled @endif value="{{ $milestone->id }}" id="ch{{ $milestone->id }}" name="chk_milestones" @if(!empty($defaultIds) && in_array($milestone->id,$defaultIds)) checked @endif>
                                      <label class="custom-control-label" for="ch{{ $milestone->id }}">{{ $milestone->name }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                @if($display_mode != 'publish')
                               <button type="button" class="btn btn-primary text-right editmode @if($mode=='view') d-none @endif save-section" submit-type="business_proposal_details" >Save</button>
                               <span id="business_proposal_details_msg" class="text-success d-none">Business proposal details successfully saved</span>
                               @endif
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header" role="tab" id="headingThree">
                    <a data-toggle="collapse" href="#collapse3" role="button" class="collapsed" aria-expanded="false">
                        <span class="px-0 col-md-10 col-8">
                           Funding Requirements
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">

                            <small class="mr-sm-3 mr-0 d-block d-md-inline-block section3-status">@if(!empty($sectionStatus) && isset($sectionStatus['section_status_3'])){{ $sectionStatus['section_status_3'] }}@else Not Started @endif</small>
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            <input type="hidden" name="section_status_3" class="section3-status-input sectionstatus-input" value="@if(!empty($sectionStatus) && isset($sectionStatus['section_status_3'])){{ $sectionStatus['section_status_3'] }}@else Not Started @endif">
                        </span>
                    </a>
                </div>
                <div id="collapse3" class="collapse parent-tabpanel" role="tabpanel" data-section='3' >
                    <div class="card-body">
                        <div class="row">
                             
                            <div class="col-sm-12">
                                 
                                <div class="form-group">
                                     
                                    
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input  disabledInput" @if($mode=='view') disabled @endif value="1" id="not-sure-raise" name="not-sure-raise" @if(isset($fundingRequirement['not-sure-raise']) && $fundingRequirement['not-sure-raise']=='1')) checked @endif  >
                                      <label class="custom-control-label" for="not-sure-raise"> If you are unsure of your precise funding requirements and would like to book a funding consultation, please tick here.
</label>
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input  disabledInput" @if($mode=='view') disabled @endif value="1" id="not-calculated-share" name="not-calculated-share" @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']=='1')) checked @endif>
                                      <label class="custom-control-label" for="not-calculated-share">If you have not yet calculated the share price and number of shares to be issued please tick here.</label>
                                    </div>
                                     
                                    
                                </div>

                                <div class="not-calculated-share-checked @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']=='1')) d-none @endif">
                                    <div class="form-group">
                                        <label>Number of Shares in Issue<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                        <input type="number" class="form-control text-input-status valid_input completion_status editmode @if($mode=='view') d-none @endif" name="no-of-shares-issue" id="no-of-shares-issue" placeholder="" @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']!='1')) data-parsley-required data-parsley-required-message="Please enter the number of shares in issue." @endif value="@if(isset($fundingRequirement['no-of-shares-issue'])){{ $fundingRequirement['no-of-shares-issue'] }}@endif">
                                         
                                        <small class="form-text text-muted">Eg. 2000</small>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Number of New Shares to be Issued<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                        <input type="number" class="form-control text-input-status valid_input share-price-change completion_status editmode @if($mode=='view') d-none @endif" name="no-of-new-shares-issue" id="no-of-new-shares-issue" placeholder="" @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']!='1')) data-parsley-required data-parsley-required-message="Please enter number of new shares to issues." @endif value="@if(isset($fundingRequirement['no-of-new-shares-issue'])){{ $fundingRequirement['no-of-new-shares-issue'] }}@endif">
                                         
                                        <small class="form-text text-muted">Eg. 1000</small>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Share Price for Current Investment Round<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                        <input type="number" class="form-control share-price-change text-input-status valid_input completion_status editmode @if($mode=='view') d-none @endif" name="share-price-curr-inv-round" id="share-price-curr-inv-round" placeholder="" @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']!='1')) data-parsley-required data-parsley-required-message="Please enter share price for current investment round."  @endif value="@if(isset($fundingRequirement['share-price-curr-inv-round'])){{ $fundingRequirement['share-price-curr-inv-round'] }}@endif">
                                         
                                        <small class="form-text text-muted">E.g. £1.00</small>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Share Class of Shares to be Issued<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                        <input type="text" class="form-control text-input-status completion_status valid_input editmode @if($mode=='view') d-none @endif" name="share-class-issued" id="share-class-issued" placeholder="" @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']!='1')) data-parsley-required data-parsley-required-message="Please enter share class of share to be issued." @endif value="@if(isset($fundingRequirement['share-class-issued'])){{ $fundingRequirement['share-class-issued'] }}@endif">
                                         
                                        <small class="form-text text-muted">E.g. Ordinary, Ordinary A.</small>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Nominal Value of Shares<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                        <input type="number" class="form-control text-input-status completion_status valid_input editmode @if($mode=='view') d-none @endif" name="nominal-value-share" id="nominal-value-share" placeholder="" @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']!='1')) data-parsley-required data-parsley-required-message="Please enter nominal value of share." @endif value="@if(isset($fundingRequirement['nominal-value-share'])){{ $fundingRequirement['nominal-value-share'] }}@endif">
                                         
                                        <small class="form-text text-muted">E.g. £0.01, 1 pence.</small>
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label id="target-raised-label">
                                    @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']=='1')
                                       Targeted Raise
                                    @else
                                       Raise Amount
                                    @endif
                                        <span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                    <input type="number" class="form-control text-input-status money-valuation-change valid_input completion_status editmode @if($mode=='view') d-none @endif" name="investment-sought" id="investment-sought" placeholder=""  data-parsley-required data-parsley-required-message="Please enter the target raised."  value="@if(isset($fundingRequirement['investment-sought'])){{ $fundingRequirement['investment-sought'] }}@endif" @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']=='1') @else readonly @endif>
                                     
                                    <small class="form-text text-muted" id="target-raised-helper">
                                      @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']=='1')
                                       Eg: £17,500.
                                    @else
                                      This field is auto-calculated.
                                    @endif  
                                    </small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Minimum Investment<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                    <input type="number" class="form-control text-input-status completion_status valid_input editmode @if($mode=='view') d-none @endif" name="minimum-investment" placeholder="" data-parsley-required data-parsley-required-message="Please enter the minimum investment."  value="@if(isset($fundingRequirement['minimum-investment'])){{ $fundingRequirement['minimum-investment'] }}@endif">
                                     
                                    <small class="form-text text-muted">Enter amount above £2000.</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Minimum Raise</label>
                                    <input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="minimum-raise" placeholder="" value="@if(isset($fundingRequirement['minimum-raise'])){{ $fundingRequirement['minimum-raise'] }}@endif">
                                     
                                    <small class="form-text text-muted">This should be the minimum amount of funding you require to achieve your next funding milestones.</small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Post-money Valuation</label>
                                    <input type="number" class="form-control money-valuation-change completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="post-money-valuation" id="post-money-valuation" placeholder="" value="@if(isset($fundingRequirement['post-money-valuation'])){{ $fundingRequirement['post-money-valuation'] }}@endif" @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']=='1') @else readonly @endif>

                                    <small class="form-text text-muted" id="post-money-valuation-helper">
                                     @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']=='1')
                                        This field is auto-calculated.
                                    @else
                                       
                                    @endif    
                                    </small>
                                    
                                </div>

                                <div class="form-group">
                                    <label>Pre-money Valuation</label>
                                    <input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="pre-money-valuation" placeholder=""  value="@if(isset($fundingRequirement['pre-money-valuation'])){{ $fundingRequirement['pre-money-valuation'] }}@endif" id="pre-money-valuation"   readonly >

                                </div>

                                <div class="form-group">
                                    <label id="post-money-valuation-label">
                                    @if(isset($fundingRequirement['not-calculated-share']) && $fundingRequirement['not-calculated-share']=='1')
                                        Post-investment % shareholding to be issued
                                    @else
                                        Post-Investment % Equity Offer
                                    @endif
                                </label>
                                    <input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="percentage-giveaway" placeholder="" id="percentage-giveaway"   value="@if(isset($fundingRequirement['percentage-giveaway'])){{ $fundingRequirement['percentage-giveaway'] }}@endif"  readonly  >
                                     <small class="form-text text-muted" >
                                      This field is auto-calculated</small>
                                </div>

                                <div class="form-group">
                                    <label>Deadline date for subscription<span class="text-danger editmode @if($mode=='view') d-none @endif">*</span></label>
                                    <input type="text" class="form-control text-input-status completion_status valid_input datepicker editmode @if($mode=='view') d-none @endif" name="deadline-subscription" placeholder=""  data-parsley-required data-parsley-required-message="Please enter the deadline date of subscription."   value="@if(isset($fundingRequirement['deadline-subscription'])){{ $fundingRequirement['deadline-subscription'] }}@endif">
                                     
                                    <small class="form-text text-muted">This is the deadline date for submission of subscription form.</small>
                                    
                                </div>

                                 
                                <div class="form-group">
                                    <label>Use of Funds</label>
                                    <div class="add-use-of-funds-container">
                                    @if(!empty($fundingRequirement['use_of_funds']))
                                        @foreach($fundingRequirement['use_of_funds'] as $useOfFunds)
                                        <div class="row add-use-of-funds">
                                            <div class="col-sm-5"><div class="form-group"><input type="text" class="form-control text-input-status editmode @if($mode=='view') d-none @endif" name="use_of_funds" placeholder="" value="{{ $useOfFunds['value'] }}" ></div></div>
                                            <div class="col-sm-5"><div class="form-group"><input type="text" class="form-control text-input-status editmode @if($mode=='view') d-none @endif" name="use_of_funds_amount" placeholder="" value="{{ $useOfFunds['amount'] }}" ></div></div>
                                            <div class="col-sm-2"><a class="delete_funds_row btn btn-primary text-right" ><i class="fa fa-trash"></i> &nbsp;</a></div>
                                        </div>
                                        @endforeach

                                    @else
                                        <div class="row add-use-of-funds">
                                            <div class="col-sm-5"><div class="form-group"><input type="text" class="form-control text-input-status editmode @if($mode=='view') d-none @endif" name="use_of_funds" placeholder="" ></div></div>
                                            <div class="col-sm-5"><div class="form-group"><input type="text" class="form-control text-input-status editmode @if($mode=='view') d-none @endif" name="use_of_funds_amount" placeholder="" ></div></div>
                                            <div class="col-sm-2"><a class="delete_funds_row btn btn-primary text-right" ><i class="fa fa-trash"></i> &nbsp;</a></div>
                                        </div>
                                    @endif
                                </div>
                                    <a class="add_funds_row btn btn-primary text-right" >Add Point</a> 
                                <small class="form-text text-muted">Please specify, if possible, the equivalent % of the total amounts raised that goes to this particular points<br>
(Eg: 15% of the fund will be used for marketing)</small>
                                </div>
                                @if($display_mode != 'publish')
                               <button type="button" class="btn btn-primary text-right editmode @if($mode=='view') d-none @endif save-section" submit-type="funding_requirement" >Save</button>
                               <span id="funding_requirement_msg" class="text-success d-none">Funding requirements successfully saved</span>
                               @endif
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header" role="tab" id="headingFour">
                    <a data-toggle="collapse" href="#collapse4" role="button" class="collapsed" aria-expanded="false">
                        <span class="px-0 col-md-10 col-8">
                           Financials
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">

                            <small class="mr-sm-3 mr-0 d-block d-md-inline-block section4-status">@if(!empty($sectionStatus) && isset($sectionStatus['section_status_4'])){{ $sectionStatus['section_status_4'] }}@else Not Started @endif</small>
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            <input type="hidden" name="section_status_4" class="section4-status-input sectionstatus-input" value="@if(!empty($sectionStatus) && isset($sectionStatus['section_status_4'])){{ $sectionStatus['section_status_4'] }}@else Not Started @endif">
                        </span>
                    </a>
                </div>
                <div id="collapse4" class="collapse parent-tabpanel" role="tabpanel" data-section='4' >
                    <div class="card-body">
                        <div class="row">
                             
                            <div class="col-sm-12">
 
   
                                 
                                <div class="form-group">
                                    <label>Use of Funds</label>
        
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-3">YEAR 1 (£)</div>
                                            <div class="col-sm-3">YEAR 2 (£)</div>
                                            <div class="col-sm-3">YEAR 3 (£)</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">SALES</div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="revenue_year1" placeholder="" id="revenue_year1" value="@if(isset($financials['revenue_year1'])){{ $financials['revenue_year1'] }}@endif"></div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="revenue_year2" placeholder="" id="revenue_year2" value="@if(isset($financials['revenue_year2'])){{ $financials['revenue_year2'] }}@endif"></div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="revenue_year3" placeholder="" id="revenue_year3" value="@if(isset($financials['revenue_year3'])){{ $financials['revenue_year3'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">COST OF SALES</div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="sale_year1" placeholder="" id="sale_year1" value="@if(isset($financials['sale_year1'])){{ $financials['sale_year1'] }}@endif"></div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="sale_year2" placeholder="" id="sale_year2" value="@if(isset($financials['sale_year2'])){{ $financials['sale_year2'] }}@endif"></div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="sale_year3" placeholder="" id="sale_year3" value="@if(isset($financials['sale_year3'])){{ $financials['sale_year3'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">EXPENSES</div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="expences_year1" placeholder="" id="expences_year1" value="@if(isset($financials['expences_year1'])){{ $financials['expences_year1'] }}@endif"></div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="expences_year2" placeholder="" id="expences_year2" value="@if(isset($financials['expences_year2'])){{ $financials['expences_year2'] }}@endif"></div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="expences_year3" placeholder="" id="expences_year3" value="@if(isset($financials['expences_year3'])){{ $financials['expences_year3'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">NET INCOME</div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="ebitda_year_1" placeholder="" id="ebitda_year_1" value="@if(isset($financials['ebitda_year_1'])){{ $financials['ebitda_year_1'] }}@endif"></div>
                                            <div class="col-sm-3"><input type="number" class="form-control completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="ebitda_year_2" placeholder="" id="ebitda_year_2" value="@if(isset($financials['ebitda_year_2'])){{ $financials['ebitda_year_2'] }}@endif"></div>
                                            <div class="col-sm-3"><input type="number" class="form-control  completion_status text-input-status editmode @if($mode=='view') d-none @endif" name="ebitda_year_3" placeholder="" id="ebitda_year_3" value="@if(isset($financials['ebitda_year_3'])){{ $financials['ebitda_year_3'] }}@endif"></div>
                                        </div>

                                    
                                </div>
                                     
                          
                                </div>
                                @if($display_mode != 'publish')
                               <button type="button" class="btn btn-primary text-right editmode @if($mode=='view') d-none @endif save-section" submit-type="financials" >Save</button>
                               <span id="financials_msg" class="text-success d-none">Financials successfully saved</span>
                               @endif
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-header" role="tab" id="headingFive">
                        <a data-toggle="collapse" href="#collapse5" role="button" class="collapsed" aria-expanded="false">
                            <span class="px-0 col-md-10 col-8">
                              Management Team
                                <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                            </span>
                            <span class="text-md-right text-center px-0 col-md-2 col-4">

                                <small class="mr-sm-3 mr-0 d-block d-md-inline-block section5-status">@if(!empty($sectionStatus) && isset($sectionStatus['section_status_5'])){{ $sectionStatus['section_status_5'] }}@else Not Started @endif</small>
                                <i class="fa fa-lg fa-plus-square-o"></i>
                                <i class="fa fa-lg fa-minus-square-o"></i>
                                <input type="hidden" name="section_status_5" class="section5-status-input sectionstatus-input" value="@if(!empty($sectionStatus) && isset($sectionStatus['section_status_5'])){{ $sectionStatus['section_status_5'] }}@else Not Started @endif">
                            </span>
                        </a>
                    </div>

                    <div id="collapse5" class="collapse parent-tabpanel" role="tabpanel" data-section='5' >
                        <div class="card-body">
                            <div class="row">
                                 <div class="col-sm-12">
                                    <div class="team-member-container">
                                        @php
                                        $memberCounter = 0;
                                        if(isset($teamMemberDetails['team-members']) && !empty($teamMemberDetails['team-members'])){
                                                     
                                            $data['businessListing'] = $businessListing;
                                            foreach($teamMemberDetails['team-members'] as $teamMemberDetail){
                                                $memberCounter = $memberCounter+1;
                                                $data['memberCount']     = $memberCounter;
                                                $data['teamMemberDetail'] = $teamMemberDetail;
                                                echo View::make('frontend.entrepreneur.add-team-member-card')->with($data)->render();
                                            }
                                        }
                                              
                                        @endphp
                                        <button type="button" class="btn btn-primary text-right editmode @if($mode=='view') d-none @endif add-team-member" >Add team member</button>
                                        <input type="hidden" class="member-counter" name="member_counter" value="{{ $memberCounter }}">
                                        <input type="hidden" class="completion_status" name="member_data" value="">
                                    </div>
                                    
                                    
                                    <br>
                                    @if($display_mode != 'publish')
                                    <button type="button" class="btn btn-primary text-right editmode @if($mode=='view') d-none @endif save-section" submit-type="team-members" >Save</button>
                                    <span id="team-members_msg" class="text-success d-none">Management team successfully saved</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-header" role="tab" id="headingSix">
                        <a data-toggle="collapse" href="#collapse6" role="button" class="collapsed" aria-expanded="false">
                            <span class="px-0 col-md-10 col-8">
                               Company Details
                                <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                            </span>
                            <span class="text-md-right text-center px-0 col-md-2 col-4">

                                <small class="mr-sm-3 mr-0 d-block d-md-inline-block section6-status">@if(!empty($sectionStatus) && isset($sectionStatus['section_status_6'])){{ $sectionStatus['section_status_6'] }}@else Not Started @endif</small>
                                <i class="fa fa-lg fa-plus-square-o"></i>
                                <i class="fa fa-lg fa-minus-square-o"></i>
                                <input type="hidden" name="section_status_6" class="section6-status-input sectionstatus-input" value="@if(!empty($sectionStatus) && isset($sectionStatus['section_status_6'])){{ $sectionStatus['section_status_6'] }}@else Not Started @endif">
                            </span>
                        </a>
                    </div>

                    <div id="collapse6" class="collapse parent-tabpanel" role="tabpanel" data-section='6' >
                        <div class="card-body">
                            <div class="row">
                             
                                <div class="col-sm-12">
    
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Company Number</label>
                                            <input type="number" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="detail_number" placeholder=""   value="@if(isset($companyDetails['number'])){{ $companyDetails['number'] }}@endif" >

                                        </div>  

                                        <div class="form-group">
                                            <label>Company Type</label>
                                            <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="detail_type" placeholder=""   value="@if(isset($companyDetails['type'])){{ $companyDetails['type'] }}@endif" >

                                        </div>  

                                        <div class="form-group">
                                            <label>Telephone No.</label>
                                            <input type="number" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="detail_telephone" placeholder=""   value="@if(isset($companyDetails['telephone'])){{ $companyDetails['telephone'] }}@endif" >

                                        </div>  

                                        <div class="form-group">
                                            <label>SIC 2003</label>
                                            <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="detail_sic2003" placeholder=""   value="@if(isset($companyDetails['sic2003'])){{ $companyDetails['sic2003'] }}@endif" >

                                        </div>  

                                        <div class="form-group">
                                            <label>Types of Accounts</label>
                                            <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="detail_typeofaccount" placeholder=""   value="@if(isset($companyDetails['typeofaccount'])){{ $companyDetails['typeofaccount'] }}@endif" >

                                        </div>  

                                        <div class="form-group">
                                            <label>Latest Annual Returns</label>
                                            <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif datepicker" name="detail_latestannualreturns" placeholder=""   value="@if(isset($companyDetails['latestannualreturns'])){{ $companyDetails['latestannualreturns'] }}@endif" >

                                        </div>  

                                        <div class="form-group">
                                            <label>Next Annual Returns Due</label>
                                            <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif datepicker" name="detail_nextannualreturnsdue" placeholder=""   value="@if(isset($companyDetails['nextannualreturnsdue'])){{ $companyDetails['nextannualreturnsdue'] }}@endif" >

                                        </div>  

                                        <div class="form-group">
                                            <label>Latest Annual Accounts</label>
                                            <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif datepicker" name="detail_latestannualaccounts" placeholder=""   value="@if(isset($companyDetails['latestannualaccounts'])){{ $companyDetails['latestannualaccounts'] }}@endif" >

                                        </div>  

                                        <div class="form-group">
                                            <label>Next Annual Accounts Due</label>
                                            <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif datepicker" name="detail_nextannualaccountsdue" placeholder=""   value="@if(isset($companyDetails['nextannualaccountsdue'])){{ $companyDetails['nextannualaccountsdue'] }}@endif" >

                                        </div>  

                                        <div class="form-group">
                                            <label>SIC 2007</label>
                                            <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="detail_sic2007" placeholder=""   value="@if(isset($companyDetails['sic2007'])){{ $companyDetails['sic2007'] }}@endif" >

                                        </div>  

                                        <div class="form-group">
                                            <label>Trading Address</label>
                                            <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="detail_tradingaddress" placeholder="" >@if(!empty($companyDetails) && isset($companyDetails['tradingaddress'])) {{ $companyDetails['tradingaddress'] }}  @endif</textarea>
                                           
                                            
                                        </div>

                                        <div class="form-group">
                                            <label>Incorporation Date</label>
                                            <input type="text" class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif datepicker" name="detail_incorporationdate" placeholder=""   value="@if(isset($companyDetails['incorporationdate'])){{ $companyDetails['incorporationdate'] }}@endif" >

                                        </div>  
            
                                            
                                             

                                        
                                    </div>
                                         
                              
                                    </div>
                                    @if($display_mode != 'publish')
                                       <button type="button" class="btn btn-primary text-right editmode @if($mode=='view') d-none @endif save-section" submit-type="company-details" >Save</button>
                                       <span id="company-details_msg" class="text-success d-none">Company details successfully saved</span>
                                    @endif
                                
                            </div>
                        </div>
                    </div>

                    <div class="card-header" role="tab" id="headingSeven">
                        <a data-toggle="collapse" href="#collapse7" role="button" class="collapsed" aria-expanded="false">
                            <span class="px-0 col-md-10 col-8">
                              Document Upload
                                <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                            </span>
                            <span class="text-md-right text-center px-0 col-md-2 col-4">

                                <small class="mr-sm-3 mr-0 d-block d-md-inline-block section7-status">@if(!empty($sectionStatus) && isset($sectionStatus['section_status_7'])){{ $sectionStatus['section_status_7'] }}@else Not Started @endif</small>
                                <i class="fa fa-lg fa-plus-square-o"></i>
                                <i class="fa fa-lg fa-minus-square-o"></i>
                                <input type="hidden" name="section_status_7" class="section7-status-input sectionstatus-input" value="@if(!empty($sectionStatus) && isset($sectionStatus['section_status_7'])){{ $sectionStatus['section_status_7'] }}@else Not Started @endif">
                            </span>
                        </a>
                    </div>

                    <div id="collapse7" class="collapse parent-tabpanel" role="tabpanel" data-section='7' >
                        <div class="card-body">
                            <div class="row">
                                 <div class="col-sm-12">
                                     <fieldset>
                                        <legend>Key Documents</legend>                   
                                            <p>Tick to set as Primary Summary</p>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-proposal-summary">
                                              <input type="radio" id="proposalsummaryoption_customupload" name="proposalsummaryoption" class="custom-control-input checked-input-status completion_status" value="customupload" @if(isset($documentUploads['proposalsummaryoption']) && $documentUploads['proposalsummaryoption']=='customupload') checked @endif>
                                              <label class="custom-control-label" for="proposalsummaryoption_customupload">Proposal Summary</label>

                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="proposal-summary" object-type="App\BusinessListing" object-id="" file-type="proposal_summary">Select File</button>
                                                  <input type="hidden" name="proposal_summary" value="" class="uploaded-file-path">

                                                  <span class="file_name">
                                       
                                                      {!! getbusinessUploadedFileNamesHtml($businessFiles,'proposal_summary',$businessListing) !!}

                                                  </span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-generate-summary">
                                              <input type="radio" id="proposalsummaryoption_auto" name="proposalsummaryoption" class="custom-control-input checked-input-status completion_status" value="auto" @if(isset($documentUploads['proposalsummaryoption']) && $documentUploads['proposalsummaryoption']=='auto') checked @endif>
                                              <label class="custom-control-label" for="proposalsummaryoption_auto">Generate Summary</label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="generate-summary" object-type="App\BusinessListing" object-id="" file-type="generate_summary">Select File</button>
                                                  <input type="hidden" name="generate_summary" value="" class="uploaded-file-path">
                                                  <span class="file_name">
                                                       {!! getbusinessUploadedFileNamesHtml($businessFiles,'generate_summary',$businessListing) !!}

                                                  </span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>
                                       
                                            <div class="form-group" id="upload-information-memorandum">
                                             <label>Information Memorandum</label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="information-memorandum" object-type="App\BusinessListing" object-id="" file-type="information_memorandum">Select File</button>
                                                  <input type="hidden" name="information_memorandum" value="" class="uploaded-file-path">
                                                  <span class="file_name">{!! getbusinessUploadedFileNamesHtml($businessFiles,'information_memorandum',$businessListing) !!}</span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>
                                      
                                            <div class="form-group" id="upload-kid-document">
                                             <label>KID Document</label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="kid-document" object-type="App\BusinessListing" object-id="" file-type="kid_document">Select File</button>
                                                  <input type="hidden" name="kid_document" value="" class="uploaded-file-path">
                                                  <span class="file_name">{!! getbusinessUploadedFileNamesHtml($businessFiles,'kid_document',$businessListing) !!}</span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>

                                            <hr>
                                            <p>Tick to set as primary application report</p>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-application-form-1">
                                              <input type="radio" id="primaryapplicationform_propfundapplicationforms" name="primaryapplicationform" class="custom-control-input checked-input-status completion_status" value="propfundapplicationforms" @if(isset($documentUploads['primaryapplicationform']) && $documentUploads['primaryapplicationform']=='propfundapplicationforms') checked @endif>
                                              <label class="custom-control-label" for="primaryapplicationform_propfundapplicationforms">Application Form 1 </label>

                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="application-form-1" object-type="App\BusinessListing" object-id="" file-type="application_form_1">Select File</button>
                                                  <input type="hidden" name="application_form_1" value="" class="uploaded-file-path">
                                                  <span class="file_name">{!! getbusinessUploadedFileNamesHtml($businessFiles,'application_form_1',$businessListing) !!}</span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-application-form-2">
                                              <input type="radio" id="primaryapplicationform_propfundapplicationforms1" name="primaryapplicationform" class="custom-control-input checked-input-status completion_status" value="propfundapplicationforms1"  @if(isset($documentUploads['primaryapplicationform']) && $documentUploads['primaryapplicationform']=='propfundapplicationforms1') checked @endif >
                                              <label class="custom-control-label" for="primaryapplicationform_propfundapplicationforms1">Application Form 2</label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="application-form-2" object-type="App\BusinessListing" object-id="" file-type="application_form_2">Select File</button>
                                                  <input type="hidden" name="application_form_2" value="" class="uploaded-file-path">
                                                  <span class="file_name">{!! getbusinessUploadedFileNamesHtml($businessFiles,'application_form_2',$businessListing) !!}</span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-application-form-3">
                                              <input type="radio" id="primaryapplicationform_propfundapplicationforms2" name="primaryapplicationform" class="custom-control-input checked-input-status completion_status" value="propfundapplicationforms2" @if(isset($documentUploads['primaryapplicationform']) && $documentUploads['primaryapplicationform']=='propfundapplicationforms2') checked @endif>
                                              <label class="custom-control-label" for="primaryapplicationform_propfundapplicationforms2">Application Form 3</label>

                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="application-form-3" object-type="App\BusinessListing" object-id="" file-type="application_form_3">Select File</button>
                                                  <input type="hidden" name="application_form_3" value="" class="uploaded-file-path">
                                                  <span class="file_name">{!! getbusinessUploadedFileNamesHtml($businessFiles,'application_form_3',$businessListing) !!}</span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>
                                       
                                            <div class="form-group " id="upload-presentation">
                                             <label>Presentation</label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="presentation" object-type="App\BusinessListing" object-id="" file-type="presentation">Select File</button>
                                                  <input type="hidden" name="presentation" value="" class="uploaded-file-path">
                                                  <span class="file_name">{!! getbusinessUploadedFileNamesHtml($businessFiles,'presentation',$businessListing) !!}</span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>
                                 
                                            <div class="form-group " id="upload-financial-projection"> 
                                             <label  >Financial Projection</label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="financial-projection" object-type="App\BusinessListing" object-id="" file-type="financial_projection">Select File</button>
                                                  <input type="hidden" name="financial_projection" value="" class="uploaded-file-path">
                                                  <span class="file_name">{!! getbusinessUploadedFileNamesHtml($businessFiles,'financial_projection',$businessListing) !!}</span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>

                                            <p>In order to be able to review your proposals and make an informed decision, it is essential that you provide us with an extended business plan covering in detail the following aspects: Business Idea, Business Model, USP, revenue streams, team, market gap, analysis of your competition, market size, challenges and opportunities, success factors, use of funds, marketing, client acquisition, financial projections and exit strategies.</p>

                                            <p>Public Additional Documents</p>
                                            <div class="row upload-files-section">
                                               <div id="public-additional-doc" object-type="App\BusinessListing" object-id="" file-type="public_additional_documents">
                                                  <p></p>
                                               </div>
                                               <div class="uploaded-file-path"></div>
                                               <br>
                                               <div class="uploaded-files">
                                                   @if(!empty($publicAdditionalDocs))
                                                    @foreach($publicAdditionalDocs as $publicDocs)
                                                    <div>
                                                        <p class="multi_file_name">{{ $publicDocs['name'] }}  <a href="javascript:void(0)" class="delete-uploaded-file" object-type="App\BusinessListing" file-id="{{ $publicDocs['fileid']}}" object-id="" type="public_additional_documents"><i class="fa fa-close" style="color: red"></i></a><input type="hidden" name="public_additional_documents_file_id[]" class="image_url" value="{{ $publicDocs['fileid'] }}"></p>
                                                    </div>
                                                    @endforeach
                                                   @endif
                                                </div>
                                                <span class="deleted_files">
                                                </span>
                                            </div>

                                            <p>Private Additional Documents</p>

                                            <div class="row upload-files-section">
                                               <div id="private-addtional-doc" object-type="App\BusinessListing" object-id="" file-type="private_additional_documents">
                                                  <p></p>
                                               </div>
                                               <div class="uploaded-file-path"></div>
<br>                                            
                                                <div class="uploaded-files">
                                                   @if(!empty($privateAdditionalDocs))
                                                    @foreach($privateAdditionalDocs as $privateDocs)
                                                    <div>
                                                       <p class="multi_file_name"> {{ $privateDocs['name'] }}  <a href="javascript:void(0)" class="delete-uploaded-file" object-type="App\BusinessListing"  file-id="{{ $privateDocs['fileid']}}" object-id="" type="private_additional_documents"><i class="fa fa-close" style="color: red"></i></a><input type="hidden" name="private_additional_documents_file_id[]" class="file_id" value="{{ $privateDocs['fileid'] }}"></p>
                                                   </div>
                                                    @endforeach
                                               @endif
                                               </div>
                                               <span class="deleted_files">
                                                </span>
                                            </div>
                                    </fieldset>
                             
                                    <!-- <button type="button" class="btn btn-primary text-right editmode @if($mode=='view') d-none @endif save-section" submit-type="document-upload" >Save</button> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-header" role="tab" id="headingEight">
                        <a data-toggle="collapse" href="#collapse8" role="button" class="collapsed" aria-expanded="false">
                            <span class="px-0 col-md-10 col-8">
                            Platform Due Diligence Report Upload
                                <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                            </span>
                            <span class="text-md-right text-center px-0 col-md-2 col-4">

                                <small class="mr-sm-3 mr-0 d-block d-md-inline-block section8-status">@if(!empty($sectionStatus) && isset($sectionStatus['section_status_8'])){{ $sectionStatus['section_status_8'] }}@else Not Started @endif</small>
                                <i class="fa fa-lg fa-plus-square-o"></i>
                                <i class="fa fa-lg fa-minus-square-o"></i>
                                <input type="hidden" name="section_status_8" class="section8-status-input sectionstatus-input" value="@if(!empty($sectionStatus) && isset($sectionStatus['section_status_8'])){{ $sectionStatus['section_status_8'] }}@else Not Started @endif">
                            </span>
                        </a>
                    </div>

                    <div id="collapse8" class="collapse parent-tabpanel" role="tabpanel" data-section='8' >
                        <div class="card-body">
                            <div class="row">
                                 <div class="col-sm-12">
                                    <fieldset>
                                        <legend>Platform Due Diligence Report</legend>   
                                        <div class="form-group">
                                            <label>Platform Due Diligence Report Intro</label>
                                            <textarea class="form-control text-input-status completion_status editmode @if($mode=='view') d-none @endif" name="desc_diligencereportsintro" placeholder="" >@if(!empty($dueDeligence) && isset($dueDeligence['desc_diligencereportsintro'])) {{ $dueDeligence['desc_diligencereportsintro'] }}  @endif</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Due Diligence Report</label><br>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-due-deligence-report">
                                              <input type="radio" id="primaryplatformduediligence_duediligencedoc" name="primaryplatformduediligence" class="custom-control-input checked-input-status completion_status" value="duediligencedoc" @if(isset($dueDeligence['primaryplatformduediligence']) && $dueDeligence['primaryplatformduediligence']=='duediligencedoc') checked @endif>
                                               <label class="custom-control-label" for="primaryplatformduediligence_duediligencedoc"></label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="due-deligence-report" object-type="App\BusinessListing" object-id="" file-type="due_deligence_report">Select File</button>
                                                  <input type="hidden" name="due_deligence_report" value="" class="uploaded-file-path">
                                                  <span class="file_name">
                                                       {!! getbusinessUploadedFileNamesHtml($businessFiles,'due_deligence_report',$businessListing) !!}

                                                  </span>
                                                <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend>External Due Diligence Reports</legend>   

                                        <div class="form-group">
                                            <label>Hardman Documents</label><br>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-hardman-document">
                                              <input type="radio" id="primaryplatformduediligence_harmandoc" name="primaryplatformduediligence" class="custom-control-input checked-input-status completion_status" value="harmandoc" @if(isset($dueDeligence['primaryplatformduediligence']) && $dueDeligence['primaryplatformduediligence']=='harmandoc') checked @endif>
                                              <label class="custom-control-label" for="primaryplatformduediligence_harmandoc"></label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="hardman-document" object-type="App\BusinessListing" object-id="" file-type="hardman_document">Select File</button>
                                                  <input type="hidden" name="hardman_document" value="" class="uploaded-file-path">
                                                  <span class="file_name">
                                                       {!! getbusinessUploadedFileNamesHtml($businessFiles,'hardman_document',$businessListing) !!}

                                                  </span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>

                                            <p>Hardman Documents External document links</p>

                                            <button type="button" class="btn btn-primary text-right add-external-links" link-type="hardman" id="" >Add External Link</button>

                                            <div class="hardman-external-links">
                                                @php
                                                $i=0;
                                                @endphp
                                                @if(isset($dueDeligence['hardman-links']))
                                                @foreach($dueDeligence['hardman-links'] as $links)
                                                    @php
                                                    $i++;
                                                    @endphp
                                                <div class="row div-row-container">                    
                                                  <div class="col-sm-4 text-center">
                                                          <input type="text" placeholder="Add File Title" name="hardman_title_{{ $i }}" class="form-control editmode" value="{{ $links['name'] }}">   
                                                      </div> 
                                                      <div class="col-sm-4 text-center">
                                                          <input type="text" placeholder="Add File Path" name="hardman_path_{{ $i }}" class="form-control editmode" value="{{ $links['url'] }}">   
                                                      </div> 
                                                      <div class="col-sm-2 text-center">
                                                    <a href="javascript:void(0)" class="btn btn-default remove-row"><i class="fa fa-trash"></i></a> 
                                                      </div>                   
                                                   
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                            <input type="hidden" name="hardman-counter" value="{{ $i }}">
                                        </div>

                                        <!--  -->

                                        <div class="form-group">
                                            <label>Tax efficient review</label><br>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-tax-efficient-review">
                                              <input type="radio" id="primaryplatformduediligence_taxefficientreviewdoc" name="primaryplatformduediligence" class="custom-control-input checked-input-status completion_status" value="taxefficientreviewdoc" @if(isset($dueDeligence['primaryplatformduediligence']) && $dueDeligence['primaryplatformduediligence']=='taxefficientreviewdoc') checked @endif>
                                              <label class="custom-control-label" for="primaryplatformduediligence_taxefficientreviewdoc"></label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="tax-efficient-review" object-type="App\BusinessListing" object-id="" file-type="tax_efficient_review">Select File</button>
                                                  <input type="hidden" name="tax_efficient_review" value="" class="uploaded-file-path">
                                                  <span class="file_name">
                                                       {!! getbusinessUploadedFileNamesHtml($businessFiles,'tax_efficient_review',$businessListing) !!}

                                                  </span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>

                                            <p>Tax Efficient Review Documents External document links</p>

                                            <button type="button" class="btn btn-primary text-right add-external-links" link-type="tax-efficient-review" id="" >Add External Link</button>

                                            <div class="tax-efficient-review-external-links">
                                                @php
                                                    $i=0;
                                                    @endphp
                                                @if(isset($dueDeligence['tax-efficient-review-links']))
                                                    
                                                @foreach($dueDeligence['tax-efficient-review-links'] as $links)
                                                    @php
                                                    $i++;
                                                    @endphp
                                                <div class="row div-row-container">                    
                                                  <div class="col-sm-4 text-center">
                                                          <input type="text" placeholder="Add File Title" name="tax-efficient-review_title_{{ $i }}" class="form-control editmode" value="{{ $links['name'] }}">   
                                                      </div> 
                                                      <div class="col-sm-4 text-center">
                                                          <input type="text" placeholder="Add File Path" name="tax-efficient-review_path_{{ $i }}" class="form-control editmode" value="{{ $links['url'] }}">   
                                                      </div> 
                                                      <div class="col-sm-2 text-center">
                                                    <a href="javascript:void(0)" class="btn btn-default remove-row"><i class="fa fa-trash"></i></a> 
                                                      </div>                   
                                                   
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                            <input type="hidden" name="tax-efficient-review-counter" value="{{ $i }}">
                                        </div>
                                        <!--  -->


                                        <div class="form-group">
                                            <label>Allenbridge</label><br>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-allenbridge">
                                              <input type="radio" id="primaryplatformduediligence_allenbridge" name="primaryplatformduediligence" class="custom-control-input checked-input-status completion_status" value="allenbridgedoc" @if(isset($dueDeligence['primaryplatformduediligence']) && $dueDeligence['primaryplatformduediligence']=='allenbridgedoc') checked @endif>
                                              <label class="custom-control-label" for="primaryplatformduediligence_allenbridge"></label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="allenbridge" object-type="App\BusinessListing" object-id="" file-type="allenbridge">Select File</button>
                                                  <input type="hidden" name="allenbridge" value="" class="uploaded-file-path">
                                                  <span class="file_name">
                                                       {!! getbusinessUploadedFileNamesHtml($businessFiles,'allenbridge',$businessListing) !!}

                                                  </span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>

                                            <p>Tax Efficient Review Documents External document links</p>

                                            <button type="button" class="btn btn-primary text-right add-external-links" link-type="allenbridge" id="" >Add External Link</button>

                                            <div class="allenbridge-external-links">
                                                @php
                                                $i=0;
                                                @endphp
                                                @if(isset($dueDeligence['allenbridge-links']))
                                                    
                                                @foreach($dueDeligence['allenbridge-links'] as $links)
                                                    @php
                                                    $i++;
                                                    @endphp
                                                <div class="row div-row-container">                    
                                                  <div class="col-sm-4 text-center">
                                                          <input type="text" placeholder="Add File Title" name="allenbridge_title_{{ $i }}" class="form-control editmode" value="{{ $links['name'] }}">   
                                                      </div> 
                                                      <div class="col-sm-4 text-center">
                                                          <input type="text" placeholder="Add File Path" name="allenbridge_path_{{ $i }}" class="form-control editmode" value="{{ $links['url'] }}">   
                                                      </div> 
                                                      <div class="col-sm-2 text-center">
                                                    <a href="javascript:void(0)" class="btn btn-default remove-row"><i class="fa fa-trash"></i></a> 
                                                      </div>                   
                                                   
                                                </div>
                                                @endforeach
                                                @endif

                                            </div>
                                            <input type="hidden" name="allenbridge-counter" value="{{ $i }}">
                                        </div>

                                        <!--  -->

                                        <div class="form-group">
                                            <label>MICAP</label><br>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-micap">
                                              <input type="radio" id="primaryplatformduediligence_mykapdoc" name="primaryplatformduediligence" class="custom-control-input checked-input-status completion_status" value="mykapdoc" @if(isset($dueDeligence['primaryplatformduediligence']) && $dueDeligence['primaryplatformduediligence']=='mykapdoc') checked @endif>
                                               <label class="custom-control-label" for="primaryplatformduediligence_mykapdoc"></label>
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="micap" object-type="App\BusinessListing" object-id="" file-type="micap">Select File</button>
                                                  <input type="hidden" name="micap" value="" class="uploaded-file-path">
                                                  <span class="file_name">
                                                       {!! getbusinessUploadedFileNamesHtml($businessFiles,'micap',$businessListing) !!}

                                                  </span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>

                                            <p>MICAP Documents External document links</p>

                                            <button type="button" class="btn btn-primary text-right add-external-links" link-type="micap" id="" >Add External Link</button>

                                            <div class="micap-external-links">
                                                @php
                                                $i=0;
                                                @endphp
                                                @if(isset($dueDeligence['micap-links']))
                                                    
                                                @foreach($dueDeligence['micap-links'] as $links)
                                                    @php
                                                    $i++;
                                                    @endphp
                                                <div class="row div-row-container">                    
                                                  <div class="col-sm-4 text-center">
                                                          <input type="text" placeholder="Add File Title" name="micap_title_{{ $i }}" class="form-control editmode" value="{{ $links['name'] }}">   
                                                      </div> 
                                                      <div class="col-sm-4 text-center">
                                                          <input type="text" placeholder="Add File Path" name="micap_path_{{ $i }}" class="form-control editmode" value="{{ $links['url'] }}">   
                                                      </div> 
                                                      <div class="col-sm-2 text-center">
                                                    <a href="javascript:void(0)" class="btn btn-default remove-row"><i class="fa fa-trash"></i></a> 
                                                      </div>                   
                                                   
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                            <input type="hidden" name="micap-counter" value="{{ $i }}">
                                        </div>

                                        <!--  -->

                                        <div class="form-group">
                                            <label> All Street</label><br>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-all-street">
                                              <input type="radio" id="primaryplatformduediligence_allstreetdoc" name="primaryplatformduediligence" class="custom-control-input checked-input-status completion_status" value="allstreetdoc" @if(isset($dueDeligence['primaryplatformduediligence']) && $dueDeligence['primaryplatformduediligence']=='allstreetdoc') checked @endif>
                                               <label class="custom-control-label" for="primaryplatformduediligence_allstreetdoc"></label>

                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="all-street" object-type="App\BusinessListing" object-id="" file-type="all_street">Select File</button>
                                                  <input type="hidden" name="all_street" value="" class="uploaded-file-path">
                                                  <span class="file_name">
                                                       {!! getbusinessUploadedFileNamesHtml($businessFiles,'all_street',$businessListing) !!}

                                                  </span>
                                                  <span class="deleted_files">
                                                </span>
                                              </div>
                                            </div>

                                            <p>Allstreet Documents External document links</p>

                                            <button type="button" class="btn btn-primary text-right add-external-links" link-type="all-street" id="" >Add External Link</button>

                                            <div class="all-street-external-links">
                                                @php
                                                $i=0;
                                                @endphp
                                                @if(isset($dueDeligence['all-street-links']))
                                                    
                                                @foreach($dueDeligence['all-street-links'] as $links)
                                                    @php
                                                    $i++;
                                                    @endphp
                                                <div class="row div-row-container">                    
                                                  <div class="col-sm-4 text-center">
                                                          <input type="text" placeholder="Add File Title" name="all-street_title_{{ $i }}" class="form-control editmode" value="{{ $links['name'] }}">   
                                                      </div> 
                                                      <div class="col-sm-4 text-center">
                                                          <input type="text" placeholder="Add File Path" name="all-street_path_{{ $i }}" class="form-control editmode" value="{{ $links['url'] }}">   
                                                      </div> 
                                                      <div class="col-sm-2 text-center">
                                                    <a href="javascript:void(0)" class="btn btn-default remove-row"><i class="fa fa-trash"></i></a> 
                                                      </div>                   
                                                   
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                            <input type="hidden" name="all-street-counter" value="{{ $i }}">
                                        </div>

                                        <!--  -->

                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-header" role="tab" id="headingNine">
                        <a data-toggle="collapse" href="#collapse9" role="button" class="collapsed" aria-expanded="false">
                            <span class="px-0 col-md-10 col-8">
                             Images & Videos
                                <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                            </span>
                            <span class="text-md-right text-center px-0 col-md-2 col-4">

                                <small class="mr-sm-3 mr-0 d-block d-md-inline-block section9-status">@if(!empty($sectionStatus) && isset($sectionStatus['section_status_9'])){{ $sectionStatus['section_status_9'] }}@else Not Started @endif</small>
                                <i class="fa fa-lg fa-plus-square-o"></i>
                                <i class="fa fa-lg fa-minus-square-o"></i>
                                <input type="hidden" name="section_status_9" class="section9-status-input sectionstatus-input" value="@if(!empty($sectionStatus) && isset($sectionStatus['section_status_9'])){{ $sectionStatus['section_status_9'] }}@else Not Started @endif">
                            </span>
                        </a>
                    </div>

                    <div id="collapse9" class="collapse parent-tabpanel" role="tabpanel" data-section='9' >
                        <div class="card-body">
                            <div class="row">
                                 <div class="col-sm-12">
                                     <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label>Logo</label>
                                        </div>
                                        <div class="col-md-3 text-center" id="business-logo-picture">
                                                 
                                                <img src="{{ $businessLogo }}" alt="..." class="img-thumbnail business-logo-img">
                                                <input type="hidden" name="logo_cropped_image_url" class="cropped_image_url">
                                                <input type="hidden" name="logo_image_url" class="image_url " value="{{ $businessLogo }}"> 
                                                <input type="hidden" class="completion_status" value="@if($hasBusinessLogo) 1 @endif"> 

                                                <div class="action-btn"> 
                                                <button type="button" id="pickfiles" class="btn btn-primary btn-sm mt-2  editmode @if($mode=='view') d-none @endif"><i class="fa fa-camera"></i> Select Image</button>   <a href="javascript:void(0)" class="delete-image @if(!$hasBusinessLogo) d-none @endif" object-type="App\BusinessListing" object-id="" type="business_logo" image-class="business-logo-img"><i class="fa fa-trash text-danger editmode "></i></a>
                                                </div>
                                             
 
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <label>Background Image</label>
                                        </div>
                                        <div class="col-md-9" id="business-background-cont">
                                            <img src="{{ $backgroundImage }}" alt="..." class="img-thumbnail business-background-img">
                                               <input type="hidden" name="background_cropped_image_url" class="cropped_image_url">
                                                <input type="hidden" name="background_url" class="image_url " value="{{ $backgroundImage }}">   
                                                <input type="hidden" class="completion_status" value="@if($hasBackgroundImage) 1 @endif"> 
                                                <div class="action-btn"> 
                                                <button type="button" id="pickbackground" class="btn btn-primary btn-sm mt-2  editmode @if($mode=='view') d-none @endif"><i class="fa fa-camera"></i> Select Image</button>   <a href="javascript:void(0)" class="delete-image @if(!$hasBackgroundImage) d-none @endif" object-type="App\BusinessListing" object-id="" type="business_background_image" image-class="business-background-img"><i class="fa fa-trash text-danger editmode "></i></a>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <label>Proposal Video</label> 
                                            <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#addVideos">Add Video</a>   
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                         <hr>
                                         <br>
                                         <div class="row proposal-video-container">
                                        @foreach($videos as $key=> $video)
                                        <div class="row div-row-container video-container" video-container-count="{{ ($key+1)}}">

                                          <div class="col-sm-3 text-center">
                                              <input type="hidden" name="video_name_{{ ($key+1)}}" class="video_name" value="{{ $video->name }}"> {{ $video->name }}
                                          </div> 
                                          <div class="col-sm-5 text-center">
                                              <textarea name="embed_code_{{ ($key+1)}}" class="d-none embed_code"> {{ $video->embed_code }}    </textarea> <div height="200">{!! $video->embed_code !!}  </div>
                                          </div> 
                                          <div class="col-sm-2 text-center">
                                              <input type="hidden" name="feedback_{{ ($key+1)}}" class="feedback" value="{{ $video->is_pitchevent }}"> 
                                              @if($video->is_pitchevent=='yes')
                                              <span class="fa fa-commenting  fa-2x" aria-hidden="true"></span>
                                              @else
                                              -
                                              @endif
                                          </div>
                                              <div class="col-sm-2 text-center">
                                                <button type="button" class="edit-video" >edit</button>
                                            <a href="javascript:void(0)" class="btn btn-default remove-row"><i class="fa fa-trash"></i></a> 
                                              </div>                   
                                           
                                        </div>
                                        @endforeach
                                         </div>
                                         <input type="hidden" name="video_counter" value="{{ count($videos) }}">
                                    </div>
                             
                                     
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="d-md-flex justify-content-md-between ">
            @if($display_mode != 'publish')
            <button type="button" class="btn btn-primary editmode @if($mode=='view') d-none @endif save-business-proposal" save-type="save" >Save</button>
	        <button type="button" class="btn btn-primary editmode @if($mode=='view') d-none @endif save-business-proposal" save-type="submit" >Save and publish</button>
             
             <button type="button" class="btn btn-primary editmode @if($mode=='view') d-none @endif discard-draft-changes is_published_config @if((!empty($publishedBusiness)) && $businessListing->status=='draft') @else d-none @endif " save-type="save" >Discard Changes</button>
             
            @else
            <button type="button" class="btn btn-primary editmode @if($mode=='view') d-none @endif save-business-proposal" save-type="save" >Save as draft</button>
            @endif
            @if($businessListing->id)
            <a href="{{ url('/download-business-proposals/'.$businessListing->id.'/') }}" class="btn btn-primary" target="_blank"  ><i class="fa fa-download" ></i></a>
            @endif

	        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="section">
	        <input type="hidden" name="business_type" value="{{ $businessListingType }}">

            <input type="hidden" name="gi_code" value="{{ (!empty($publishedBusiness)) ? $publishedBusiness->gi_code:'' }}">
			<input type="text" name="refernce_id" value="{{ (!empty($businessListing)) ? $businessListing->id:'' }}">
 		</div>
        </form>     



         </div>        
	 	 
		</div>
 		 
 
</div>
	 
 
 
</div> <!-- /container -->
<div id="crop-modal-container">
@php
    $memberCount = 0;
@endphp
@if(isset($teamMemberDetails['team-members']) && !empty($teamMemberDetails['team-members']))
    @foreach($teamMemberDetails['team-members'] as $teamMemberDetail)
        @php
            $memberCount = $memberCount+1;
            $memberPicType = 'member_picture_' . $memberCount;
            $imageCLass    = 'member-profile-picture-' . $memberCount;

            $cropModalData = ['objectType' => 'App\BusinessListing', 'objectId' => 0, 'aspectRatio' => 1, 'heading' => 'Crop Profile Image', 'imageClass' => $imageCLass, 'minContainerWidth' => 450, 'minContainerHeight' => 200, 'displaySize' => 'medium_1x1', 'imageType' => $memberPicType];

            echo View::make('includes.crop-modal')->with($cropModalData)->render();
        @endphp

    @endforeach
@endif 

@php
$cropModalData = ['objectType'=>'App\BusinessListing','objectId'=>'','aspectRatio'=>1,'heading'=>'Crop Business Logo','imageClass'=>'business-logo-img','minContainerWidth' =>450,'minContainerHeight'=>200,'displaySize'=>'medium_1x1','imageType'=>'firm_logo'];
@endphp
{!! View::make('includes.crop-modal')->with($cropModalData)->render() !!}

@php
$cropModalData = ['objectType'=>'App\BusinessListing','objectId'=>'','aspectRatio'=>'2.858/1','heading'=>'Crop Background Image','imageClass'=>'business-background-img','minContainerWidth' =>450,'minContainerHeight'=>200,'displaySize'=>'medium_2_58x1','imageType'=>'background_image'];
@endphp
{!! View::make('includes.crop-modal')->with($cropModalData)->render() !!}

</div>

 <!-- Modal -->
    <div class="modal fade" id="addVideos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Business proposal Video</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body m-auto d-block">
            <div>
               <div class="form-group">
                    <label>Video Name</label>
                    <input type="text" class="form-control text-input-status editmode " name="video_name" placeholder=""  value="">
                    
                </div>

                <div class="form-group">
                    <label>Embed code</label>
                    <textarea class="form-control text-input-status completion_status editmode " name="embed_code" placeholder="" ></textarea>
                </div>
                                    
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" value="yes" id="ch_dwn" name="feedback" >
                  <label class="custom-control-label" for="ch_dwn">Feedback</label>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="edit_container_count">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-primary save-business-video">Save</button>
          </div>
        </div>
      </div>
    </div>
@include('includes.footer')
@endsection
@extends('layouts.frontend')

 @section('css')
  @parent
    <link rel="stylesheet" href="{{ asset('/bower_components/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css') }}" >
@endsection
@section('js')
  @parent

  <script type="text/javascript" src="{{ asset('js/business-proposals.js') }}"></script>
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

        uploadFiles('due-deligence-doc','{{ url("upload-files") }}','due_deligence_documents');
   

 
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
        <h3>Company’s Due Diligence Questionnaire</h3>
		<p><b>NOTE:</b> Company’s Due Diligence Questionnaire helps us complete our due diligence required prior to the approval stage of the investment committee Do complete every aspect as accurately as possible</p>

        <h2>Please provide us with more details related to the following legal aspects.</h2>

 		@include('includes.notification')
 		<form method="post"  data-parsley-validate name="edit-due-deligence" id="edit-due-deligence" action="{{ url('/investment-opportunities/save-due-deligence-questionnaire') }}" enctype="multipart/form-data">
		<div id="" role="tablist" class="gi-collapse">
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" href="#collapse1" role="button">
                        <span class="px-0 col-md-10 col-8">
                            Company Information
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            
                        </span>
                    </a>
                </div>

                <div id="collapse1" class="collapse show parent-tabpanel" role="tabpanel" data-section='1' >
                    <div class="card-body">
                        <div class="row">
                        	<p>In order for us to assess your business proposition and match you with possible investors it is important that you complete the following sections as articulately and accurately as possible.</p>
                            <div class="col-sm-12">
                                 
                                 <div class="form-group">
                                    <label>Company Number:</label>
                                    <input type="text" class="form-control text-input-status valid_input" name="companynumber" placeholder=""  value="@if(isset($companyDetails['companynumber'])){{ $companyDetails['companynumber'] }}@endif">
                                     
                                    <small class="form-text text-muted">This is the name you registered your company with – Eg: GrowthInvest Ltd.</small>
                                    
                                </div>
 
                                <div class="form-group">
                                    <label>Incorporation Date:</label>
                                    <input type="text" class="form-control text-input-status datepicker editmode " name="incopdate" placeholder=""  value="@if(isset($companyDetails['incopdate'])){{ $companyDetails['incopdate'] }}@endif">
                                     
                                    <small class="form-text text-muted">This is the date your company was entered on the Register of Companies by the Registar.</small>
                                    
                                </div>


                                <div class="form-group">
                                    <label>Directors & Shareholders over 30% :</label>
                                   <input type="text" class="form-control text-input-status valid_input" name="dirshareholders" placeholder=""  value="@if(isset($companyDetails['dirshareholders'])){{ $companyDetails['dirshareholders'] }}@endif">
                                    <small class="form-text text-muted">This is the list of Shareholders who have shares of more than 30% in your Company</small>
                                    
                                </div>

                          

                                <div class="form-group">
                                    <label>Registered Address</label>
                                    <textarea class="form-control   text-input-status" name="registeredaddress" placeholder=""  >@if(!empty($companyDetails) && isset($companyDetails['registeredaddress'])){{ $companyDetails['registeredaddress'] }}@endif</textarea>
                                    
                                </div>      

                                <div class="form-group">
                                    <label>Have you received any grants?</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" id="grants_yes" name="grants" class="custom-control-input checked-input-status completion_status" value="yes" @if(isset($companyDetails['grants']) && $companyDetails['grants']=='yes') checked @endif>
                                          <label class="custom-control-label" for="grants_yes">Yes</label>
                                          <input type="radio" id="grants_no" name="grants" class="custom-control-input checked-input-status" value="no" @if(isset($companyDetails['grants']) && $companyDetails['grants']=='no') checked @endif>
                                          <label class="custom-control-label" for="grants_no">No</label>
                                    </div>
                                    <small class="form-text text-muted">This is the Non-repayable funds disbursed by any government department, corporation, foundation or trust, a nonprofit entity, educational institution</small>
                                </div>

                                  <div class="form-group">
                                    <label>Have you received any loans or grants by incubators or do you plan to do so in the next 3 years?</label>
                                    <textarea class="form-control completion_status valid_input text-input-status" name="loansandgrants" placeholder=""  >@if(!empty($companyDetails) && isset($companyDetails['loansandgrants'])){{ $companyDetails['loansandgrants'] }}@endif</textarea>
                                    <small class="form-text text-muted">This is the Repayable or Non-repayable funds from other Startup businesses</small>
                                </div>    

                                <div class="form-group">
                                    <label>Do you have an accountant? What are his/her name, contact details and address?</label>
                                    <input type="text" class="form-control text-input-status valid_input " name="accountdetails" placeholder="" value="@if(!empty($companyDetails) && isset($companyDetails['accountdetails'])){{ $companyDetails['accountdetails'] }}@endif">
 
                                </div>
                                 <div class="form-group">
                                    <label>When is the accounting period end?</label>
                                    <input type="text" class="form-control text-input-status valid_input " name="accountingend" placeholder="" value="@if(!empty($companyDetails) && isset($companyDetails['accountingend'])){{ $companyDetails['accountingend'] }}@endif">
 
                                </div>
                                <div class="form-group">
                                    <label>Are the articles of your company bespoke articles or they are the standard Model Articles as provided on Companies House on incorporation?</label>
                                    <textarea class="form-control completion_status valid_input text-input-status" name="companybespoke" placeholder=""  >@if(!empty($companyDetails) && isset($companyDetails['companybespoke'])){{ $companyDetails['companybespoke'] }}@endif</textarea>
                                    
                                </div>  
                                 <div class="form-group">
                                    <label>Do you have a patent or any application pending? What is the status for this?</label>
                                    <textarea class="form-control completion_status valid_input text-input-status" name="pendingapplication" placeholder=""  >@if(!empty($companyDetails) && isset($companyDetails['pendingapplication'])){{ $companyDetails['pendingapplication'] }}@endif</textarea>
                                    
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" role="tab" id="headingTwo">
                    <a data-toggle="collapse" href="#collapse2" role="button" class="collapsed" aria-expanded="false">
                        <span class="px-0 col-md-10 col-8">
                           Share Structure & Ownership Information
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">

                            
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            
                        </span>
                    </a>
                </div>

                <div id="collapse2" class="collapse parent-tabpanel" role="tabpanel" data-section='2' >
                    <div class="card-body">
                        <div class="row">
                        	 
                            <div class="col-sm-12">
                                 

                                <div class="form-group">
                                    <label>What is the existing ownership structure of the company?</label>
                                    <input type="text" class="form-control text-input-status valid_input  " name="ownershipstructure" placeholder=""  value="@if(!empty($shareOwnershipInfo) && isset($shareOwnershipInfo['ownershipstructure'])){{ $shareOwnershipInfo['ownershipstructure'] }}@endif">
                                  
                                </div>

                                

                                <div class="form-group">
                                    <label>Are the existing shareholders willing to participate in this round of funding?  </label>
                                    <input type="text" class="form-control text-input-status valid_input  " name="existingshareholders" placeholder=""  value="@if(!empty($shareOwnershipInfo) && isset($shareOwnershipInfo['existingshareholders'])){{ $shareOwnershipInfo['existingshareholders'] }}@endif">
                                    
                                </div>

                                <div class="form-group">
                                    <label>Are there any articles in the most recent version of the Articles of Association referring to different class of shares, pre-emption rights or EIS?</label>
                                     <input type="text" class="form-control text-input-status " name="atricleassociation" placeholder="" value="@if(!empty($shareOwnershipInfo) && isset($shareOwnershipInfo['atricleassociation'])){{ $shareOwnershipInfo['atricleassociation'] }}@endif">
                                     
                                </div>

                                <div class="form-group">
                                    <label>Do you have any other external investors participating in this round?  </label>
                                     <input type="text" class="form-control text-input-status " name="externalinvestors" placeholder="" value="@if(!empty($shareOwnershipInfo) && isset($shareOwnershipInfo['externalinvestors'])){{ $shareOwnershipInfo['externalinvestors'] }}@endif">
                                     <small class="form-text text-muted">You need to provide the names of External Investors who are participating</small>
                                </div>

                                 
                                <div class="form-group">
                                    <label>Are there any options or shares promised to other third parties? Do you plan to issue any options?</label>
                                    <input type="text" class="form-control text-input-status valid_input " name="sharespromised" placeholder=""  value="@if(!empty($shareOwnershipInfo) && isset($shareOwnershipInfo['sharespromised'])){{ $shareOwnershipInfo['sharespromised'] }}@endif">
                                    <small class="form-text text-muted">Provide complete details on the options or shares you will be providing to Third party</small>
                                    
                                </div>
                                 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header" role="tab" id="headingThree">
                    <a data-toggle="collapse" href="#collapse3" role="button" class="collapsed" aria-expanded="false">
                        <span class="px-0 col-md-10 col-8">
                           Due-Diligence Documents
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">

                             
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            
                        </span>
                    </a>
                </div>
                <div id="collapse3" class="collapse parent-tabpanel" role="tabpanel" data-section='3' >
                    <div class="card-body">
                        <div class="row">
                             
                            <div class="col-sm-12">
                                 
                                <p>In order to help us understand your business in detail and to proceed with the due-diligence process, please attach the following documents. They will be used only for the scope of our due-diligence and will not be made available to investors or any other third parties without your consent.</p>

                                <p>Incorporation Documents | Most recent Articles of Association | Most recent version of Shareholders Memorandum</p>
                                <div class="row upload-files-section">
                                   <div id="due-deligence-doc" object-type="App\BusinessListing" object-id="" file-type="due_deligence_documents">
                                      <p></p>
                                   </div>
                                   <div class="uploaded-file-path"></div>
                                   <br>
                                   <div class="uploaded-files">
                                        @if(!empty($dueDeligenceDocuments))
                                            @foreach($dueDeligenceDocuments as $publicDocs)
                                            <div>
                                                <p class="multi_file_name">{{ $publicDocs['name'] }}  <a href="javascript:void(0)" class="delete-uploaded-file" object-type="App\BusinessListing" file-id="{{ $publicDocs['fileid']}}"  object-id="" type="due_deligence_documents"><i class="fa fa-close" style="color: red"></i></a><input type="hidden" name="due_deligence_documents_file_id[]" class="image_url" value="{{ $publicDocs['fileid'] }}"></p>
                                            </div>
                                            @endforeach
                                           @endif
                                    </div>
                                    <span class="deleted_files">
                                    </span>
                                </div>

                                <p>This should be an editable excel document that supports your valuation and your projections. Please also clearly detail the assumptions that underpin these projections, with specific reference to sales and customer acquisition.</p>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header" role="tab" id="headingFour">
                    <a data-toggle="collapse" href="#collapse4" role="button" class="collapsed" aria-expanded="false">
                        <span class="px-0 col-md-10 col-8">
                           Company Financial Snapshot
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">

                            
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            
                        </span>
                    </a>
                </div>
                <div id="collapse4" class="collapse parent-tabpanel" role="tabpanel" data-section='4' >
                    <div class="card-body">
                        <div class="row">
                             
                            <div class="col-sm-12">
 
                                <p>Please fill in the following tables with accurate information reflecting the financial activity of your company. Further documents to support this information might be required.</p>

                              
                                 
                                <div class="form-group">
                                    <label>All assets cash, fixed assets, Liabilities- trade creditors, loans</label>
        
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-3">Amount(£)</div>
                                            <div class="col-sm-3"> </div>
                                            <div class="col-sm-3">Amount(£)</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"><b>TOTAL ASSETS</b></div>
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-3"><b>TOTAL LIABILITIES</b></div>
                                            <div class="col-sm-3"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">CURRENT ASSETS</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="currentassets" placeholder="" id="currentassets" value="@if(isset($companyFinancialSnapshot['currentassets'])){{ $companyFinancialSnapshot['currentassets'] }}@endif"></div>
                                            <div class="col-sm-3">CURRENT LIABILITIES</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="currentliabilities" placeholder="" id="currentliabilities" value="@if(isset($companyFinancialSnapshot['currentliabilities'])){{ $companyFinancialSnapshot['currentliabilities'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">CURRENT CASH</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="currentcash" placeholder="" id="currentcash" value="@if(isset($companyFinancialSnapshot['currentcash'])){{ $companyFinancialSnapshot['currentcash'] }}@endif"></div>
                                            <div class="col-sm-3">ACCOUNTS PAYABLE</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="accountspayable" placeholder="" id="accountspayable" value="@if(isset($companyFinancialSnapshot['accountspayable'])){{ $companyFinancialSnapshot['accountspayable'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">ACCOUNTS RECEIVABLE</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="amountreceivable" placeholder="" id="amountreceivable" value="@if(isset($companyFinancialSnapshot['amountreceivable'])){{ $companyFinancialSnapshot['amountreceivable'] }}@endif"></div>
                                            <div class="col-sm-3">INTEREST PAYABLE</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="interestpayable" placeholder="" id="interestpayable" value="@if(isset($companyFinancialSnapshot['interestpayable'])){{ $companyFinancialSnapshot['interestpayable'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">PREPAID EXPENSES</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="preparedexpenses" placeholder="" id="preparedexpenses" value="@if(isset($companyFinancialSnapshot['preparedexpenses'])){{ $companyFinancialSnapshot['preparedexpenses'] }}@endif"></div>
                                            <div class="col-sm-3">TAXES PAYABLE</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="taxespayble" placeholder="" id="taxespayble" value="@if(isset($companyFinancialSnapshot['taxespayble'])){{ $companyFinancialSnapshot['taxespayble'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"> </div>
                                            <div class="col-sm-3"> </div>
                                            <div class="col-sm-3"> </div>
                                            <div class="col-sm-3"> </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">FIXED ASSETS</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="fixedseets" placeholder="" id="fixedseets" value="@if(isset($companyFinancialSnapshot['fixedseets'])){{ $companyFinancialSnapshot['fixedseets'] }}@endif"></div>

                                            <div class="col-sm-3">LONG-TERM LIABILITIES</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="longtermliabilities" placeholder="" id="longtermliabilities" value="@if(isset($companyFinancialSnapshot['longtermliabilities'])){{ $companyFinancialSnapshot['longtermliabilities'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">LONG - TERM INVESTMENTS</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="longterminvestments" placeholder="" id="longterminvestments" value="@if(isset($companyFinancialSnapshot['longterminvestments'])){{ $companyFinancialSnapshot['longterminvestments'] }}@endif"></div>
                                            <div class="col-sm-3">LOANS</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="loans" placeholder="" id="loans" value="@if(isset($companyFinancialSnapshot['loans'])){{ $companyFinancialSnapshot['loans'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">LAND & BUILDINGS</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="landndbuild" placeholder="" id="landndbuild" value="@if(isset($companyFinancialSnapshot['landndbuild'])){{ $companyFinancialSnapshot['landndbuild'] }}@endif"></div>
                                            <div class="col-sm-3">TRADE CREDITORS</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="tradecreditors" placeholder="" id="tradecreditors" value="@if(isset($companyFinancialSnapshot['tradecreditors'])){{ $companyFinancialSnapshot['tradecreditors'] }}@endif"></div>
                                        </div>
                                         <div class="row">
                                            <div class="col-sm-3">PLANT & EQUIPMENT</div>
                                            <div class="col-sm-3"><input type="number" class="form-control" name="plantequipment" placeholder="" id="plantequipment" value="@if(isset($companyFinancialSnapshot['plantequipment'])){{ $companyFinancialSnapshot['plantequipment'] }}@endif"></div>
                                            <div class="col-sm-3"> </div>
                                            <div class="col-sm-3">< </div>
                                        </div>
                                    
                                </div>
                                     
                          
                                </div>

               
                                
                            </div>
                        </div>
                    </div>

                    <div class="card-header" role="tab" id="headingFive">
                    <a data-toggle="collapse" href="#collapse5" role="button" class="collapsed" aria-expanded="false">
                        <span class="px-0 col-md-10 col-8">
                           Key Financial Metrics
                            <span class="has-invalid-data d-none"><i class="fa fa-info-circle text-danger m-r-5 element-title" aria-hidden="true"></i></span>
                        </span>
                        <span class="text-md-right text-center px-0 col-md-2 col-4">

                            
                            <i class="fa fa-lg fa-plus-square-o"></i>
                            <i class="fa fa-lg fa-minus-square-o"></i>
                            
                        </span>
                    </a>
                </div>
                <div id="collapse5" class="collapse parent-tabpanel" role="tabpanel" data-section='5' >
                    <div class="card-body">
                        <div class="row">
                             
                            <div class="col-sm-12">
 
                                <p>Please complete the below table with your last 6 months financial history.</p>

                              
                                 
                                <div class="form-group">
                                    <label>All assets cash, fixed assets, Liabilities- trade creditors, loans</label>
            
                                        <div class="row">
                                            <div class="col-sm-6"></div>
                                            <div class="col-sm-1">Month 1</div>
                                            <div class="col-sm-1">Month 2</div>
                                            <div class="col-sm-1">Month 3</div>
                                            <div class="col-sm-1">Month 4</div>
                                            <div class="col-sm-1">Month 5</div>
                                            <div class="col-sm-1">Month 6</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">SALES</div>
                                            <div class="col-sm-1"><input type="number" class="form-control completion_status text-input-status " name="sales_m1" placeholder="" id="sales_m1" value="@if(isset($keyFinancialMetrics['sales_m1'])){{ $keyFinancialMetrics['sales_m1'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control " name="sales_m2" placeholder="" id="sales_m2" value="@if(isset($keyFinancialMetrics['sales_m2'])){{ $keyFinancialMetrics['sales_m2'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="sales_m3" placeholder="" id="sales_m3" value="@if(isset($keyFinancialMetrics['sales_m3'])){{ $keyFinancialMetrics['sales_m3'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="sales_m4" placeholder="" id="sales_m4" value="@if(isset($keyFinancialMetrics['sales_m4'])){{ $keyFinancialMetrics['sales_m4'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="sales_m5" placeholder="" id="sales_m5" value="@if(isset($keyFinancialMetrics['sales_m5'])){{ $keyFinancialMetrics['sales_m5'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="sales_m6" placeholder="" id="sales_m6" value="@if(isset($keyFinancialMetrics['sales_m6'])){{ $keyFinancialMetrics['sales_m6'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">COST OF SALES</div>
                                            <div class="col-sm-1"><input type="number" class="form-control completion_status text-input-status " name="cost_of_sales_m1" placeholder="" id="cost_of_sales_m1" value="@if(isset($keyFinancialMetrics['cost_of_sales_m1'])){{ $keyFinancialMetrics['cost_of_sales_m1'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control " name="cost_of_sales_m2" placeholder="" id="cost_of_sales_m2" value="@if(isset($keyFinancialMetrics['cost_of_sales_m2'])){{ $keyFinancialMetrics['cost_of_sales_m2'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="cost_of_sales_m3" placeholder="" id="cost_of_sales_m3" value="@if(isset($keyFinancialMetrics['cost_of_sales_m3'])){{ $keyFinancialMetrics['cost_of_sales_m3'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="cost_of_sales_m4" placeholder="" id="cost_of_sales_m4" value="@if(isset($keyFinancialMetrics['cost_of_sales_m4'])){{ $keyFinancialMetrics['cost_of_sales_m4'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="cost_of_sales_m5" placeholder="" id="cost_of_sales_m5" value="@if(isset($keyFinancialMetrics['cost_of_sales_m5'])){{ $keyFinancialMetrics['cost_of_sales_m5'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="cost_of_sales_m6" placeholder="" id="cost_of_sales_m6" value="@if(isset($keyFinancialMetrics['cost_of_sales_m6'])){{ $keyFinancialMetrics['cost_of_sales_m6'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">SALARY OVERHEADS</div>
                                            <div class="col-sm-1"><input type="number" class="form-control completion_status text-input-status " name="sales_overheead_m1" placeholder="" id="sales_overheead_m1" value="@if(isset($keyFinancialMetrics['sales_overheead_m1'])){{ $keyFinancialMetrics['sales_overheead_m1'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control " name="sales_overheead_m2" placeholder="" id="sales_overheead_m2" value="@if(isset($keyFinancialMetrics['sales_overheead_m2'])){{ $keyFinancialMetrics['sales_overheead_m2'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="sales_overheead_m3" placeholder="" id="sales_overheead_m3" value="@if(isset($keyFinancialMetrics['sales_overheead_m3'])){{ $keyFinancialMetrics['sales_overheead_m3'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="sales_overheead_m4" placeholder="" id="sales_overheead_m4" value="@if(isset($keyFinancialMetrics['sales_overheead_m4'])){{ $keyFinancialMetrics['sales_overheead_m4'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="sales_overheead_m5" placeholder="" id="sales_overheead_m5" value="@if(isset($keyFinancialMetrics['sales_overheead_m5'])){{ $keyFinancialMetrics['sales_overheead_m5'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="sales_overheead_m6" placeholder="" id="sales_overheead_m6" value="@if(isset($keyFinancialMetrics['sales_overheead_m6'])){{ $keyFinancialMetrics['cost_of_sales_m6'] }}@endif"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">NON-SALARY OVERHEADS</div>
                                            <div class="col-sm-1"><input type="number" class="form-control completion_status text-input-status " name="nonsoverheads_m1" placeholder="" id="nonsoverheads_m1" value="@if(isset($keyFinancialMetrics['nonsoverheads_m1'])){{ $keyFinancialMetrics['nonsoverheads_m1'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control " name="nonsoverheads_m2" placeholder="" id="nonsoverheads_m2" value="@if(isset($keyFinancialMetrics['nonsoverheads_m2'])){{ $keyFinancialMetrics['nonsoverheads_m2'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="nonsoverheads_m3" placeholder="" id="nonsoverheads_m3" value="@if(isset($keyFinancialMetrics['nonsoverheads_m3'])){{ $keyFinancialMetrics['nonsoverheads_m3'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="nonsoverheads_m4" placeholder="" id="nonsoverheads_m4" value="@if(isset($keyFinancialMetrics['nonsoverheads_m4'])){{ $keyFinancialMetrics['nonsoverheads_m4'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="nonsoverheads_m5" placeholder="" id="nonsoverheads_m5" value="@if(isset($keyFinancialMetrics['nonsoverheads_m5'])){{ $keyFinancialMetrics['nonsoverheads_m5'] }}@endif"></div>
                                            <div class="col-sm-1"><input type="number" class="form-control" name="nonsoverheads_m6" placeholder="" id="nonsoverheads_m6" value="@if(isset($keyFinancialMetrics['nonsoverheads_m6'])){{ $keyFinancialMetrics['nonsoverheads_m6'] }}@endif"></div>
                                        </div>
                                    
                                </div>
                                     
                          
                                </div>

               
                                
                            </div>
                        </div>
                    </div>
  

                </div>
            </div>
        </div>

        <div class="d-md-flex justify-content-md-between ">
            <button type="submit" class="btn btn-primary  " save-type="save" >Save</button>
	        <!-- <button type="button" class="btn btn-primary editmode @if($mode=='view') d-none @endif save-business-proposal" save-type="submit" >Submit</button> -->
     
	        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="section">
	        <input type="hidden" name="business_type" value="{{ $businessListingType }}">

            <input type="hidden" name="gi_code" value="{{ (!empty($businessListing)) ? $businessListing->gi_code:'' }}">
			<input type="hidden" name="refernce_id" value="{{ (!empty($businessListing)) ? $businessListing->id:'' }}">
 		</div>
        </form>     



         </div>        
	 	 
		</div>
 		 
 
</div>
	 
 
 
</div> <!-- /container -->
 

 
@include('includes.footer')
@endsection
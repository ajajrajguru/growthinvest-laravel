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

        uploadFiles('tier1-additional-doc','{{ url("upload-files") }}','tier1_additional_documents');
        uploadSingleFile('upload-tier1-document','tier1_document','{{ url("upload-files") }}');

 
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
        <h3>Edit Tier1 Visa</h3>
		<p>The Tier 1 (Entrepreneur) visa allows non-UK nationals the opportunity to gain a temporary visa by investing a minimum of £200,000 in, and becoming a non-executive director of, a UK business. The Tier 1 process is slightly lengthier than investment from a UK source and as a result we allow 1-3 months for the process to complete if successful. Of course there are criteria attached to the investment, details of which are outlined below.</p>

        <div class="table-responsive">
           <table class="table table-bordered tier-1-tab-table">
              <thead>
                 <tr>
                    <th>The Investor</th>
                    <th>The Business</th>
                 </tr>
              </thead>
              <tbody>
                 <tr>
                    <td>
                       <ul>
                          <li>Must be English speaking</li>
                          <li> Must invest money for 3 years</li>
                          <li> Must bring a specific skill set to business (e.g. marketing expertise/ experience growing a tech start-up)</li>
                          <li> Must not be employed by any other business within the UK</li>
                       </ul>
                    </td>
                    <td>
                       <ul>
                          <li> Must create 2 new full time jobs that are 12 months each in duration</li>
                          <li> Must facilitate investor becoming an exec or non exec director</li>
                       </ul>
                    </td>
                 </tr>
              </tbody>
           </table>
        </div>

        <p >More information available at: <a href="https://www.gov.uk/tier-1-entrepreneur/overview">https://www.gov.uk/tier-1-entrepreneur/overview</a>.<br>                If you are interested in receiving funds from a Tier 1 source please complete the short questionnaire on the following page. </p>

 		@include('includes.notification')
 		<form method="post"  data-parsley-validate name="edit-due-deligence" id="edit-due-deligence" action="{{ url('/investment-opportunities/save-tier-1-visa') }}" enctype="multipart/form-data">
		<div id="" role="tablist" class="gi-collapse">
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" href="#collapse1" role="button">
                        <span class="px-0 col-md-10 col-8">
                            Tier 1 Investment Business Questionnaire
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
                        	<p>Please give a brief description of the company (Including name, industry and the number of employees):</p>
                            <div class="col-sm-12">
                                 
                                
                                <div class="form-group">
                                    <label></label>
                                    <textarea class="form-control   text-input-status" name="info_description" placeholder=""  >@if(!empty($businessQuestionnaire) && isset($businessQuestionnaire['info_description'])){{ $businessQuestionnaire['info_description'] }}@endif</textarea>
                                    
                                </div>      

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" role="tab" id="headingTwo">
                    <a data-toggle="collapse" href="#collapse2" role="button" class="collapsed" aria-expanded="false">
                        <span class="px-0 col-md-10 col-8">
                           Further Company information
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
                        	 
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Company Type</label>
                                    <input type="text" class="form-control text-input-status valid_input  " name="info_cmptype" placeholder=""  value="@if(!empty($companyInformation) && isset($companyInformation['info_cmptype'])){{ $companyInformation['info_cmptype'] }}@endif">
                                  
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date of Incorporation</label>
                                    <input type="text" class="form-control text-input-status datepicker editmode " name="info_incorporationdate" placeholder=""  value="@if(isset($companyInformation['info_incorporationdate'])){{ $companyInformation['info_incorporationdate'] }}@endif">
                                     
                                    <small class="form-text text-muted">This is the date your company was entered on the Register of Companies by the Registar.</small>
                                    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Company Number</label>
                                    <input type="text" class="form-control text-input-status valid_input  " name="info_cmpnumber" placeholder=""  value="@if(!empty($companyInformation) && isset($companyInformation['info_cmpnumber'])){{ $companyInformation['info_cmpnumber'] }}@endif">
                                  
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telephone Number</label>
                                    <input type="text" class="form-control text-input-status valid_input  " name="info_telnumber" placeholder=""  value="@if(!empty($companyInformation) && isset($companyInformation['info_telnumber'])){{ $companyInformation['info_telnumber'] }}@endif">
                                  
                                </div>
                            </div>
                               

                            <div class="col-sm-12">
                                 
                                
                                <div class="form-group">
                                    <label>Trading address:</label>
                                    <textarea class="form-control   text-input-status" name="info_tradingaddress" placeholder=""  >@if(!empty($companyInformation) && isset($companyInformation['info_tradingaddress'])){{ $companyInformation['info_tradingaddress'] }}@endif</textarea>
                                    
                                </div>      

                            </div>
                                 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header" role="tab" id="headingThree">
                    <a data-toggle="collapse" href="#collapse3" role="button" class="collapsed" aria-expanded="false">
                        <span class="px-0 col-md-10 col-8">
                           Employee Information
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
                                 
      

                                <p>Please list key personnel involved in the company (Directors & Shareholders over 20%):</p>
                                <div class="row">
                                    <div class="col-sm-4"><b>Name</b></div>
                                    <div class="col-sm-4"><b>Position</b></div>
                                    <div class="col-sm-4"><b>Shareholding (%)</b></div>
                                   
                                </div>
                                 
                                @for($i=1; $i<=10; $i++)                                 
                                
                                <div class="row">
                                    <div class="col-sm-4"><input type="text" class="form-control" name="emp_name{{ $i }}" placeholder="" id="emp_name{{ $i }}" value="@if(isset($employeeInformation['emp_name'.$i])){{ $employeeInformation['emp_name'.$i] }}@endif"></div>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="emp_position{{ $i }}" placeholder="" id="emp_position{{ $i }}" value="@if(isset($employeeInformation['emp_position'.$i])){{ $employeeInformation['emp_position'.$i] }}@endif"></div>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="emp_shareholding{{ $i }}" placeholder="" id="emp_shareholding{{ $i }}" value="@if(isset($employeeInformation['emp_shareholding'.$i])){{ $employeeInformation['emp_shareholding'.$i] }}@endif"></div>
                                </div>
                                @endfor

                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header" role="tab" id="headingFour">
                    <a data-toggle="collapse" href="#collapse4" role="button" class="collapsed" aria-expanded="false">
                        <span class="px-0 col-md-10 col-8">
                           Financial Information
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
 
    
                                <div class="form-group">
                                    <table border="1">
                                         <tr>
                                            <td>
                                            </td>
                                            <td colspan="3">
                                                Historical
                                            </td>
                                            <td>
                                                Current
                                            </td>
                                            <td colspan="3">
                                                Projected
                                            </td>
                                         </tr>
                                         <tr>
                                            <td>
                                                Year
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_yearhistory1" placeholder="" id="finmetric_yearhistory1" value="@if(isset($financialInformation['finmetric_yearhistory1'])){{ $financialInformation['finmetric_yearhistory1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_yearhistory2" placeholder="" id="finmetric_yearhistory2" value="@if(isset($financialInformation['finmetric_yearhistory2'])){{ $financialInformation['finmetric_yearhistory2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_yearhistory3" placeholder="" id="finmetric_yearhistory3" value="@if(isset($financialInformation['finmetric_yearhistory3'])){{ $financialInformation['finmetric_yearhistory3'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_yearcurrent" placeholder="" id="finmetric_yearcurrent" value="@if(isset($financialInformation['finmetric_yearcurrent'])){{ $financialInformation['finmetric_yearcurrent'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_yearprojected1" placeholder="" id="finmetric_yearprojected1" value="@if(isset($financialInformation['finmetric_yearprojected1'])){{ $financialInformation['finmetric_yearprojected1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_yearprojected2" placeholder="" id="finmetric_yearprojected2" value="@if(isset($financialInformation['finmetric_yearprojected2'])){{ $financialInformation['finmetric_yearprojected2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_yearprojected3" placeholder="" id="finmetric_yearprojected3" value="@if(isset($financialInformation['finmetric_yearprojected3'])){{ $financialInformation['finmetric_yearprojected3'] }}@endif">
                                            </td>
                                         </tr>
                                         <tr>
                                            <td>
                                                Sales Turnover
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_saleshistory1" placeholder="" id="finmetric_saleshistory1" value="@if(isset($financialInformation['finmetric_saleshistory1'])){{ $financialInformation['finmetric_saleshistory1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_saleshistory2" placeholder="" id="finmetric_saleshistory2" value="@if(isset($financialInformation['finmetric_saleshistory2'])){{ $financialInformation['finmetric_saleshistory2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_saleshistory3" placeholder="" id="finmetric_saleshistory3" value="@if(isset($financialInformation['finmetric_saleshistory3'])){{ $financialInformation['finmetric_saleshistory3'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_salescurrent" placeholder="" id="finmetric_salescurrent" value="@if(isset($financialInformation['finmetric_salescurrent'])){{ $financialInformation['finmetric_salescurrent'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_salesprojected1" placeholder="" id="finmetric_salesprojected1" value="@if(isset($financialInformation['finmetric_salesprojected1'])){{ $financialInformation['finmetric_salesprojected1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_salesprojected2" placeholder="" id="finmetric_salesprojected2" value="@if(isset($financialInformation['finmetric_salesprojected2'])){{ $financialInformation['finmetric_salesprojected2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_salesprojected3" placeholder="" id="finmetric_salesprojected3" value="@if(isset($financialInformation['finmetric_salesprojected3'])){{ $financialInformation['finmetric_salesprojected3'] }}@endif">
                                            </td>
                                         </tr>
                                         <tr>
                                            <td>
                                                Operating Costs
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_costhistory1" placeholder="" id="finmetric_costhistory1" value="@if(isset($financialInformation['finmetric_costhistory1'])){{ $financialInformation['finmetric_costhistory1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_costhistory2" placeholder="" id="finmetric_costhistory2" value="@if(isset($financialInformation['finmetric_costhistory2'])){{ $financialInformation['finmetric_costhistory2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_costhistory3" placeholder="" id="finmetric_costhistory3" value="@if(isset($financialInformation['finmetric_costhistory3'])){{ $financialInformation['finmetric_costhistory3'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_costcurrent" placeholder="" id="finmetric_costcurrent" value="@if(isset($financialInformation['finmetric_costcurrent'])){{ $financialInformation['finmetric_costcurrent'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_costprojected1" placeholder="" id="finmetric_costprojected1" value="@if(isset($financialInformation['finmetric_costprojected1'])){{ $financialInformation['finmetric_costprojected1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_costprojected2" placeholder="" id="finmetric_costprojected2" value="@if(isset($financialInformation['finmetric_costprojected2'])){{ $financialInformation['finmetric_costprojected2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_costprojected3" placeholder="" id="finmetric_costprojected3" value="@if(isset($financialInformation['finmetric_costprojected3'])){{ $financialInformation['finmetric_costprojected3'] }}@endif">
                                            </td>
                                         </tr>
                                         <tr>
                                            <td>
                                                Profit/ Loss
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_profitlosshistory1" placeholder="" id="finmetric_profitlosshistory1" value="@if(isset($financialInformation['finmetric_profitlosshistory1'])){{ $financialInformation['finmetric_profitlosshistory1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_profitlosshistory2" placeholder="" id="finmetric_profitlosshistory2" value="@if(isset($financialInformation['finmetric_profitlosshistory2'])){{ $financialInformation['finmetric_profitlosshistory2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_profitlosshistory3" placeholder="" id="finmetric_profitlosshistory3" value="@if(isset($financialInformation['finmetric_profitlosshistory3'])){{ $financialInformation['finmetric_profitlosshistory3'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_profitlosscurrent" placeholder="" id="finmetric_profitlosscurrent" value="@if(isset($financialInformation['finmetric_profitlosscurrent'])){{ $financialInformation['finmetric_profitlosscurrent'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_profitlossprojected1" placeholder="" id="finmetric_profitlossprojected1" value="@if(isset($financialInformation['finmetric_profitlossprojected1'])){{ $financialInformation['finmetric_profitlossprojected1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_profitlossprojected2" placeholder="" id="finmetric_profitlossprojected2" value="@if(isset($financialInformation['finmetric_profitlossprojected2'])){{ $financialInformation['finmetric_profitlossprojected2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_profitlossprojected3" placeholder="" id="finmetric_profitlossprojected3" value="@if(isset($financialInformation['finmetric_profitlossprojected3'])){{ $financialInformation['finmetric_profitlossprojected3'] }}@endif">
                                            </td>
                                         </tr>
                                         <tr>
                                            <td>
                                                Balance Sheet
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_balancesheethistory1" placeholder="" id="finmetric_balancesheethistory1" value="@if(isset($financialInformation['finmetric_balancesheethistory1'])){{ $financialInformation['finmetric_balancesheethistory1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_balancesheethistory2" placeholder="" id="finmetric_balancesheethistory2" value="@if(isset($financialInformation['finmetric_balancesheethistory2'])){{ $financialInformation['finmetric_balancesheethistory2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_balancesheethistory3" placeholder="" id="finmetric_balancesheethistory3" value="@if(isset($financialInformation['finmetric_balancesheethistory3'])){{ $financialInformation['finmetric_balancesheethistory3'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_balancesheetcurrent" placeholder="" id="finmetric_balancesheetcurrent" value="@if(isset($financialInformation['finmetric_balancesheetcurrent'])){{ $financialInformation['finmetric_balancesheetcurrent'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_balancesheetprojected1" placeholder="" id="finmetric_balancesheetprojected1" value="@if(isset($financialInformation['finmetric_balancesheetprojected1'])){{ $financialInformation['finmetric_balancesheetprojected1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_balancesheetprojected2" placeholder="" id="finmetric_balancesheetprojected2" value="@if(isset($financialInformation['finmetric_balancesheetprojected2'])){{ $financialInformation['finmetric_balancesheetprojected2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_balancesheetprojected3" placeholder="" id="finmetric_balancesheetprojected3" value="@if(isset($financialInformation['finmetric_balancesheetprojected3'])){{ $financialInformation['finmetric_balancesheetprojected3'] }}@endif">
                                            </td>
                                         </tr>
                                         <tr>
                                            <td>
                                                # of employees
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_employeehistory1" placeholder="" id="finmetric_employeehistory1" value="@if(isset($financialInformation['finmetric_employeehistory1'])){{ $financialInformation['finmetric_employeehistory1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_employeehistory2" placeholder="" id="finmetric_employeehistory2" value="@if(isset($financialInformation['finmetric_employeehistory2'])){{ $financialInformation['finmetric_employeehistory2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_employeehistory3" placeholder="" id="finmetric_employeehistory3" value="@if(isset($financialInformation['finmetric_employeehistory3'])){{ $financialInformation['finmetric_employeehistory3'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_employeecurrent" placeholder="" id="finmetric_employeecurrent" value="@if(isset($financialInformation['finmetric_employeecurrent'])){{ $financialInformation['finmetric_employeecurrent'] }}@endif">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="finmetric_employeeprojected1" placeholder="" id="finmetric_employeeprojected1" value="@if(isset($financialInformation['finmetric_employeeprojected1'])){{ $financialInformation['finmetric_employeeprojected1'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_employeeprojected2" placeholder="" id="finmetric_employeeprojected2" value="@if(isset($financialInformation['finmetric_employeeprojected2'])){{ $financialInformation['finmetric_employeeprojected2'] }}@endif">
                                            </td>
                                             <td>
                                                <input type="text" class="form-control" name="finmetric_employeeprojected3" placeholder="" id="finmetric_employeeprojected3" value="@if(isset($financialInformation['finmetric_employeeprojected3'])){{ $financialInformation['finmetric_employeeprojected3'] }}@endif">
                                            </td>
                                         </tr>
                                    </table>

                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>In order to be eligible for Tier 1 funding plans must be documented to employ 2 full time staff for a minimum duration of 12 months each. Please indicate new staff positions and proposed commencement dates</label>
                                            <textarea class="form-control   text-input-status" name="info_staffposdate" placeholder=""  >@if(!empty($financialInformation) && isset($financialInformation['info_staffposdate'])){{ $financialInformation['info_staffposdate'] }}@endif</textarea>
                                            
                                        </div>      

                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>How would the £200,000 investment be used within the business?</label>
                                            <input type="text" class="form-control" name="info_investused" placeholder="" id="info_investused" value="@if(isset($financialInformation['info_investused'])){{ $financialInformation['info_investused'] }}@endif">
                                            
                                        </div>      

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Please state the preferred method of investment (e.g. Equity / Debt)</label>
                                            <input type="text" class="form-control" name="info_investmentmethod" placeholder="" id="info_investmentmethod" value="@if(isset($financialInformation['info_investmentmethod'])){{ $financialInformation['info_investmentmethod'] }}@endif">
                                            
                                        </div>      

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>What qualities or attributes of a new director would be most beneficial to the company?</label>
                                            <textarea class="form-control   text-input-status" name="info_directorquality" placeholder=""  >@if(!empty($financialInformation) && isset($financialInformation['info_directorquality'])){{ $financialInformation['info_directorquality'] }}@endif</textarea>
                                            
                                        </div>      

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Please provide your Executive Summary:</label>
                                            <textarea class="form-control   text-input-status" name="info_executivesummary" placeholder=""  >@if(!empty($financialInformation) && isset($financialInformation['info_executivesummary'])){{ $financialInformation['info_executivesummary'] }}@endif</textarea>
                                            
                                        </div>      

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Upload Tier1 Document</label>
                                            <div class="custom-control custom-radio custom-control-inline" id="upload-tier1-document">
                                              
                                              <div class="upload-files-section">
                                                  <button type="button" class="btn btn-primary text-right" id="tier1_document" object-type="App\BusinessListing" object-id="" file-type="tier1_document">Select File</button>
                                                  <input type="hidden" name="tier1_document" value="" class="uploaded-file-path">

                                                  <span class="file_name">
                                                    @php
                                                    if(!empty($tier1Document)){
                                                        $tier1Document['tier1_document'] = $tier1Document[0];
                                                    }
                                                    @endphp
                                                      {!! getbusinessUploadedFileNamesHtml($tier1Document,'tier1_document',$businessListing) !!}

                                                  </span>
                                                  <span class="deleted_files">

                                                  </span>
                                              </div>
                                              
                                            </div>
                                            
                                        </div>  


                                        <p>In order to be able to review your proposals</p>
                                        <div class="row upload-files-section">
                                           <div id="tier1-additional-doc" object-type="App\BusinessListing" object-id="" file-type="tier1_documents">
                                              <p></p>
                                           </div>
                                           <div class="uploaded-file-path"></div>
                                           <br>
                                           <div class="uploaded-files">
                                                @if(!empty($tier1AdditionalDocuments))
                                                    @foreach($tier1AdditionalDocuments as $tier1AdditionalDocument)
                                                    
                                                    <div>
                                                        <p class="multi_file_name">{{ $tier1AdditionalDocument['name'] }}  <a href="javascript:void(0)" class="delete-uploaded-file" file-id="{{ $tier1AdditionalDocument['fileid']}}"  object-type="App\BusinessListing" object-id="" type="tier1_additional_documents"><i class="fa fa-close" style="color: red"></i></a><input type="hidden" name="tier1_additional_documents_file_id[]" class="image_url" value="{{ $tier1AdditionalDocument['fileid'] }}"></p>
                                                    </div>
                                                    @endforeach
                                                   @endif
                                            </div>
                                            <span class="deleted_files">
                                            </span>
                                        </div>    

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
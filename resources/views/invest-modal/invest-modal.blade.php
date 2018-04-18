<!-- Modal -->


<!-- Subscription Form
In order to edit your investment please contact your Adviser or anyone in our team: 020 7071 3945 -->




@php 
$userId = Auth::id();

echo "<pre> Investor Data";
print_r($investor_data);
echo " Business Data";
print_r($business_data);
echo "</pre>";

$proposal_address = isset($business_data['proposal_details']['address'])?$business_data['proposal_details']['address']:'';
$company_number = isset($business_data['company_details']['number'])?$business_data['company_details']['number']:'';
$no_of_new_shares_issue = isset($business_data['proposal_details']['no-of-new-shares-issue'])?$business_data['proposal_details']['no-of-new-shares-issue']:'';

$share_class_issued =  isset($business_data['proposal_details']['share-class-issued'])?$business_data['proposal_details']['share-class-issued']:'';
$no_of_shares_issue =  isset($business_data['proposal_details']['no-of-shares-issue'])?$business_data['proposal_details']['no-of-shares-issue']:'';

$certification_title = isset($last_active_certification_data['certification_name'])?$last_active_certification_data['certification_name']:'';
$certification_slug = isset($last_active_certification_data['certification_name'])?$last_active_certification_data['certification_slug']:'';

$certification_date  = isset($last_active_certification_data['created_at'])?$last_active_certification_data['created_at']:'';
$certification_date_uk_format = $certification_date!=''? date('d/m/Y',strtotime($certification_date)):'';


$certification_active  = isset($last_active_certification_data['active'])?$last_active_certification_data['active']:'';

$existing_certification_status = "";
if($certification_active ==1){
  $existing_certification_status = "Certified";
}

$nomineeapplication_info = isset($nominee_data['nomineeapplication_info'])?$nominee_data['nomineeapplication_info']:[];

@endphp


<div class="modal fade" id="cust-invest-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subscription Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="edit_proposal_investor" class="">
          <input id="proposal_id_field" type="hidden"   name="proposal_id" value="{{$business_data['id']}}"></input>
          <input id="pledge_investment_id_field" type="hidden"  name="id" value=""></input>
          <input id="investor_id_field" type="hidden"  name="investor_id" value="{{$investor_data['id']}}"></input>
        </form>



        <form id="pledge_investment" name="pledge_investment">


        <input type="hidden" name="level-of-interest"  id="level-of-interest" value="ready-to-invest"/>
        <input type="hidden" name="preferd-contact" id="preferd-contact" value="email" >

        <input type="hidden" name="pledge_proposaltitle" id="pledge_proposaltitle" value="{{$business_data['title']}}"/>
        <input type="hidden" name="pledge_proposalcompany" id="pledge_proposalcompany" value="{{$business_data['title']}}"/>
        <input type="hidden" name="pledge_proposaladdress" id="pledge_proposaladdress" value="{{$proposal_address}}"/>
        <input type="hidden" name="pledge_companynumber" id="pledge_companynumber" value="{{$company_number}}"/>
        <input type="hidden" name="pledge_no-of-new-shares-issue" id="pledge_no-of-new-shares-issue" value="{{$no_of_new_shares_issue}}"/>
        <input type="hidden" name="pledge_share-price-curr-inv-round" id="pledge_share-price-curr-inv-round" value="{{$business_data['proposal_details']['share-price-curr-inv-round']}}"/>
        <input type="hidden" name="pledge_share-class-issued" id="pledge_share-class-issued" value="{{$share_class_issued}}"/>
        <input type="hidden" name="pledge_no-of-shares-issue" id="pledge_no-of-shares-issue" value="{{$no_of_shares_issue}}"/>
        <input type="hidden" name="pledge_nomineeverified" id="pledge_nomineeverified" value="<%= nominee_verified %>"/>
        <!-- <input type="hidden" name="lst_investment_for" id="lst_investment_for" value="< %= user.get('display_name') % >"/> -->
   
        <input type="hidden" name="pledge_companyaddress" id="pledge_companyaddress" value="{{$proposal_address}}" />
        <input type="hidden" name="pledge_investorcert_title" id="pledge_investorcert_title"  value="<%=existing_investor_certification_title%>">
        <input type="hidden" name="pledge_investorcert_date" id="pledge_investorcert_date"  value="<%=existing_investor_certification_date%>">
        <input type="hidden" name="pledge_investorcert_file" id="pledge_investorcert_file"  value="<%=existing_investor_certification_file%>">
        <input type="hidden" name="pledge_investorcert_role" id="pledge_investorcert_role"  value="<%=existing_certification_role%>">
        <input type="hidden" name="pledge_investorcert_status" id="pledge_investorcert_status"  value="{{$existing_certification_status}}">
        <input type="hidden" name="participation" id="participation" value="pledged"/>
        

          
        <div class="text-center">          
        	{{$business_data['title']}}<h4>(the "company")</h4>
        	<p>(Incorporated and registered in England <span class="spn_companynumber1">{{isset($business_data['company_details']['number'])?$business_data['company_details']['number']:''}})</span></p>
        	<h2>SHARE OFFER</h2>
        </div>

        <h4>Outline Terms of the Offer</h4>
        <p>The Company is offering up to <span class="spn_no-of-new-shares-issue1">{{$business_data['proposal_details']['no-of-new-shares-issue']}}</span> new ordinary shares in the share capital of the Company at a price of <span class="spn_share-price-curr-inv-round1">{{format_amount($business_data['proposal_details']['share-price-curr-inv-round'], 2,  false, false)}}</span> per <span class="spn_share-class-issued1">{{$business_data['proposal_details']['share-class-issued']}}</span> ("The Offer"). The Offer is made to raise (general working capital) for the Company, and on the basis that the current issued capital is <span class="spn_no-of-shares-issue1">{{$business_data['proposal_details']['no-of-shares-issue']}}</span> Ordinary Shares.</p>

        <h4>Procedure for Completion</h4>
        <ol class="pl-3">
        	<li>If you wish to invest as part of the Offer please complete in full the details requested at Sections 1 to 5 and then sign and date where indicated at Section 6.</li>
        	<li>Payment should be made in full on application. Please enclose a cheque made payable to "<span class="spn_tradingname1">{{$business_data['title']}}</span>", or transfer your funds to the bank account details of which are set out in Section 2 below.</li>
        </ol>

        <!-- accordion -->
        <div id="" role="tablist" class="gi-collapse">
          	<div class="card">
        	    <div class="card-header" role="tab" id="headingOne">
        	        <a data-toggle="collapse" href="#collapse-a" role="button">
        	          Section 1. Application for Shares – Your Details
        	          <i class="fa fa-lg fa-plus-square-o"></i>
        	          <i class="fa fa-lg fa-minus-square-o"></i>
        	        </a>
        	    </div>

        	    <div id="collapse-a" class="collapse show" role="tabpanel" >
        	    	<div class="card-body border mb-3">
        	    		<!-- <form> -->
        	    			<div class="form-group row mb-3">
        	    		    	<label class="col-sm-3 col-form-label">Mr, Mrs, Miss or Title:</label>
        	    		    	<div class="col-sm-9">
        	    		      		<input type="text" class="form-control" name="pledge_title" id="pledge_title"  value="{{isset($nomineeapplication_info['title'])?$nomineeapplication_info['title']:''}}"  >
        	    		    	</div>
        	    		  	</div>
        	    		  	<div class="form-group row mb-3">
        	    		    	<label class="col-sm-3 col-form-label">Forename(s) (in full): <span class="text-danger">*</span></label>
        	    		    	<div class="col-sm-9">
                            
                            <input type="hidden" name="lst_investment_for" id="lst_investment_for" value="<%=user.get('display_name')%>" />
                            @php
                            $forename = isset($nomineeapplication_info['forename'])?$nomineeapplication_info['forename']:$investor_data['first_name'];
                            /* if($forename==""){
                              $forename = $investor_data['first_name']." ".$investor_data['first_name'];
                            } */
                            @endphp
                            
        	    		      		<input type="text" class="form-control"  name="pledge_forename" id="pledge_forename"  value="{{$forename}}" readonly="readonly">


        	    		    	</div>
        	    		  	</div>
    	    		  		<div class="form-group row mb-3">
    	    		  	    	<label class="col-sm-3 col-form-label">Surname:</label>
    	    		  	    	<div class="col-sm-9">
                            @php
                            $lastname = isset($nomineeapplication_info['surname'])?$nomineeapplication_info['surname']:$investor_data['last_name'];                            
                            @endphp
    	    		  	      		<input type="text" class="form-control"  name="pledge_surname" id="pledge_surname" value="{{$lastname}}" readonly="readonly" >
    	    		  	    	</div>
    	    		  	  	</div>

    	    		  	  	<div class="row">
    	    		  	  		<div class="col-sm-6">
	    		  	  				<div class="form-group row mb-3">
	    		  	  			    	<label class="col-sm-6 col-form-label">Address in full:</label>
	    		  	  			    	<div class="col-sm-6">
	    		  	  			      		<textarea class="form-control" rows="2" name = "pledge_address" id = "pledge_address" 
                                  maxlength="450">{{isset($nomineeapplication_info['address'])?$nomineeapplication_info['address']:''}}</textarea>
	    		  	  			    	</div>
	    		  	  			  	</div>
    	    		  	  		</div>
    	    		  	  		<div class="col-sm-6">
	    		  	  				<div class="form-group row mb-3">
	    		  	  			    	<label class="col-sm-3 col-form-label">Postcode:</label>
	    		  	  			    	<div class="col-sm-9">
	    		  	  			      		<input type="text" class="form-control" name="pledge_postcode" id="pledge_postcode" 
                                 value="{{isset($nomineeapplication_info['postcode'])?$nomineeapplication_info['postcode']:''}}" >
	    		  	  			    	</div>
	    		  	  			  	</div>
    	    		  	  		</div>
    	    		  	  	</div>

	    		  	  		<div class="form-group row mb-3">
	    		  	  	    	<label class="col-sm-3 col-form-label">Email Address:</label>
	    		  	  	    	<div class="col-sm-9">
	    		  	  	      		<input type="email" class="form-control" name="pledge_email" id="pledge_email" value="{{isset($investor_data['email'])?$investor_data['email']:''}}">
	    		  	  	    	</div>
	    		  	  	  	</div>

	    		  	  	  	<div class="form-group row mb-3">
	    		  	  	    	<label class="col-sm-3 col-form-label">Daytime tel. no.</label>
	    		  	  	    	<div class="col-sm-9">
	    		  	  	      		<input type="text" class="form-control" name="pledge_telephone" id="pledge_telephone" value="{{isset($nomineeapplication_info['telephone'])?$nomineeapplication_info['telephone']:''}}">
	    		  	  	    	</div>
	    		  	  	  	</div>

    	    		  	  	<div class="row">
    	    		  	  		<div class="col-sm-6">
	    		  	  				<div class="form-group row mb-3">
	    		  	  			    	<label class="col-sm-6 col-form-label">Permanent address (if different from above)</label>
	    		  	  			    	<div class="col-sm-6">
	    		  	  			      		<textarea cols=" rows="2" class="form-control" name="pledge_address2" id="pledge_address2" maxlength="450">{{isset($nomineeapplication_info['address'])?$nomineeapplication_info['address']:''}}</textarea>
	    		  	  			    	</div>
	    		  	  			  	</div>
    	    		  	  		</div>
    	    		  	  		<div class="col-sm-6">
	    		  	  				<div class="form-group row mb-3">
	    		  	  			    	<label class="col-sm-3 col-form-label">Postcode:</label>
	    		  	  			    	<div class="col-sm-9">
	    		  	  			      		<input type="text" class="form-control" name="pledge_postcode2" id="pledge_postcode2" value="{{isset($nomineeapplication_info['postcode'])?$nomineeapplication_info['postcode']:''}}">
	    		  	  			    	</div>
	    		  	  			  	</div>
    	    		  	  		</div>
    	    		  	  	</div>

	    		  	  		<div class="form-group row mb-3">
    	    		  	  	  	<label class="col-sm-3 col-form-label">Date of Birth:</label>
    	    		  	  	  	<div class="col-sm-9">
    	    		  	  	    		<input type="date" class="form-control" name="pledge_dateofbirth" id="pledge_dateofbirth" value="{{isset($nomineeapplication_info['dateofbirth'])?$nomineeapplication_info['dateofbirth']:''}}">
    	    		  	  	  	</div>
	    		  	  		</div>

	    		  	  		<div class="form-group row mb-3">
    	    		  	  	  	<label class="col-sm-3 col-form-label">National Insurance No.</label>
    	    		  	  	  	<div class="col-sm-9">
    	    		  	  	    		<input type="text" class="form-control" name="pledge_nationalinsuranceno" id="pledge_nationalinsuranceno" placeholder="" value="{{isset($nomineeapplication_info['nationalinsuranceno'])?$nomineeapplication_info['nationalinsuranceno']:''}}" maxlength="9">
    	    		  	  	  	</div>
	    		  	  		</div>
							
							<div class="bg-gray p-2">
	    	    		  	  	<div class="row mt-3">
	    	    		  	  		<div class="col-sm-6">
	    	    		  	  			<div class="form-group row mb-3">
	    	    		  	  		    	<label class="col-sm-6 col-form-label">Investment Amount:</label>
	    	    		  	  		    	<div class="col-sm-6">
	    	    		  	  		      		<div class="input-group">
  						    	    		  	  	<div class="input-group-prepend border-bottom">
  						    	    		  	  		<span class="input-group-text border-0">&pound;</span>
  						    	    		  	  	</div>
  					    	    		  	  		<input type="number" class="form-control allow_decimal_postive_negative_commas" name="pledge_desiredinvestment" id="pledge_desiredinvestment">
  					    	    		  	  	</div>
	    	    		  	  		    	</div>
	    	    		  	  		  	</div>
	    	    		  	  		</div>
	    	    		  	  		<div class="col-sm-6">
		    		  	  				<div class="form-group row mb-3">
		    		  	  			    	<label class="col-sm-12 col-form-label">(Minimum Investment: £ 5,000.00 )</label>
		    		  	  			  	</div>
	    	    		  	  		</div>
	    	    		  	  	</div>

	    	    		  	  	<div class="row">
	    	    		  	  		<div class="col-sm-6">
	    	    		  	  			<div class="form-group row mb-3">
	    	    		  	  		    	<label class="col-sm-6 col-form-label">Price per share:</label>
	    	    		  	  		    	<div class="col-sm-6">
	    	    		  	  		      		<div class="input-group">
  						    	    		  	  	<div class="input-group-prepend border-bottom">
  						    	    		  	  		<span class="input-group-text border-0">&pound;</span>
  						    	    		  	  	</div>
  					    	    		  	  		<input type="number" class="form-control allow_decimal_postive_negative_commas" 
                                          name="pledge_pricepershare" id="pledge_pricepershare" value="{{$business_data['proposal_details']['share-price-curr-inv-round']}}" readonly="readonly">
  					    	    		  	  	</div>
	    	    		  	  		    	</div>
	    	    		  	  		  	</div>
	    	    		  	  		</div>
	    	    		  	  		<div class="col-sm-6">
		    		  	  				<label>SEIS/EIS relief sought?</label>
  	  									<div class="d-sm-inline ml-sm-3">
  	  										<div class="custom-control custom-radio custom-control-inline">
  	  										  <input type="radio" class="custom-control-input" name="pledge_iseisseis">
  	  										  <label class="custom-control-label" for="yes2">Yes</label>
  	  										</div>
  	  										<div class="custom-control custom-radio custom-control-inline">
  	  										  <input type="radio" class="custom-control-input" name="pledge_iseisseis" value="No">
  	  										  <label class="custom-control-label" for="no2">No</label>
  	  										</div>
  	  									</div>
	    	    		  	  		</div>
	    	    		  	  	</div>

	    	    		  	  	<div class="row">
	    	    		  	  		<div class="col-sm-6">
    	    		  	  				<div class="form-group row mb-3">
    	    		  	  			    	<label class="col-sm-6 col-form-label">Number of Shares:</label>
    	    		  	  			    	<div class="col-sm-6">
    	    		  	  			      		<input type="text" class="form-control" name="pledge_nosharesrequested" id="pledge_nosharesrequested" readonly="readonly">
    	    		  	  			    	</div>
    	    		  	  			  	</div>
	    	    		  	  		</div>
	    	    		  	  		<div class="col-sm-6">
		    		  	  				<small class="form-text text-muted">
		    		  	  					It is only possible to subscribe to a complete whole number of shares. The Required Investment field will automatically calculate the final investment amount for the nearest whole number of shares, based on the initial value entered in the Investment Amount field
		    		  	  				</small>
	    	    		  	  		</div>
	    	    		  	  	</div>

	    	    		  	  	<div class="row">
	    	    		  	  		<div class="col-sm-6">
    	    		  	  				<div class="form-group row mb-3">
    	    		  	  			    	<label class="col-sm-6 col-form-label">Required Investment: <span class="text-danger">*</span></label>
    	    		  	  			    	<div class="col-sm-6">
    	    		  	  			      		<div class="input-group">
  						    	    		  	  	<div class="input-group-prepend border-bottom">
  						    	    		  	  		<span class="input-group-text border-0">&pound;</span>
  						    	    		  	  	</div>
  					    	    		  	  		<input type="number" class="form-control allow_decimal_postive_negative_commas" name="max_inv_planned" id="max_inv_planned"  readonly="readonly" >
  					    	    		  	  	</div>
    	    		  	  			    	</div>
    	    		  	  			  	</div>
	    	    		  	  		</div>
	    	    		  	  	</div>
    	    		  	  	</div>
        	    		<!-- </form> -->
        	    	</div>
        	    </div>
        	</div>

          	<div class="card">
        	    <div class="card-header" role="tab" id="headingOne">
        	        <a data-toggle="collapse" href="#collapse-b" role="button" class="collapsed">
        	          Section 2: Your Subscription
        	          <i class="fa fa-lg fa-plus-square-o"></i>
        	          <i class="fa fa-lg fa-minus-square-o"></i>
        	        </a>
        	    </div>

        	    <div id="collapse-b" class="collapse show" role="tabpanel" >
        	    	<div class="card-body border mb-3">
        	    		<p>By completing and returning this form, you are agreeing to subscribe for {{isset($business_data['proposal_details']['share-class-issued'])?$business_data['proposal_details']['share-class-issued']:" Unknown "}}<!-- Ordinary Shares --> shares as part of the Offer on the following terms:-</p>
	    		        <ol class="pl-3" type="i">
	    					<li>You agree to provide any information (including any proof of identity requests) reasonably required by the Company or its solicitors in order to process your application for shares.</li>
	    					<li>You agree to subscribe for the number of {{isset($business_data['proposal_details']['share-class-issued'])?$business_data['proposal_details']['share-class-issued']:" Unknown "}}<!-- Ordinary Shares --> shares stated above, or such lower number in the event of oversubscription (hereinafter “Your Shares”), subject to the memorandum and articles of association of the Company, as part of the Offer.</li>
	    					<li>Where applicable you undertake to sign a Deed of Adherence to the Shareholders Agreement of the Company</li>
	    					<li>You enclose a cheque or you have arranged an electronic transfer of funds in payment of the sum referred to above, to the account detailed below in this section, being the amount payable in full on application for the stated number of {{isset($business_data['proposal_details']['share-class-issued'])?$business_data['proposal_details']['share-class-issued']:" Unknown "}}<!-- Ordinary Shares -->.</li>
	    					<li>You understand that the completion and delivery of this application form accompanied by a cheque constitutes an undertaking that the cheque will be honoured on first presentation.</li>
	    					<li>You understand that no application will be accepted unless and until payment in full for Your Shares has been made.</li>
	    					<li>You understand that the Company will send you a share certificate by post at your risk to the address given in Section 1 below for Your Shares.</li>
	    					<li>You agree to accept the above shares when allotted to you subject to the terms of the Memorandum and Articles of Association of the Company and you hereby authorise us to place your name in the Register of Members of the Company as the holder of those shares.</li>
	    				</ol>

	    				<p>The Company undertakes, where there is a minimum overall subscription level, to hold your money in a segregated account until such a time as the minimum subscription level is met.</p>
						
						<h5 class="mb-3">Bank Transfer Details:</h5>
	    				<!-- <form action=""> -->
    						<div class="form-group row">
    					    	<label class="col-sm-3 col-form-label">A/C Name:</label>
    					    	<div class="col-sm-9">
    					      		<input type="text" class="form-control" name="pledge_subsaccountname" id="pledge_subsaccountname" value="P1 GROWTHINVEST" readonly="readonly">
    					    	</div>
    					  	</div>

					  		<div class="form-group row">
					  	    	<label class="col-sm-3 col-form-label">A/C Number:</label>
					  	    	<div class="col-sm-9">
					  	      		<input type="text" class="form-control" name="pledge_bankaccntnumber" id="pledge_bankaccntnumber" maxlength="8" value="03692051" readonly="readonly">
					  	    	</div>
					  	  	</div>

				  	  		<div class="form-group row">
				  	  	    	<label class="col-sm-3 col-form-label">Sort Code:</label>
				  	  	    	<div class="col-sm-9">
				  	  	      		<input type="text" class="form-control" name="pledge_bankaccntsortcode" id="pledge_bankaccntsortcode" maxlength="6" value="400530" readonly="readonly">
				  	  	    	</div>
				  	  	  	</div>

			  	  	  		<div class="form-group row">
			  	  	  	    	<label class="col-sm-3 col-form-label">Bank:</label>
			  	  	  	    	<div class="col-sm-9">
			  	  	  	      		<input type="text" class="form-control" name="pledge_subsbankname" id="pledge_subsbankname" value="HSBC" readonly="readonly">
			  	  	  	    	</div>
			  	  	  	  	</div>

		  	  	  	  		<div class="form-group row">
		  	  	  	  	    	<label class="col-sm-3 col-form-label">Reference:</label>
		  	  	  	  	    	<div class="col-sm-9">
                              @php
                                $refname = $investor_data['first_name']." ".$investor_data['last_name']."/".$business_data['title'];
                                if(!is_null($investor_data['p1code']) && $investor_data['p1code'] !="" ){
                                    $refname.="/".$investor_data['p1code'];
                                }
                              @endphp                            
		  	  	  	  	      		<input type="text" class="form-control" placeholder="FULL NAME OF APPLICANT" name="pledge_reffullname" id="pledge_reffullname" value="{{$refname}}">
		  	  	  	  	    	</div>
		  	  	  	  	  	</div>
	    			<!-- 	</form> -->
        	    	</div>
        	    </div>
        	</div>

        	<!-- collapse3 -->
    	  	<div class="card">
    		    <div class="card-header" role="tab" id="headingOne">
    		        <a data-toggle="collapse" href="#collapse-c" role="button" class="collapsed">
    		          Section 3: Procedure for Investment
    		          <i class="fa fa-lg fa-plus-square-o"></i>
    		          <i class="fa fa-lg fa-minus-square-o"></i>
    		        </a>
    		    </div>

    		    <div id="collapse-c" class="collapse show" role="tabpanel" >
    		    	<div class="card-body border mb-3">
                @php 
                if($business_data['proposal_details']['deadline-subscription']!="" && !is_null($business_data['proposal_details']['deadline-subscription'])){
                  $deadline_subscription = date("d/m/Y",strtotime($business_data['proposal_details']['deadline-subscription']));
                }
                else{
                  $deadline_subscription = "04/04/2017";
                }
                $formated_deadline = date("jS F Y",strtotime($deadline_subscription));
                @endphp

                


    		    		<p>Once completed please return this subscription form to <span class="spn_tradingname1">{{$business_data['title']}}</span>, c/o GrowthInvest, 120 Cannon Street, London, EC4N 6AS to arrive no later than 12 noon on {{$formated_deadline}}. Also please scan and email a copy to <a href="support@growthinvest.com">support@growthinvest.com</a> with email subject '<span class="spn_tradingname1">{{$business_data['title']}}</span> Subscription'.</p>
    		    	</div>
    		    </div>
    		</div>
        	<!-- /collapse3 -->

	    	<!-- collapse4 -->
		  	<div class="card">
			    <div class="card-header" role="tab" id="headingOne">
			        <a data-toggle="collapse" href="#collapse-d" role="button" class="collapsed">
			          Section 4: Confirmation of Status
			          <i class="fa fa-lg fa-plus-square-o"></i>
			          <i class="fa fa-lg fa-minus-square-o"></i>
			        </a>
			    </div>

			    <div id="collapse-d" class="collapse show" role="tabpanel" >
			    	<div class="card-body border mb-3">
			    		<p>Under terms of the Financial Services and Markets Act 2000 (“FSMA”) and the Financial Services and Markets Act 2000 (Financial Promotion) Order 2005 (as amended) ("FSMAO"), the Company will only accept an application for shares if you are accurately categorised as an investor by an FCA authorised entity. The authorised entity would normally be either GrowthInvest (regulated as EIS Platforms Ltd by the FCA), or an authorised UK financial adviser or wealth manager. Please confirm that the below categorisation is still accurate and if not please <a href="{{ url('/backoffice/investor/')}}/{{$investor_data['gi_code']}}/client-categorisation">click here</a> to update your categorisation before completing this application</p>

			    		<p><strong>Certification:</strong> <span class="spn_certificationtitle1">
           
                @php 
                $certification_link ="";
                if($certification_active!=1){ 
                   
                   $certification_link =  url('/backoffice/investor/').'/'.$investor_data['gi_code'].'/client-categorisation';
                }
                @endphp

                @if($certification_active!=1)
                 Not currently valid – Please <a href="{{$certification_link}}">click here</a> to  update
                @else
                  {{$certification_title}}     
                @endif
            
              </span></p>
              
			    		<p>Date: <span class="spn_certificationdate1"> 
                @if($certification_active!=1)
                 Not currently valid – Please <a href="{{$certification_link}}">click here</a> to  update
                @else
                  {{$certification_date}}     
                @endif
                
              </span></p>


              @if( $existing_certification_status!='Expired' && $certification_title!='' )
             

              <input type="hidden" name="existing_certification" id="existing_certification" value="{{$certification_slug}}" class="form-control" >
              <input type="hidden" name="existing_certification_status" id="existing_certification_status" value="{{$existing_certification_status}}" class="form-control" >


         
              <div class="row">

                  <div class="row note-msg">
                      <div class="col-md-5">
                          <h5 class="text-muted text-left">  <img class="icon-certificate bg-background img-responsive" src="{{url('/img/document287.png')}}"/><span class="spn_certificationtitle">{{$certification_title}}</span></h5>
                      </div>
                      <div class="col-md-7">
                          <div class="pull-left l-30">
                                           
                                          @if($existing_certification_status == 'Expired') 
                                           
                                                  <span class="text-primary pull-left" style="padding:9px;">Date Expired </span>
                                                  <button type="button" class="btn btn-danger btn-sm pull-left btn_recertify"
                                                          content_holder_id="statement-div2" certification="retail_restricted_investor">Re-Certify</button>
                                           
                                          @else 

                                                  @php
                                                  $valid_for = getRemainingCertificationExpirydisplayTime($certification_date_uk_format);
                                                  @endphp 
                                                 
                                                  <i class="icon icon-ok text-success"></i> Certified on
                                                  <span class="date-rem">
                                                      {{$certification_date_uk_format}}
                                                      <!-- <a href="<%=SITEURL%>/download-files/?object_type=userdocs&fl=<%=existing_investor_certification_file%>&u_id=<%=user.id%>" target="_blank">(Click to download)</a> -->
                                                      <a href="javascript:void(0);">Click to download)</a>
                                                  </span>&nbsp;
                                                  <div class="text-danger">
                                                      @if($valid_for!="")
                                                      valid for {{$valid_for}}
                                                      @endif
                                                  </div>
                                          @endif
                          </div>
                      </div>
                  </div>
              </div>
              @endif



			    	</div>
			    </div>
			</div>
	    	<!-- /collapse4 -->

	    	<!-- collapse5 -->
		  	<div class="card">
			    <div class="card-header" role="tab" id="headingOne">
			        <a data-toggle="collapse" href="#collapse-e" role="button" class="collapsed">
			          Section 5: Verification of Identity
			          <i class="fa fa-lg fa-plus-square-o"></i>
			          <i class="fa fa-lg fa-minus-square-o"></i>
			        </a>
			    </div>

			    <div id="collapse-e" class="collapse show" role="tabpanel" >
			    	<div class="card-body border mb-3">
			    		<p>In order to invest all investors must go through identity checks, which include Know Your Client and Anti Money Laundering processes. This can be done online at GrowthInvest.com, and will be carried out by GrowthInvest approved partner <a href="https://onfido.com/" target="_blank">Onfido.com</a>. If you have not yet been through the verification process, please click here to request prior to completing the application.</p>
			    	</div>
			    </div>
			</div>
	    	<!-- /collapse5 -->

	    	<!-- collapse6 -->
		  	<div class="card">
			    <div class="card-header" role="tab" id="headingOne">
			        <a data-toggle="collapse" href="#collapse-f" role="button" class="collapsed">
			          Section 6: Signature
			          <i class="fa fa-lg fa-plus-square-o"></i>
			          <i class="fa fa-lg fa-minus-square-o"></i>
			        </a>
			    </div>

			    <div id="collapse-f" class="collapse show" role="tabpanel" >
			    	<div class="card-body border mb-3">
			    		<div class="row">
			    			<div class="col-md-12">
			    				<p>I hereby apply for Offers Shares in , and agree to adhere to terms and conditions of Offer</p>
			    			</div>
			    			<div class="col-md-12">
			    				<div class="row">
			    					<div class="col-sm-6 border-sm-right border-0">
			    						<div class="form-group">
			    							<label for="">Signature:</label>
			    							<div class="border p-3 w-100"></div>
			    						</div>

			    						<div class="form-group">
			    							<strong>Name:</strong> <span>admin</span>
			    						</div>
			    					</div>
			    					<div class="col-sm-6">
			    						<div class="form-group">
			    							<label for="">Date: </label> <span></span>
			    						</div>
			    					</div>
			    				</div>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			</div>
	    	<!-- /collapse6 -->

	    	

	    	<div class="text-left text-sm-center mb-4">
	    		<a href="javascript:void(0);" class="btn btn-primary" id="btn_investform">Invest</a>
	    		<a href="javascript:void(0);" class="float-sm-right float-sm-left btn btn-outline-danger" data-dismiss="modal">Cancel</a>
	    	</div>

        <input type="hidden" name="investsubmitted"  id="investsubmitted"  value="no" />
        <div id="investment_thanks" class="m-b-5" style="text-align: center;"></div>
        <div id="investment_msg" class="m-b-5" style="text-align: center;"></div>



	    	<p><strong>Note:</strong> Once the form is complete, please either click on the Invest button in order to start our online electronic signature process, which is run by our partners Adobe E-sign, or please use the Download button to download the pre-populated form as a PDF which can be printed, signed, and sent to , c/o GrowthInvest, 120 Cannon Street, London EC4N 6AS.</p>

	    	<a href="" class="btn btn-primary"><i class="fa fa-download"></i> Download</a>
	    	<small class="text-muted form-text">Please note: A download will only include all investment and financial details if the user has submitted the application by clicking "Invest"</small>
        </div>
        <!-- /accordion -->
        </form>
      </div> <!-- Modal Body End-->      
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>




<!-- invest confirm modal -->
<div class="modal fade" id="invest-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn_cancel_conf_investment"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation of Investment</h4>
      </div>
      <div class="modal-body">
        <div class="pledgemsg"></div>
        @if($userId != $investor_data['id'])           

          <div class="checkbox p-l-0">
              <label>
                <input type="checkbox" name="cert_send_to_investor"  id="cert_send_to_investor" value="" >Send to investor for e-signature 
              </label>
            </div>


              <div class="checkbox p-l-0">
              <label>
                <input type="checkbox" name="cert_send_to_advisor"  id="cert_send_to_advisor" value="" >Send copy of e-signature email to adviser 
              </label>
            </div>

        @endif
      </div>
      <div class="modal-footer clearfix">
        
        <!-- <button type="button" class="btn btn-primary" id="btn_proceed_investment_confirmation">Proceed</button> -->
        <div id="mailpdf_msg" class="text-left"></div>

        

    <div class="clearfix">
          <button type="button" modal-type ="<%=modal_type%>" aria-hidden="true" class="btn button pull-left" id="update_proposal" value=""  data-toggle="modal" data-target="#invest-confirm">Proceed</button>
          <button type="button" class="btn btn-default btn_cancel_conf_investment pull-right" >Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End invest confirm modal -->
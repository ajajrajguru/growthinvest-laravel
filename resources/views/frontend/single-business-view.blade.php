@extends('layouts.frontend')


@section('frontend-content')

 @section('css')

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css" /> -->
@endsection


@section('js')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script> -->
<script src="{{ asset('/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>

<script>
	$( document ).ready(function() {
		// knob
	    $('.knob').each(function() {
        	var $this = $(this);
           	var myVal = $this.attr("rel");
           	$this.knob({
           		'readOnly': true
           	});
           	$({
            	value: 0
           	}).animate({
            	value: myVal
           	}, {
            	duration: 1000,
            	easing: 'swing',
            	step: function() {
                	$this.val(Math.ceil(this.value)).trigger('change');
              	}
           });
	    });

	    $('[data-toggle="tooltip"]').tooltip();
	});
	
</script>
@endsection

@section('content')
<div class="container pb-5">
	<div class="row proposal-info-card">
		<div class="col-sm-9">
			<div class="row">
				<div class="col-sm-3">
					<div class="card proposal-logo_holder d-table">
						<div class="d-table-cell align-middle">
							<img src="https://dummyimage.com/180x100" alt="" class="proposal-logo img-fluid">
						</div>
						<a href="" class="due-diligence">
							<img src="https://dummyimage.com/50x50" alt="" class="img-fluid">
						</a>
					</div>
				</div>
				<div class="col-sm-9 text-center text-sm-left pl-0 proposal-info">
					<ul class="mb-0 pl-0">
						<li class="list-inline-item">
							<span class="tag bg-primary">
								@foreach($tax_status as $t_status)
									{{strtoupper($t_status)}},
								@endforeach
							</span>
						</li>
						<li class="list-inline-item">
							@if($round!='')
								{{get_ordinal_number($round)}} round
							@endif
						</li>
					</ul>
					<h3 class="">{{$title}}</h3>
					<p class="mb-0"><i class="fa fa-map-marker text-white"></i> {{$proposal_details['address']}}</p>
					<p class="mb-0"><i class="fa fa-globe text-white"></i> <a href="">{{$proposal_details['website']}}</a></p>
				</div>
			</div>
		</div>
		<div class="col-sm-3 d-flex align-items-sm-center justify-content-sm-end justify-content-center mt-sm-0 mt-3">
			<div class="text-sm-right text-center">
				<ul class="mb-2 pl-0 social-icons">
					<li class="list-inline-item">
						<a href="{{$proposal_details['social-facebook']}}" target="_blank"><i class="fa fa-facebook-f"></i></a>
					</li>
					<li class="list-inline-item">
						<a href="{{$proposal_details['social-twitter']}}"  target="_blank"><i class="fa fa-twitter"></i></a>
					</li>
					<li class="list-inline-item">
						<a href="{{$proposal_details['social-linkedin']}}"  target="_blank"><i class="fa fa-linkedin"></i></a>
					</li>
					<li class="list-inline-item">
						<a href="{{$proposal_details['social-companyhouse']}}"  target="_blank" data-toggle="tooltip" title="Companies House"><img src="{{ url('img/company-house.png') }}" class="img-fluid" style="max-width: 70%;"></a>
					</li>
				</ul>
				<a href="" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>
			</div>
			
		</div>
	</div>
	<div class="row mt-3 mb-3">
		<div class="col-sm-8 text-center text-sm-left">
			<a href="" class="btn btn-outline-primary"><i class="fa fa-plus"></i> ADD TO WATCHLIST</a>
		</div>
		<div class="col-sm-4 text-center mt-2 mt-sm-0">
			<a href="" class="btn btn-primary btn-lg"> Invest Now</a>
		</div>
	</div>
	<div class="row border">
		<div class="col-sm-8 bg-white">
			@if($type=="proposal")
				<!-- Proposal -->
				<p class="mt-3">{{$proposal_details['business_proposal_details']}}</p>
				<hr>

				<div class="row">
					<div class="col-sm-6">
						<div class="">
							<label>BUSINESS SECTOR</label>
							<div> 
								@php
								$cnt_business_sectors = 0;
								@endphp
								@foreach($business_sectors as $biz_sector)
									@if($cnt_business_sectors>0)									,
									@endif
									{{$biz_sector['name']}}
									@php
									$cnt_business_sectors++;
									@endphp
								@endforeach
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="mt-3 mt-sm-0">
							<label>STAGE OF BUSINESS</label>
							 
								@foreach($stages_of_business as $stage)								 
									<div>{{$stage['name']}}</div>
								@endforeach
							
						</div>
					</div>
				</div>
				<hr>

				<div>
					<label>MILESTONES</label>
					@foreach($milestones as $milestone)
						<div><span class="badge badge-dark p-1">{{$milestone['name']}}</span></div>	
					@endforeach
					
				</div><hr>
			<!-- /Proposal-->

			
			@elseif($type=="fund")
				<!-- funds -->
				<h5 class="section-title font-weight-medium text-primary mt-3 mb-3">Fund Information</h5>
				<div class="row">
					<div class="col-sm-3"><label for="">Fund Name</label></div>
					<div class="col-sm-9">{{$title}}</div>
				</div><hr>
				<div class="row">
					<div class="col-sm-3"><label for="">Fund Summary:</label></div>
					<div class="col-sm-9">{{$proposal_details['business_proposal_details']}}</div>
				</div><hr>
				<div class="row">
					<div class="col-sm-3"><label for="">Fund Manager:</label></div>
					<div class="col-sm-9">{{$manager}}</div>
				</div><hr>
				<div class="row">
					<div class="col-sm-3"><label for="">Company Website:</label></div>
					<div class="col-sm-9"><a href="">{{$proposal_details['website']}}</a></div>
				</div><hr>
				<div class="row">
					<div class="col-sm-3"><label for="">Nominee & Custody:</label></div>
					<div class="col-sm-9">{{$fund_nominee_custody}}</div>
				</div>
				
				<div class="row mt-3 border-top border-bottom">
					<div class="col-sm-6 border-sm-right border-right-0 py-3">
						<div class="row mb-3">
							<div class="col-sm-6"><label for="">Fund Tax Status:</label></div>
							<div class="col-sm-6">
								@foreach($tax_status as $t_status)
									{{strtoupper($t_status)}},
								@endforeach
							</div>
						</div>
						@if(in_array('vct',$tax_status))
							<!--VCT funds -->
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">VCT Type:</label></div>
								<div class="col-sm-6">
									{{str_replace('_',' ',ucfirst($fundvct_details['vcttype']))}}
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Investment Strategy:</label></div>
								<div class="col-sm-6">
									@if(is_null($fundvct_details['investmentstrategy'] || $fundvct_details['investmentstrategy']==''))
									 	- 
									@elseif($fundvct_details['investmentstrategy']=='aim') 
										AIM
									@elseif($fundvct_details['investmentstrategy']!='')
										{{str_replace('_',' ',ucfirst($fundvct_details['investmentstrategy']))}}
									@endif

								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">AIC Sector:</label></div>
								<div class="col-sm-6">
									@if(is_null($fundvct_details['aicsector'] || $fundvct_details['aicsector']==''))
										- 
									@elseif($fundvct_details['aicsector']!='')
										{{str_replace('_',' ',ucfirst($fundvct_details['aicsector']))}}
									@endif
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Target Dividend:</label></div>
								<div class="col-sm-6">
									{{str_replace('_',' ',ucfirst($fundvct_details['targetdividend']))}}
								</div>
							</div>
							<!-- /VCT funds -->

						@else
							<!-- Non VCT funds -->
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Investment Sector:</label></div>
								<div class="col-sm-6">
									@php
									$cnt_business_sectors = 0;
									@endphp
									@foreach($business_sectors as $biz_sector)
										@if($cnt_business_sectors>0)									,
										@endif
										{{$biz_sector['name']}}
										@php
										$cnt_business_sectors++;
										@endphp
									@endforeach								
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Target Return:</label></div>
								<div class="col-sm-6">{{$fund_targetreturn}}</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Investment Focus:</label></div>
								<div class="col-sm-6">{{$investment_objective}}</div>
							</div>
							<!-- /Non VCT funds -->
						@endif
					</div>
					<div class="col-sm-6 py-3">
						<div class="row mb-3">
							@if(!in_array('vct',$tax_status))
								<!-- Non VCT Funds -->
								<div class="col-sm-6"><label for="">Fund Status:</label></div>
								<div class="col-sm-6">
									@php
										$display_fund_status ="";
										if(isset($fund_openclosed)){
											switch($fund_openclosed){
												case 'open' :
													$display_fund_status ="Open";
		                                        	break;
		                          				case 'closed':
		                          					$display_fund_status ="Closed Fund";
		                                        	break;
		                          				case 'evergreen':
		                          					$display_fund_status ="Evergreen";
		                                        	break;
		                                     }
										}   
										 
									@endphp	
									{{$display_fund_status}}							
								</div>
								<!-- /Non VCT Funds -->
							@endif
						</div>
						<div class="row mb-3">
							<div class="col-sm-6"><label for="">Launch Date:</label></div>
							<div class="col-sm-6">{{$fund_launchdate}}</div>
						</div>
						@if(!in_array('vct',$tax_status) && $fund_openclosed!='evergreen')
								<div class="row mb-3">
									<div class="col-sm-6"><label for="">Close Date:</label></div>
									<div class="col-sm-6">{{$fund_closedate}}</div>
								</div>							 
						@endif
						@if(in_array('vct',$tax_status))
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Deadline Date:</label></div>
								<div class="col-sm-6">{{$fundvct_details['deadlinedate']}}</div>
							</div>
						@endif
					</div>
				</div>
				
				<div class="row border-bottom mb-3">
					<div class="col-sm-6 border-sm-right border-right-0 pt-3">
						@if(!in_array('vct',$tax_status))
							<!-- Non VCT Fund -->
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Maximum Fund Size::</label></div>
								<div class="col-sm-6">{{format_amount($target_amount, 0, true, true)}}</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Minimum Fund Size:</label></div>
								<div class="col-sm-6">{{format_amount($proposal_details['minimum-raise'], 0, true, true)}}</div>
							</div>
							<!-- /Non VCT Fund -->
						@endif	
						<div class="row mb-3">
							<div class="col-sm-6"><label for="">Maximum Investment:</label></div>
							<div class="col-sm-6">{{format_amount($maximum_investment, 0, true, true)}}</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm-6"><label for="">Minimum Investment:</label></div>
							<div class="col-sm-6">{{format_amount($minimum_investment, 0, true, true)}}</div>
						</div>
						@if(!in_array('vct',$tax_status))
							<!-- Non VCT Funds -->
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Funds Raised:</label></div>
								<div class="col-sm-6">{{$proposal_details['fund_fundraisedstatic']}}</div>
							</div>
							<!-- /Non VCT Funds -->
						@elseif(in_array('vct',$tax_status))
							<!-- VCT Funds -->
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Overall Offer Size:</label></div>
								<div class="col-sm-6">{{isset($fundvct_details['vcttype'])?$fundvct_details['overalloffersize']:'-'}}</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Funds Raised to date:</label></div>
								<div class="col-sm-6">{{$fundvct_details['fundstaisedtodate']}}</div>
							</div>
							<!-- /VCT Funds -->
						@endif
					</div>
					<div class="col-sm-6 pt-3">
						<div class="row mb-3">
							<div class="col-sm-6"><label for="">Initial Charge:</label></div>
							<div class="col-sm-6">{{$fundcharges_details['initialcharge']!=''?$fundcharges_details['initialcharge']."%":"-"}}</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm-6"><label for="">Annual Management Charge:</label></div>
							<div class="col-sm-6">{{$fundcharges_details['annualmanagementfee']!=''?$fundcharges_details['annualmanagementfee']."%":"-"}}</div>
						</div>
						@if(in_array('vct',$tax_status))
							<!-- VCT Type Fund -->
							<div class="row mb-3">
								<div class="col-sm-6"><label for="">Growthinvest Discount:</label></div>
								<div class="col-sm-6">{{$fundvct_details['growthinvestdiscount']!=''?$fundvct_details['growthinvestdiscount']:"-"}}</div>
							</div>
							<!-- /VCT Type Fund -->
						@endif
						<div class="row mb-3">
							<div class="col-sm-6"><label for="">Performance Fee:</label></div>
							<div class="col-sm-6">{{$fundcharges_details['performancefee']!=''?$fundcharges_details['performancefee']."%":"-"}}</div>
						</div>
						<div class="row mb-3">
							<div class="col-sm-6"><label for="">Performance Hurdle:</label></div>
							<div class="col-sm-6">{{$fundcharges_details['performancehurdle']}}</div>
						</div>
					</div>
				</div>
				
				<!-- /funds -->
			@endif

			
			
			<div class="mb-3">
				<label>DOWNLOADS</label>
				<div>
					<a href="" class="btn btn-primary mb-2 mb-sm-0"><i class="fa fa-download"></i> SUMMARY</a>
					<a href="" class="btn btn-primary mb-2 mb-sm-0"><i class="fa fa-download"></i> DD REPORT</a>
					<a href="" class="btn btn-primary mb-2 mb-sm-0"><i class="fa fa-download"></i> INFORMATION MEMORANDUM</a>
					<a href="" class="btn btn-primary mb-2 mb-sm-0"><i class="fa fa-download"></i> APPLICATION FORM</a>
				</div>
			</div>

		</div>
		@include('frontend.single-business.investment-card')
	</div>
</div> <!-- /container -->

<div class="pt-4 pb-4" style="background: #eee;">
	<div class="container">
		<div class="d-sm-flex justify-content-between align-items-center">
			<div class="col-12 col-sm-4">
				<p class="list-inline-item mb-0">SHARE ON</p>
				<ul class="mb-0 pl-0 list-inline-item">
					<li class="list-inline-item">1</li>
					<li class="list-inline-item">2</li>
					<li class="list-inline-item">3</li>
					<li class="list-inline-item">4</li>
				</ul>
			</div>
			<div class="col-12 col-sm-8 text-sm-right mt-sm-0 mt-3">
				<a href="" class="btn btn-primary mb-1 mb-sm-0">Request a Call</a>
				<a href="" class="btn btn-primary mb-1 mb-sm-0">Request Additional Information</a>
			</div>
		</div>
	</div> <!-- /container -->
</div>

<div class="pt-4 pb-4">
	<div class="container">
		<!-- tabs -->
		<div class="squareline-tabs">
			<ul class="nav nav-tabs">
				@if($type=="proposal")
				<li class="nav-item">
			   		<a class="nav-link active d-none d-sm-block" data-toggle="tab" href="#business-idea">Business Idea</a>
				</li>
				<li class="nav-item">
			    	<a class="nav-link d-none d-sm-block" data-toggle="tab" href="#financial-projections">Financial Projections</a>
				</li>
				<li class="nav-item">
			    	<a class="nav-link d-none d-sm-block" data-toggle="tab" href="#company-details">Company Details</a>
				</li>
				@elseif($type=="fund")			
				<li class="nav-item">
			    	<a class="nav-link d-none d-sm-block active" data-toggle="tab" href="#manageroverview">Manager Overview</a>
				</li>
				<li class="nav-item">
			   		<a class="nav-link d-none d-sm-block" data-toggle="tab" href="#productoverview">Product Overview</a>
				</li>
				@endif
				
				<li class="nav-item">
			    	<a class="nav-link d-none d-sm-block" data-toggle="tab" href="#other-rounds">Other Rounds</a>
				</li>
			</ul>
		</div>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane p-3" id="productoverview" role="tabpanel">
				<p class-"text-primary">Product Overview</p>
				<p>{{isset($fund_productoverview)?$fund_productoverview:''}}</p>
				<p class-"text-primary">Exit Strategy</p>
				<p>{{isset($fundexitstrategy)?$fundexitstrategy:''}}</p>
			</div>
			<div class="tab-pane p-3 active" id="manageroverview" role="tabpanel">
				
				<p>{!!isset($fund_manageroverview)?($fund_manageroverview==""?'<p class="text-center"> No data</p>':$fund_manageroverview):''!!}</p>
				
			</div>



			@if($type=="proposal")
			<div class="tab-pane active p-3" id="business-idea" role="tabpanel">
				<!-- accordions -->

				<div id="" role="tablist" class="gi-collapse">
				  	<div class="card">
					    <div class="card-header" role="tab" id="headingOne">
					        <a data-toggle="collapse" href="#collapse1" role="button">
					          About the Business
					          <i class="fa fa-plus"></i>
					          <i class="fa fa-minus"></i>
					        </a>
					    </div>

					    <div id="collapse1" class="collapse show" role="tabpanel" >
					    	<div class="card-body">
					    		<p>{{isset($proposal_desc_details['aboutbusiness'])?$proposal_desc_details['aboutbusiness']:''}}</p>
					    	</div>
					    </div>
					</div>

				  	<div class="card">
					    <div class="card-header" role="tab" id="headingOne">
					        <a data-toggle="collapse" href="#collapse2" role="button" class="collapsed">
					          Business Stage
					          <i class="fa fa-plus"></i>
					          <i class="fa fa-minus"></i>
					        </a>
					    </div>

					    <div id="collapse2" class="collapse " role="tabpanel" >
					    	<div class="card-body">
					    		<p>{{isset($proposal_desc_details['businessstage'])?$proposal_desc_details['businessstage']:''}} </p>
					    	</div>
					    </div>
					</div>

					<div class="card">
					    <div class="card-header" role="tab" id="headingOne">
					        <a data-toggle="collapse" href="#collapse3" role="button" class="collapsed">
					          Business funding to this point
					          <i class="fa fa-plus"></i>
					          <i class="fa fa-minus"></i>
					        </a>
					    </div>

					    <div id="collapse3" class="collapse " role="tabpanel" >
					    	<div class="card-body">
					    		<p>{{isset($proposal_desc_details['businessfunded'])?$proposal_desc_details['businessfunded']:''}}</p>
					    	</div>
					    </div>
					</div>

					<div class="card">
					    <div class="card-header" role="tab" id="headingOne">
					        <a data-toggle="collapse" href="#collapse4" role="button" class="collapsed">
					          Income/Turnover generated so far
					          <i class="fa fa-plus"></i>
					          <i class="fa fa-minus"></i>
					        </a>
					    </div>

					    <div id="collapse4" class="collapse " role="tabpanel" >
					    	<div class="card-body">
					    		<p>{{isset($proposal_desc_details['incomegenerated'])?$proposal_desc_details['incomegenerated']:''}}</p>
					    	</div>
					    </div>
					</div>

					<div class="card">
					    <div class="card-header" role="tab" id="headingOne">
					        <a data-toggle="collapse" href="#collapse5" role="button" class="collapsed">
					          About the Team
					          <i class="fa fa-plus"></i>
					          <i class="fa fa-minus"></i>
					        </a>
					    </div>

					    <div id="collapse5" class="collapse " role="tabpanel" >
					    	<div class="card-body">
					    		<p>{{isset($proposal_desc_details['aboutteam'])?$proposal_desc_details['aboutteam']:''}}</p>
					    	</div>
					    </div>
					</div>

					<div class="card">
					    <div class="card-header" role="tab" id="headingOne">
					        <a data-toggle="collapse" href="#collapse6" role="button" class="collapsed">
					          Market/Industry Summary
					          <i class="fa fa-plus"></i>
					          <i class="fa fa-minus"></i>
					        </a>
					    </div>

					    <div id="collapse6" class="collapse " role="tabpanel" >
					    	<div class="card-body">
					    		<p>{{isset($proposal_desc_details['marketscope'])?$proposal_desc_details['marketscope']:''}}</p>
					    	</div>
					    </div>
					</div>

					<div class="card">
					    <div class="card-header" role="tab" id="headingOne">
					        <a data-toggle="collapse" href="#collapse7" role="button" class="collapsed">
					          Exit Strategy
					          <i class="fa fa-plus"></i>
					          <i class="fa fa-minus"></i>
					        </a>
					    </div>

					    <div id="collapse7" class="collapse " role="tabpanel" >
					    	<div class="card-body">
					    		<p>{{isset($proposal_desc_details['exit_strategy'])?$proposal_desc_details['exit_strategy']:''}}</p>
					    	</div>
					    </div>
					</div>
				</div>
				<!-- /accordions -->
			</div>

			<div class="tab-pane p-3" id="financial-projections" role="tabpanel">
				<p><strong>Note: </strong> Financial projections are not a reliable indicator of future performance.</p>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th></th>
								<th>YEAR 1</th>
								<th>YEAR 2</th>
								<th>YEAR 3</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>SALES</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['revenue_year1'], 0, true, true)}}</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['revenue_year2'], 0, true, true)}}</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['revenue_year3'], 0, true, true)}}</td>
							</tr>
							<tr>
								<td>COST OF SALES</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['sale_year1'], 0, true, true)}}</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['sale_year2'], 0, true, true)}}</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['sale_year3'], 0, true, true)}}</td>
							</tr>
							<tr>
								<td>EXPENSES</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['expences_year1'], 0, true, true)}}</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['expences_year2'], 0, true, true)}}</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['expences_year3'], 0, true, true)}}</td>
							</tr>
							<tr>
								<td>NET INCOME</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['ebitda_year_1'], 0, true, true)}}</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['ebitda_year_2'], 0, true, true)}}</td>
								<td class="text-nowrap">{{format_amount($fiancial_field['ebitda_year_3'], 0, true, true)}}</td>
							</tr>
						</tbody>

					</table>
				</div>

				<h5 class="text-primary">Use of Funds:</h5>
				<ol class="pl-3">

					 
					@foreach($use_of_funds as $use_of_fund)
						<li> {{$use_of_fund['value']}} - {{$use_of_fund['amount']}}</li> 
					@endforeach


					
					
				</ol>
			</div>
			
			<div class="tab-pane p-3" id="company-details" role="tabpanel">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="">Company Name</label>
							<div>{{$title}}</div>
						</div>

						<div class="form-group">
							<label for="">Company Number</label>
							<div>{{$company_details['number']}}</div>
						</div>

						<div class="form-group">
							<label for="">Company type</label>
							<div>{{$company_details['type']}}</div>
						</div>

						<div class="form-group">
							<label for="">Incorporation Date</label>
							<div>{{$company_details['incorporationdate']}}</div>
						</div>

						<div class="form-group">
							<label for="">Telephone Numbere</label>
							<div>{{$company_details['telephone']}}</div>
						</div>

						<div class="form-group">
							<label for="">SIC 2003</label>
							<div>{{$company_details['sic2003']}}</div>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label for="">Website</label>
							<div><a href="www.fonmoney.com" target="_blank">{{$proposal_details['website']}}</a></div>
						</div>

						<div class="form-group">
							<label for="">Registered Address</label>
							<div>{{$company_details['tradingaddress']}}</div>
						</div>

						<div class="form-group">
							<label for="">The Tax District</label>
							<div>vfrdfvgrdte45SSSSS</div>
						</div>
						<div class="form-group">
							<label for="">Type of accounts filling</label>
							<div>{{$company_details['typeofaccount']}}</div>
						</div>

						<div class="form-group">
							<label for="">Latest annual returns</label>
							<div>Invalid date</div>
						</div>

						<div class="form-group">
							<label for="">Next annual returns due</label>
							<div>{{$company_details['nextannualreturnsdue']}}</div>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label for="">Latest annual accounts</label>
							<div>{{$company_details['latestannualaccounts']}}</div>
						</div>

						<div class="form-group">
							<label for="">Next annual accounts due</label>
							<div>{{$company_details['nextannualaccountsdue']}}</div>
						</div>

						<div class="form-group">
							<label for="">SIC 2007</label>
							<div>{{$company_details['sic2007']}}</div>
						</div>

						<div class="form-group">
							<label for="">Social Media</label>
							<div></div>
						</div>

						<div class="form-group">
							<label for="">Trading Address</label>
							<div>{{$company_details['tradingaddress']}}</div>
						</div>

						<div class="form-group">
							<label for="">HMRC Reference</label>
							<div></div>
						</div>
					</div>
				</div>
			</div>
			@endif

			<div class="tab-pane p-3" id="other-rounds" role="tabpanel">
				<!-- test -->
				<!-- NO ACCESS 
				<h3>Unauthorized Content</h3><p>You do not have enough permission to view this section. Please contact administrator.</p>
				/NO ACCESS -->
				@if(count($business_rounds)>0)
					@foreach($business_rounds as $business_round) 
					@php
					$business_round_link = url("/investment-opportunities/fund/" . $business_round['business_slug']);
					if ($business_round['type'] == "proposal") {
					    $business_round_link = url("investment-opportunities/single-company/" . $business_round['business_slug']);
					}
					@endphp
					<div class="row border proposal_horizontal-car">
						<div class="col-sm-8 proposal-details border-sm-right border-right-0">
							<div class="media h-100 flex-wrap flex-sm-nowrap">
								<div class="proposal-logo align-self-center mr-sm-3 mt-3 mt-sm-0 width-xs-100">
									<div class="mw-60 mh-60 m-auto">
										<img src="https://dummyimage.com/100x100" alt="" class="img-fluid">
									</div>
								</div>
								<div class="media-body d-sm-flex align-items-sm-center py-3 h-100">
							    	<div class="w-100">
							    		<p class="text-center text-sm-left">
							    			<a href="{{$business_round_link}}">{{$business_round['business_title']}}</a>
							    		</p>
							    		<div class="row additional-info">
							    			<div class="col-sm-4 text-center border-sm-right border-right-0 py-3 py-sm-0">
							    				<strong class="text-primary">{{$business_round['watchlist_count']}}</strong>
							    				<div>Added to watchlist</div>
							    			</div>
							    			<div class="col-sm-4 text-center border-sm-right border-right-0">
							    				<strong class="text-primary">{{$business_round['pledge_count']}}</strong>
							    				<div>Pledgers</div>
							    			</div>
							    			<div class="col-sm-4 text-center pt-3 pt-sm-0">
							    				<strong class="text-primary">{{$business_round['funded_count']}}</strong>
							    				<div>Investors</div>
							    			</div>
							    		</div>
							    	</div>
							  </div>
							</div>
						</div>
						<div class="col-sm-4 text-center d-sm-flex align-items-sm-center justify-content-sm-center py-3">
							<div class="view-proposal">
								<p class="mb-1">@if($round!='')
									{{get_ordinal_number($business_round['biz_round'])}} round
								@endif</p>
								<p class="mb-1">Total Investment: <span class="text-primary">{{format_amount($business_round['fund_raised'], 0, true, true)}}</span></p>
								<p>Number of Questions: <span class="text-primary">{{$business_round['comments_count']}}</span></p>
								<a href="{{$business_round_link}}" class="btn btn-primary">View Proposal</a>
							</div>
						</div>
					</div>
					@endforeach
				@endif
				
				<!-- /test -->
			</div>

		</div>
		<!-- /tabs -->
	</div>
</div>

<!-- proposal videos -->
<div class="pt-4 pb-4" style="background-color: #eee;">
	<div class="container">
	<h4>Videos</h4>
		<div class="d-sm-flex justify-content-center">
			<div class="col-sm-6 col-12">
				<div>
					<div class="d-flex justify-content-between mb-2">
						<p class="mb-0">Proposal Video</p>						
					</div>
					<video autobuffer controls class="w-100 d-block">
					  <source id="mp4" src="{{$proposal_details['video']['embed_code']}}" type="video/mp4">
					</video>
				</div>
			</div>
			<div class="col-sm-6 col-12 mt-4 mt-sm-0">
				<div>
					<div class="d-flex justify-content-between mb-2">
						<p class="mb-0">Pitch Event Video</p>
						<a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModal">Your Feedback</a>
					</div>
					<video autobuffer controls class="w-100 d-block">
					  <source id="mp4" src="{{$proposal_details['pitch_event_video']['embed_code']}}" type="video/mp4">
					</video>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /proposal videos -->

<!-- management team -->
<div class="pt-4 pb-4">
	<div class="container">
		<!-- owl carousel -->
		<!-- <ul class="owl-carousel">
			<li>1</li>
			<li>2</li>
			<li>3</li>
		</ul> -->
		<!-- /owl carousel -->
		<h4>Management Team</h4>

		<!-- carousel -->
		<div class="carousel-with-card">
		<div id="carousel-controls" class="carousel slide mt-3" data-ride="carousel">
		  	<div class="carousel-inner">

		  					@php
							$cnt_management_team = 0;
							@endphp
							@foreach($management_team as $member) 

									<div class="carousel-item @if($cnt_management_team==0) active @endif">
								 		<!-- content -->
								 		<div class="media flex-wrap flex-sm-wrap">
								 			<div class="avatar align-self-start mr-3 mb-3 mb-sm-0 mw-150 mh-150">
								 				<img class="img-fluid m-sm-auto m-sm-block" src="https://dummyimage.com/150x150" alt="Generic placeholder image">
								 			</div>
								 			<div class="media-body flex-basis-xs-100">
								 		    	<h5 class="mt-0">{{$member['name']}} <small class="designation">({{$member['position']}})</small></h5>
								 		    	<p class="bio">@if($member['bio']=="")  <p  class="bio text-danger" >No Information Provided</p>  @endif 
								 		    	@if($member['bio']!="")
								 		    	{{$member['bio']}}
								 		    	@endif
								 		     	
								 		     	@if($type=="fund")
								 		     		<hr>
									 		     	@if($member['preinvestment']!="" || $member['postinvestment']!='')									 		    	
									 		    	<div class="row">
									 		    		<div class="col-sm-6">
									 		    			<div class="form-group">
									 		    				<label for="">Employment Status:</label>
									 		    				<div>Pre-Investment: <span>{{$member['preinvestment']}}</span></div>
									 		    				<div>Post-Investment: <span>{{$member['postinvestment']}}</span></div>
									 		    			</div>
									 		    		</div>
									 		    		<div class="col-sm-6">
									 		    			@if($member['equitypreinvestment']!="" )	
									 		    			<div class="form-group">
									 		    				<label for="">Equity holding(Pre-Investment):</label>
									 		    				<div>12%</div>
									 		    			</div>
									 		    			@else
									 		    			<div class="form-group">
									 		    				<p class="text-danger">No Information Provided</p>
									 		    			</div>
									 		    			@endif
									 		    		</div>
									 		    	</div>
									 		    	@else
									 		    	<div class="row text-danger">No Information Provided
									 		    	</div >
									 		    	@endif	
								 		    	</div>
								 		    	@endif

								 			</div>
								 		</div>
								 		<!-- /content -->
									</div>
									@php
									$cnt_management_team++;
									@endphp

							@endforeach
		  	</div>
		  	</div><!--/carousel-with-card-->

		  	<a class="carousel-control-prev" href="#carousel-controls" role="button" data-slide="prev">
		    	<span class="fa fa-chevron-left" aria-hidden="true"></span>
		    	<span class="sr-only">Previous</span>
		  	</a>
		  	<a class="carousel-control-next" href="#carousel-controls" role="button" data-slide="next">
		    	<span class="fa fa-chevron-right" aria-hidden="true"></span>
		    	<span class="sr-only">Next</span>
		  	</a>
		</div>
		<!-- /carousel -->

		
	</div>
</div><!-- /management team -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


@endsection
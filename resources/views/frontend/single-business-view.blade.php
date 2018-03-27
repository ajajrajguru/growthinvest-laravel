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

	    $(".pledged-invested-users .edit-action").click(function(){
            $(".fa").toggleClass("fa-pencil fa-close");
        });

	    $(".pledged-invested-users .cancel-action").click(function(){
            $(".fa").toggleClass("fa-close fa-pencil");
        });

	});
	
</script>
@endsection


<div class="container pb-5">
	<!-- <div class="row proposal-info-card">
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
					<p class="mb-0"><i class="fa fa-globe text-white"></i> <a href="" class="text-white">{{$proposal_details['website']}}</a></p>
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
	</div> -->

	<!-- media objects -->
	<div class="row" style="margin-top: -120px">
		<div class="col-sm-9">
			<div class="media flex-wrap d-sm-flex align-items-sm-start text-sm-left text-center">
				<div class="mr-sm-3 width-xs-100 ">
				  	<!-- <div class="d-table-cell"> -->
				  		<div class="mw-150 mh-150 mx-auto border d-flex align-items-center justify-content-center position-relative">

				  			<!-- logo -->
				  			<div class="position-absolute mw-60 mh-60" style="top: -30px; left: -30px;">
				  				<a href="">
				  					<img src="https://dummyimage.com/120x120" alt="" class="img-fluid">
				  				</a>
				  			</div>
				  			<!-- /logo -->
				  			<img src="https://dummyimage.com/120x100" alt="" class="img-fluid">
				  		</div>
					<!-- </div> -->
				</div>
			  	<div class="media-body">
			    	<ul class="mb-0 pl-0 ">
						<li class="list-inline-item">
							@foreach($tax_status as $t_status)
								<span class="badge bg-primary text-white mr-1">
									{{strtoupper($t_status)}}
								</span>
							@endforeach
						</li>
						<li class="list-inline-item">
							@if($round!='')
								{{get_ordinal_number($round)}} round
							@endif
						</li>
					</ul>
					<h3 class="text-capitalize text-sm-white">{{$title}}</h3>
					<p class="mb-0 text-sm-white"><i class="fa fa-map-marker"></i> {{$proposal_details['address']}}</p>
					<p class="mb-0 text-sm-white"><i class="fa fa-globe"></i> <a href="" target="_blank" class="">{{$proposal_details['website']}}</a></p>
			  	</div>
			</div>
		</div>
		<div class="col-sm-3 d-flex align-items-sm-center justify-content-sm-end justify-content-center mt-sm-0 mt-3">
			<div class="text-sm-right text-center">
				<ul class="mb-2 pl-0 social-icons text-nowrap">
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
	
	<!-- /media objects -->
	<div class="row mt-3 mb-3">
		<div class="col-sm-8 text-center text-sm-left">
			<a href="" class="btn btn-outline-primary"><i class="fa fa-plus"></i> ADD TO WATCHLIST</a>
		</div>
		<div class="col-sm-4 text-center mt-2 mt-sm-0">
			<a href="" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal2"> Invest Now</a>
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
				<a href="" class="btn btn-primary mb-1 mb-sm-0" data-toggle="modal" data-target="#request-call">Request a Call</a>
				<a href="" class="btn btn-primary mb-1 mb-sm-0" data-toggle="modal" data-target="#request-additional-info">Request Additional Information</a>
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

				<!-- test -->
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="">Platform GI Code </label>
							<div>GIBP63799240</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="">Analyst Feedback:</label>
							<div>Pending</div>
						</div>
					</div>
				</div>
				
				<div class="text-right mb-3">
					<a href="" class="btn btn-sm btn-outline-primary">Edit</a>
					<a href="" class="btn btn-sm btn-outline-danger">Cancel</a>
				</div>
				<form action="" class="bg-gray p-3">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Proposal Status</label>
								<select name="" id="" class="form-control">
									<option value="">1</option>
									<option value="">2</option>
									<option value="">3</option>
								</select>
								<div></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Proposal Approved By</label>
								<select name="" id="" class="form-control">
									<option value="">1</option>
									<option value="">2</option>
									<option value="">3</option>
								</select>
								<div></div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">The Tax Distict</label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">HMRC Reference</label>
								<input type="text" class="form-control">
							</div>
						</div>
					</div>
					
					<div class="fomr-group">
						<div class="d-sm-inline-block">
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" id="ch1">
							  <label class="custom-control-label" for="ch1">Investment Opportunities</label>
							</div>
							<div class="custom-control custom-checkbox ml-4 mt-1">
							  <input type="checkbox" class="custom-control-input" id="ch2" checked="">
							  <label class="custom-control-label" for="ch2">Invest Listing only</label>
							</div>
						</div>

						<div class="d-sm-inline-block align-top ml-sm-5 ml-0 mt-4 mt-sm-0">
							<div class="custom-control custom-checkbox custom-control-inline">
							  <input type="checkbox" class="custom-control-input" id="ch7">
							  <label class="custom-control-label" for="ch7"> Single Company Type</label>
							</div>
						</div>
					</div>
					
				</form>

				<div class="table-responsive pledged-invested-users mt-3">
					<table class="table table-hover table-solid-bg">
						<thead>
							<tr>
								<th>Investor</th>
								<th>Amount</th>
								<th>Status</th>
								<th>Edit</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><a href="">External Investments</a></td>
								<td>&pound; 100, 00</td>
								<td>Invested</td>
								<td><a class="edit-action" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-pencil"></i></a></td>
							</tr>
							<tr id="collapseExample2" class="collapse border bg-gray">
								<td colspan="4">
									<div class="row px-3">
										<div class="col-sm-4 border-sm-right border-0">
										  	<div class="form-group row mb-3">
										    	<label for="" class="col-sm-4 col-form-label">Status:</label>
										    	<div class="col-sm-8">
										      		<select name="" id="" class="form-control">
										      			<option value="">Pledged</option>
										      			<option value="">Invesed</option>
										      		</select>
										    	</div>
										  	</div>

										  	<div class="form-group row mb-3">
										    	<label for="" class="col-sm-4 col-form-label">Amount:</label>
										    	<div class="col-sm-8">
										      		<div class="input-group">
							    	    		  	  	<div class="input-group-prepend border-bottom">
							    	    		  	  		<span class="input-group-text border-0 bg-transparent">&pound;</span>
							    	    		  	  	</div>
						    	    		  	  		<input type="number" class="form-control">
						    	    		  	  	</div>
										    	</div>
										  	</div>

										  	<div class="form-group row mb-3">
										    	<label for="" class="col-sm-4 col-form-label">Date:</label>
										    	<div class="col-sm-8">
										      		<input type="date" class="form-control">
										    	</div>
										  	</div>

										  	<div class="form-group row mb-3">
										    	<label for="" class="col-sm-4 col-form-label">Relief:</label>
										    	<div class="col-sm-8">
										      		<select name="" id="" class="form-control">
										      			<option value="">SEIS</option>
										      			<option value="">EIS</option>
										      		</select>
										    	</div>
										  	</div>

										  	<div class="form-group row mb-3">
										    	<label for="" class="col-sm-4 col-form-label">No. of shares:</label>
										    	<div class="col-sm-8">
										      		<input type="text" class="form-control">
										    	</div>
										  	</div>
										</div>
										<div class="col-sm-4 border-sm-right border-0">
											

									  		<div class="form-group row mb-3">
									  	    	<label for="" class="col-sm-4 col-form-label">Share Issue Price: &pound;</label>
									  	    	<div class="col-sm-8">
									  	      		<input type="text" class="form-control">
									  	    	</div>
									  	  	</div>

									  	  	<div class="form-group row mb-3">
									  	    	<label for="" class="col-sm-4 col-form-label">Share Issue Date:</label>
									  	    	<div class="col-sm-8">
									  	      		<input type="date" class="form-control">
									  	    	</div>
									  	  	</div>

									  	  	<div class="form-group row mb-3">
									  	    	<label for="" class="col-sm-4 col-form-label">Revaluation Date:</label>
									  	    	<div class="col-sm-8">
									  	      		<input type="date" class="form-control">
									  	    	</div>
									  	  	</div>

									  	  	<div class="form-group row mb-3">
									  	    	<label for="" class="col-sm-4 col-form-label">Current Value:</label>
									  	    	<div class="col-sm-8">
									  	      		<input type="text" class="form-control">
									  	    	</div>
									  	  	</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group row mb-3">
									  	    	<label for="" class="col-sm-4 col-form-label">AI-C/AI-NC:</label>
									  	    	<div class="col-sm-8">
									  	      		<select name="" id="" class="form-control">
									  	      			<option value="">Custody</option>
									  	      			<option value="">Non-custody</option>
									  	      		</select>
									  	    	</div>
									  	  	</div>

									  	  	<div class="form-group row mb-3">
									  	    	<label for="" class="col-sm-4 col-form-label">Platform AI-C/AI-NC:</label>
									  	    	<div class="col-sm-8">
									  	      		<select name="" id="" class="form-control">
									  	      			<option value="">1</option>
									  	      			<option value="">2</option>
									  	      		</select>
									  	    	</div>
									  	  	</div>

									  	  	<div class="form-group row mb-3">
									  	    	<label for="" class="col-sm-4 col-form-label">Platform/Off Platform:</label>
									  	    	<div class="col-sm-8">
									  	      		<select name="" id="" class="form-control">
									  	      			<option value="">1</option>
									  	      			<option value="">2</option>
									  	      		</select>
									  	    	</div>
									  	  	</div>

									  	  	<div class="form-group row mb-3">
									  	    	<label for="" class="col-sm-4 col-form-label">External Asset:</label>
									  	    	<div class="col-sm-8">
									  	      		<select name="" id="" class="form-control">
									  	      			<option value="">Yes</option>
									  	      			<option value="">No</option>
									  	      		</select>
									  	    	</div>
									  	  	</div>
										</div>
									</div>

									<div class="text-right">
										<a href="" class="btn btn-sm btn-outline-primary mr-1">Save</a>
										<a data-toggle="collapse" href="#collapseExample2" class="btn btn-sm btn-outline-danger cancel-action">Cancel</a>
									</div>

							  	</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="form-group">
					<label>Choose Sites to appear on</label>
					<div>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="checkbox" class="custom-control-input" id="ch31">
							<label class="custom-control-label" for="ch31">GrowthInvest</label>
						</div>

						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="checkbox" class="custom-control-input" id="ch32">
							<label class="custom-control-label" for="ch32">wardconnections</label>
						</div>

						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="checkbox" class="custom-control-input" id="ch33">
							<label class="custom-control-label" for="ch33">whitelabeldemo</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Display on Home Page</label>
					<div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="ch11">
							<label class="custom-control-label" for="ch11">Check if Yes</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Display to Non Logged in User on Platform</label>
					<div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="ch12">
							<label class="custom-control-label" for="ch12">Check if Yes</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Choose Firms to appear on</label>
					<ul class="list-unstyled">
						<li>
							<div class="custom-control custom-checkbox">
							  	<input type="checkbox" class="custom-control-input" id="ch2" checked="">
							  	<label class="custom-control-label" for="ch2">Check1</label>
							</div>
						</li>
						<li>
							<div class="custom-control custom-checkbox">
							  	<input type="checkbox" class="custom-control-input" id="ch2" checked="">
							  	<label class="custom-control-label" for="ch2">Check2</label>
							</div>
							<ul class="list-unstyled ml-4">
								<li>
									<div class="custom-control custom-checkbox">
									  	<input type="checkbox" class="custom-control-input" id="ch2" checked="">
									  	<label class="custom-control-label" for="ch2">Check2.1</label>
									</div>
								</li>
								<li>
									<div class="custom-control custom-checkbox">
									  	<input type="checkbox" class="custom-control-input" id="ch2" checked="">
									  	<label class="custom-control-label" for="ch2">Check2.2</label>
									</div>
									<ul class="list-unstyled ml-4">
										<li>
											<div class="custom-control custom-checkbox">
											  	<input type="checkbox" class="custom-control-input" id="ch2" checked="">
											  	<label class="custom-control-label" for="ch2">Check2.2 - 1</label>
											</div>
										</li>
										<li>
											<div class="custom-control custom-checkbox">
											  	<input type="checkbox" class="custom-control-input" id="ch2" checked="">
											  	<label class="custom-control-label" for="ch2">Check2.2 - 2</label>
											</div>
										</li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</div>

				
				<!-- /test -->

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
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class=""></th>
								<th class="">YEAR 1</th>
								<th class="">YEAR 2</th>
								<th class="">YEAR 3</th>
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
					<div class="row box-shadow-1 proposal_horizontal-car">
						<div class="col-sm-8 proposal-details ">
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
						<div class="col-sm-4 text-center d-sm-flex align-items-sm-center justify-content-sm-center py-3" style="background: #eee;">
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
						<a href="javascript:void(0);" data-toggle="modal" data-target="#pitchevent-feedback">Your Feedback</a>
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

<!-- New & updates -->
<div class="pt-4 pb-4" style="background-color: #eee;">
	<div class="container">
		<h4>News & Updates</h4>
		
		<div class="row">
			<div class="col-sm-8">
				<ul class="list-group">
				  <li class="list-group-item">
				  	<div class="mb-2">
			  			<p class="mb-0"><strong>Dapibus ac facilisis in</strong></p>
			  			<p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis et vel veritatis optio dolorem expedita ea, doloribus.</p>
				  	</div>
				  	
			  		<div class="d-flex justify-content-between">
			  			<div>
			  				<a href="" class="btn btn-sm btn-link pl-0"><i class="fa fa-pencil"></i> Edit</a>
			  				<a href="" class="btn btn-sm btn-link text-danger pl-0"><i class="fa fa-trash"></i> Delete</a>
			  			</div>

			  			<div><small class="">May 27, 2018</small></div>
			  		</div>
				  </li>

				  <li class="list-group-item">
				  	<form action="">
				  		<div class="form-group">
				  			<input type="text" class="form-control" value="Dapibus ac facilisis in">
				  		</div>

				  		<div class="form-group">
				  			<textarea name="" id="" cols="3" rows="" class="form-control">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis et vel veritatis optio dolorem expedita ea, doloribus.</textarea>
				  		</div>

				  		<a href="" class="btn btn-sm btn-outline-primary">Save</a>
				  		<a href="" class="btn btn-sm btn-outline-danger">Cancel</a>
				  	</form>
				  </li>

				</ul>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</div>
<!-- /news & updates -->
<div class="pt-4 pb-4" style="background-color: #fff;">
	<div class="container">
		<h5 class="text-uppercase">get in touch</h5>
		<div class="row">
			<div class="col-md-2">
				<ul class="mb-3 mb-sm-0 pl-0 social-icons text-nowrap dark">
					<li class="list-inline-item">
						<a href="https://twitter.com/GrowthInvestUK"  target="_blank"><i class="fa fa-twitter"></i></a>
					</li>
					<li class="list-inline-item">
						<a href="https://www.linkedin.com/company/growthinvest"  target="_blank"><i class="fa fa-linkedin"></i></a>
					</li>
				</ul>
			</div>
			<div class="col-md-3">
				<div class="d-table">
					<div class="d-table-cell align-top pr-2">
						<div class="border rounded-circle d-inline-block bg-primary text-white w-35 h-35 lh-35 text-center"><i class="fa fa-map-marker"></i></div>
					</div>
					<div class="d-table-cell align-top">
						<strong>Head Office</strong>
						<p>25 Copthall Ave, 4th Floor, London EC2R 7BP</p>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="d-table">
					<div class="d-table-cell align-top pr-2">
						<div class="border rounded-circle d-inline-block bg-primary text-white w-35 h-35 lh-35 text-center"><i class="fa fa-map-marker"></i></div>
					</div>
					<div class="d-table-cell align-top">
						<strong>Sales and Distribution LGBR Capital</strong>
						<p>Candlewick House, 4th Floor, 120 Cannon Street, London EC4N 6AS</p>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="d-table">
					<div class="d-table-cell align-top pr-2">
						<div class="border rounded-circle d-inline-block bg-primary text-white w-35 h-35 lh-35 text-center"><i class="fa fa-phone"></i></div>
					</div>
					<div class="d-table-cell align-top">
						<strong>Contact</strong>
						<p>020 7071 3945</p>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="d-table">
					<div class="d-table-cell align-top pr-2">
						<div class="border rounded-circle d-inline-block bg-primary text-white w-35 h-35 lh-35 text-center"><i class="fa fa-envelope"></i></div>
					</div>
					<div class="d-table-cell align-top">
						<strong>Email</strong>
						<p><a class="word-break" href="mailto:enquiries@growthinvest.com">enquiries@growthinvest.com</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="pitchevent-feedback" tabindex="-1" role="dialog" aria-labelledby="pitchevent-feedback" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pitch Event Video Feedback</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<p>Please fill in Your Feedback on this Presentation</p>
      	<div class="row">
      		<div class="col-sm-6">
      			<div class="form-group">
		      	    <label>Rate our Presentation <span class="text-danger">*</span></label>
		      	    <select name="" id="" class="form-control">
		      	    	<option value="">1</option>
		      	    	<option value="">2</option>
		      	    	<option value="">3</option>
		      	    </select>
		      	</div>
      		</div>
      		<div class="col-sm-6">
      			<div class="form-group">
      				<label>Rate this Concept <span class="text-danger">*</span></label>
      			  	<select name="" id="" class="form-control">
      			  		<option value="">1</option>
      			  		<option value="">2</option>
      			  		<option value="">3</option>
      			  	</select>
      			</div>
      		</div>
      	</div>

      	
  		<div class="form-group">
  			<label for="">Comment</label>
  			<textarea class="form-control" name="" id="" cols="3" rows=""></textarea>
  		</div>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- modal - Request a call -->
<div class="modal fade" id="request-call" tabindex="-1" role="dialog" aria-labelledby="request-call" aria-hidden="true">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title" id="request-call">Request a Call</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      	<div class="modal-body">
      	<p>Please use this form to request a call back from the GrowthInvest client services team. Alternatively please call us during office hours on 020 7071 3945 or email us on <a href="mailto:support@growthinvest.com">support@growthinvest.com</a></p>
      	<form>
      	  <div class="form-group">
      	    <label>Title</label>
      	    <input type="text" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>First Name</label>
      	    <input type="text" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Last Name</label>
      	    <input type="text" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Email</label>
      	    <input type="email" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Telephone</label>
      	    <input type="tel" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Investment</label>
      	    <input type="text" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Potential Investment <span class="text-danger">*</span></label>
      	    <input type="text" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Preferred Time <span class="text-danger">*</span></label>
      	    <select name="" id="" class="form-control">
      	    	<option value="">1</option>
      	    	<option value="">2</option>
      	    	<option value="">3</option>
      	    </select>
      	  </div>
      	  
      	</form>
      </div>
      <div class="modal-footer justify-content-between">
    	<input type="submit" class="btn btn-primary">
    	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- /request a call -->

<!-- modal - Request additional information-->
<div class="modal fade" id="request-additional-info" tabindex="-1" role="dialog" aria-labelledby="request-additional-info" aria-hidden="true">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title" id="request-call">Request Additional Information</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      	<div class="modal-body">
      	<p>Please use this form to request a call back from the GrowthInvest client services team. Alternatively please call us during office hours on 020 7071 3945 or email us on <a href="mailto:support@growthinvest.com">support@growthinvest.com</a></p>
      	<form>
      	  <div class="form-group">
      	    <label>Title</label>
      	    <input type="text" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>First Name</label>
      	    <input type="text" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Last Name</label>
      	    <input type="text" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Email</label>
      	    <input type="email" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Telephone</label>
      	    <input type="tel" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Additional Information required <span class="text-danger">*</span></label>
      	    <input type="text" class="form-control">
      	  </div>
      	  <div class="form-group">
      	    <label>Potential Investment <span class="text-danger">*</span></label>
      	    <input type="text" class="form-control">
      	  </div>
      	</form>
      </div>
      <div class="modal-footer justify-content-between">
    	<input type="submit" class="btn btn-primary">
    	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- /request additional information -->

<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subscription Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
        	<h4>(the "company")</h4>
        	<p>(Incorporated and registered in England)</p>
        	<h2>SHARE OFFER</h2>
        </div>

        <h4>Outline Terms of the Offer</h4>
        <p>The Company is offering up to 1000 new ordinary shares in the share capital of the Company at a price of 1.00 per ordinary ("The Offer"). The Offer is made to raise (general working capital) for the Company, and on the basis that the current issued capital is 2000 Ordinary Shares.</p>

        <h4>Procedure for Completion</h4>
        <ol class="pl-3">
        	<li>If you wish to invest as part of the Offer please complete in full the details requested at Sections 1 to 5 and then sign and date where indicated at Section 6.</li>
        	<li>Payment should be made in full on application. Please enclose a cheque made payable to "", or transfer your funds to the bank account details of which are set out in Section 2 below.</li>
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
        	    		<form>
        	    			<div class="form-group row mb-3">
        	    		    	<label class="col-sm-3 col-form-label">Mr, Mrs, Miss or Title:</label>
        	    		    	<div class="col-sm-9">
        	    		      		<input type="text" class="form-control">
        	    		    	</div>
        	    		  	</div>
        	    		  	<div class="form-group row mb-3">
        	    		    	<label class="col-sm-3 col-form-label">Forename(s) (in full): <span class="text-danger">*</span></label>
        	    		    	<div class="col-sm-9">
        	    		      		<input type="text" class="form-control">
        	    		    	</div>
        	    		  	</div>
    	    		  		<div class="form-group row mb-3">
    	    		  	    	<label class="col-sm-3 col-form-label">Surname:</label>
    	    		  	    	<div class="col-sm-9">
    	    		  	      		<input type="text" class="form-control">
    	    		  	    	</div>
    	    		  	  	</div>

    	    		  	  	<div class="row">
    	    		  	  		<div class="col-sm-6">
	    		  	  				<div class="form-group row mb-3">
	    		  	  			    	<label class="col-sm-6 col-form-label">Address in full:</label>
	    		  	  			    	<div class="col-sm-6">
	    		  	  			      		<textarea name="" id="" cols=" rows="2" class="form-control"></textarea>
	    		  	  			    	</div>
	    		  	  			  	</div>
    	    		  	  		</div>
    	    		  	  		<div class="col-sm-6">
	    		  	  				<div class="form-group row mb-3">
	    		  	  			    	<label class="col-sm-3 col-form-label">Postcode:</label>
	    		  	  			    	<div class="col-sm-9">
	    		  	  			      		<input type="text" class="form-control">
	    		  	  			    	</div>
	    		  	  			  	</div>
    	    		  	  		</div>
    	    		  	  	</div>

	    		  	  		<div class="form-group row mb-3">
	    		  	  	    	<label class="col-sm-3 col-form-label">Email Address:</label>
	    		  	  	    	<div class="col-sm-9">
	    		  	  	      		<input type="email" class="form-control">
	    		  	  	    	</div>
	    		  	  	  	</div>

	    		  	  	  	<div class="form-group row mb-3">
	    		  	  	    	<label class="col-sm-3 col-form-label">Daytime tel. no.</label>
	    		  	  	    	<div class="col-sm-9">
	    		  	  	      		<input type="text" class="form-control">
	    		  	  	    	</div>
	    		  	  	  	</div>

    	    		  	  	<div class="row">
    	    		  	  		<div class="col-sm-6">
	    		  	  				<div class="form-group row mb-3">
	    		  	  			    	<label class="col-sm-6 col-form-label">Permanent address (if different from above)</label>
	    		  	  			    	<div class="col-sm-6">
	    		  	  			      		<textarea name="" id="" cols=" rows="2" class="form-control"></textarea>
	    		  	  			    	</div>
	    		  	  			  	</div>
    	    		  	  		</div>
    	    		  	  		<div class="col-sm-6">
	    		  	  				<div class="form-group row mb-3">
	    		  	  			    	<label class="col-sm-3 col-form-label">Postcode:</label>
	    		  	  			    	<div class="col-sm-9">
	    		  	  			      		<input type="text" class="form-control">
	    		  	  			    	</div>
	    		  	  			  	</div>
    	    		  	  		</div>
    	    		  	  	</div>

	    		  	  		<div class="form-group row mb-3">
    	    		  	  	  	<label class="col-sm-3 col-form-label">Date of Birth:</label>
    	    		  	  	  	<div class="col-sm-9">
    	    		  	  	    		<input type="date" class="form-control">
    	    		  	  	  	</div>
	    		  	  		</div>

	    		  	  		<div class="form-group row mb-3">
    	    		  	  	  	<label class="col-sm-3 col-form-label">National Insurance No.</label>
    	    		  	  	  	<div class="col-sm-9">
    	    		  	  	    		<input type="text" class="form-control">
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
  					    	    		  	  		<input type="number" class="form-control">
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
  					    	    		  	  		<input type="number" class="form-control">
  					    	    		  	  	</div>
	    	    		  	  		    	</div>
	    	    		  	  		  	</div>
	    	    		  	  		</div>
	    	    		  	  		<div class="col-sm-6">
		    		  	  				<label>SEIS/EIS relief sought?</label>
  	  									<div class="d-sm-inline ml-sm-3">
  	  										<div class="custom-control custom-radio custom-control-inline">
  	  										  <input type="radio" id="yes2" name="radiobtninline" class="custom-control-input">
  	  										  <label class="custom-control-label" for="yes2">Yes</label>
  	  										</div>
  	  										<div class="custom-control custom-radio custom-control-inline">
  	  										  <input type="radio" id="no2" name="radiobtninline" class="custom-control-input" checked="">
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
    	    		  	  			      		<input type="text" class="form-control">
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
  					    	    		  	  		<input type="number" class="form-control">
  					    	    		  	  	</div>
    	    		  	  			    	</div>
    	    		  	  			  	</div>
	    	    		  	  		</div>
	    	    		  	  	</div>
    	    		  	  	</div>
        	    		</form>
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
        	    		<p>By completing and returning this form, you are agreeing to subscribe for <%=_.isUndefined(proposal_data.get('share-class-issued'))?" Unknown ":proposal_data.get('share-class-issued')%><!-- Ordinary Shares --> shares as part of the Offer on the following terms:-</p>
	    		        <ol class="pl-3" type="i">
	    					<li>You agree to provide any information (including any proof of identity requests) reasonably required by the Company or its solicitors in order to process your application for shares.</li>
	    					<li>You agree to subscribe for the number of <!-- Ordinary Shares --><%=_.isUndefined(proposal_data.get('share-class-issued'))?" Unknown ":proposal_data.get('share-class-issued')%> shares stated above, or such lower number in the event of oversubscription (hereinafter “Your Shares”), subject to the memorandum and articles of association of the Company, as part of the Offer.</li>
	    					<li>Where applicable you undertake to sign a Deed of Adherence to the Shareholders Agreement of the Company</li>
	    					<li>You enclose a cheque or you have arranged an electronic transfer of funds in payment of the sum referred to above, to the account detailed below in this section, being the amount payable in full on application for the stated number of Ordinary Shares.</li>
	    					<li>You understand that the completion and delivery of this application form accompanied by a cheque constitutes an undertaking that the cheque will be honoured on first presentation.</li>
	    					<li>You understand that no application will be accepted unless and until payment in full for Your Shares has been made.</li>
	    					<li>You understand that the Company will send you a share certificate by post at your risk to the address given in Section 1 below for Your Shares.</li>
	    					<li>You agree to accept the above shares when allotted to you subject to the terms of the Memorandum and Articles of Association of the Company and you hereby authorise us to place your name in the Register of Members of the Company as the holder of those shares.</li>
	    				</ol>

	    				<p>The Company undertakes, where there is a minimum overall subscription level, to hold your money in a segregated account until such a time as the minimum subscription level is met.</p>
						
						<h5 class="mb-3">Bank Transfer Details:</h5>
	    				<form action="">
    						<div class="form-group row">
    					    	<label class="col-sm-3 col-form-label">A/C Name:</label>
    					    	<div class="col-sm-9">
    					      		<input type="text" class="form-control">
    					    	</div>
    					  	</div>

					  		<div class="form-group row">
					  	    	<label class="col-sm-3 col-form-label">A/C Number:</label>
					  	    	<div class="col-sm-9">
					  	      		<input type="text" class="form-control">
					  	    	</div>
					  	  	</div>

				  	  		<div class="form-group row">
				  	  	    	<label class="col-sm-3 col-form-label">Sort Code:</label>
				  	  	    	<div class="col-sm-9">
				  	  	      		<input type="text" class="form-control">
				  	  	    	</div>
				  	  	  	</div>

			  	  	  		<div class="form-group row">
			  	  	  	    	<label class="col-sm-3 col-form-label">Bank:</label>
			  	  	  	    	<div class="col-sm-9">
			  	  	  	      		<input type="text" class="form-control">
			  	  	  	    	</div>
			  	  	  	  	</div>

		  	  	  	  		<div class="form-group row">
		  	  	  	  	    	<label class="col-sm-3 col-form-label">Reference:</label>
		  	  	  	  	    	<div class="col-sm-9">
		  	  	  	  	      		<input type="text" class="form-control">
		  	  	  	  	    	</div>
		  	  	  	  	  	</div>
	    				</form>
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
    		    		<p>Once completed please return this subscription form to , c/o GrowthInvest, 120 Cannon Street, London, EC4N 6AS to arrive no later than 12 noon on 31st December 2017. Also please scan and email a copy to <a href="support@growthinvest.com">support@growthinvest.com</a> with email subject ' Subscription'.</p>
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
			    		<p>Under terms of the Financial Services and Markets Act 2000 (“FSMA”) and the Financial Services and Markets Act 2000 (Financial Promotion) Order 2005 (as amended) ("FSMAO"), the Company will only accept an application for shares if you are accurately categorised as an investor by an FCA authorised entity. The authorised entity would normally be either GrowthInvest (regulated as EIS Platforms Ltd by the FCA), or an authorised UK financial adviser or wealth manager. Please confirm that the below categorisation is still accurate and if not please <a href="">click here</a> to update your categorisation before completing this application</p>

			    		<p><strong>Certification:</strong> <span></span></p>
			    		<p>Date: <span></span></p>
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
	    		<a href="" class="btn btn-primary">Invest</a>
	    		<a href="" class="float-sm-right float-sm-left btn btn-outline-danger">Cancel</a>
	    	</div>

	    	<p><strong>Note:</strong> Once the form is complete, please either click on the Invest button in order to start our online electronic signature process, which is run by our partners Adobe E-sign, or please use the Download button to download the pre-populated form as a PDF which can be printed, signed, and sent to , c/o GrowthInvest, 120 Cannon Street, London EC4N 6AS.</p>

	    	<a href="" class="btn btn-primary"><i class="fa fa-download"></i> Download</a>
	    	<small class="text-muted form-text">Please note: A download will only include all investment and financial details if the user has submitted the application by clicking "Invest"</small>
        </div>
        <!-- /accordion -->
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>



@endsection
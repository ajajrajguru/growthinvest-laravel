@extends('layouts.frontend')


@section('frontend-content')

 @section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css" />
@endsection


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
@endsection

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
								EIS
							</span>
						</li>
						<li class="list-inline-item">
							2nd round
						</li>
					</ul>
					<h3 class="">{{$title}}</h3>
					<p class="mb-0"><i class="fa fa-map-marker"></i> {{$proposal_details['address']}}</p>
					<p class="mb-0"><a href="">{{$proposal_details['website']}}</a></p>
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
						<a href="{{$proposal_details['social-companyhouse']}}"  target="_blank"><i class="fa fa-globe"></i></a>
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
			<p class="mt-3">{{{$proposal_details['business_proposal_details']}}}</p>
			<hr>

			<div class="row">
				<div class="col-sm-6">
					<div class="">
						<label>BUSINESS SECTOR</label>
						<div> 
							@php
							$cnt_stages_of_business = 0;
							@endphp
							@foreach($stages_of_business as $stage)
								@if($cnt_stages_of_business>0)									,
								@endif
								{{$stage['name']}}
								@php
								$cnt_stages_of_business++;
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
					<div><span class="tag bg-dark">{{$milestone['name']}}</span></div>	
				@endforeach
				
			</div>
			<hr>
			
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
		<div class="col-sm-4 mt-3 mt-sm-0 bg-dark text-white">

			<!-- canvas -->
			<!-- http://www.tothenew.com/blog/tutorial-to-create-a-circular-progress-bar-with-canvas/ -->
			<canvas id="myCanvas" width="150" height="150" class="m-auto d-block"></canvas>
			<script>
			var canvas = document.getElementById('myCanvas');
			var context = canvas.getContext('2d');
			var al=0;
			var start=4.72;
			var cw=context.canvas.width/2;
			var ch=context.canvas.height/2;
			var diff;
			 
			function progressBar(){
			diff=(al/100)*Math.PI*2;
			context.clearRect(0,0,400,200);
			context.beginPath();
			context.arc(cw,ch,50,0,2*Math.PI,false);
			context.fillStyle='transparent';
			context.fill();
			context.strokeStyle='#FFF';
			context.stroke();
			context.fillStyle='#FFF';
			context.strokeStyle='#00A9EE';
			context.textAlign='center';
			context.lineWidth=15;
			context.font = '10pt Open Sans';
			context.beginPath();
			context.arc(cw,ch,50,start,diff+start,false);
			context.stroke();
			context.fillText(al+'%',cw+2,ch+6);
			if(al>=56){
			clearTimeout(bar);
			}
			 
			al++;
			}
			 
			var bar=setInterval(progressBar,50);
			</script>
			<!-- /canvas -->
			<ul class="p-0 statistics">
				<li class="d-flex justify-content-between">
					<div><strong>Investment Sought</strong></div>
					<div>&pound; 15,000</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Minimum Investment</strong></div>
					<div>&pound; 15,000</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Funded</strong></div>
					<div>&pound; 15,000</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Funds Pledged</strong></div>
					<div>&pound; 15,000</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Remaining</strong></div>
					<div>&pound; 15,000</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Equity Offer</strong></div>
					<div>&pound; 15,000</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Pre Money Valuation</strong> <a href=""><i class="fa fa-info-circle"></i></a></div>
					<div>&pound; 15,000</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Post Money Valuation</strong></div>
					<div>&pound; 15,000</div>
				</li>
				
			</ul>
		</div>
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
		<ul class="nav nav-tabs">
			<li class="nav-item">
		   		<a class="nav-link active" data-toggle="tab" href="#business-idea">Business Idea</a>
			</li>
			<li class="nav-item">
		    	<a class="nav-link" data-toggle="tab" href="#financial-projections">Financial Projections</a>
			</li>
			<li class="nav-item">
		    	<a class="nav-link" data-toggle="tab" href="#company-details">Company Details</a>
			</li>
			<li class="nav-item">
		    	<a class="nav-link" data-toggle="tab" href="#other-rounds">Other Rounds</a>
			</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
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
					    		<p>@php /* {{isset($proposal_desc_details['aboutbusiness'])$proposal_desc_details['aboutbusiness']:''}} */ @endphp </p>
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
					    		<p>@php /* {{isset($proposal_desc_details['businessstage'])$proposal_desc_details['businessstage']:''}}*/ @endphp </p>
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
					    		<p>@php /* {{$proposal_desc_details['businessfunded']}}*/ @endphp </p>
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
					    		<p>@php /* {{$proposal_desc_details['incomegenerated']}}*/ @endphp </p>
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
					    		<p>@php /* {{$proposal_desc_details['aboutteam']}}*/ @endphp </p>
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
					    		<p>@php /* {{$proposal_desc_details['marketscope']}}*/ @endphp </p>
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
					    		<p>@php /* {{$exit_strategy}}*/ @endphp </p>
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
					<li>lorem1</li>
					<li>lorem2</li>
					<li>lorem3</li>
					<li>lorem4</li>
					<li>lorem5</li>
				</ol>
			</div>

			<div class="tab-pane p-3" id="company-details" role="tabpanel">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="">Company Name</label>
							<div>fonmoney</div>
						</div>

						<div class="form-group">
							<label for="">Company Number</label>
							<div>08936601</div>
						</div>

						<div class="form-group">
							<label for="">Company type</label>
							<div>Private Limited Company</div>
						</div>

						<div class="form-group">
							<label for="">Incorporation Date</label>
							<div>01 Jan 0014</div>
						</div>

						<div class="form-group">
							<label for="">Telephone Numbere</label>
							<div>978956457890</div>
						</div>

						<div class="form-group">
							<label for="">SIC 2003</label>
							<div>NA</div>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label for="">Website</label>
							<div><a href="www.fonmoney.com" target="_blank">www.fonmoney.com</a></div>
						</div>

						<div class="form-group">
							<label for="">Registered Address</label>
							<div>17 Heathman's Road</div>
						</div>

						<div class="form-group">
							<label for="">The Tax District</label>
							<div>vfrdfvgrdte45SSSSS</div>
						</div>
						<div class="form-group">
							<label for="">Type of accounts filling</label>
							<div>fonmoney</div>
						</div>

						<div class="form-group">
							<label for="">Latest annual returns</label>
							<div>Invalid date</div>
						</div>

						<div class="form-group">
							<label for="">Next annual returns due</label>
							<div>Invalid date</div>
						</div>
					</div>

					<div class="col-sm-4">
						<div class="form-group">
							<label for="">Latest annual accounts</label>
							<div>Invalid date</div>
						</div>

						<div class="form-group">
							<label for="">Next annual accounts due</label>
							<div>Invalid date</div>
						</div>

						<div class="form-group">
							<label for="">SIC 2007</label>
							<div>68999</div>
						</div>

						<div class="form-group">
							<label for="">Social Media</label>
							<div>fonmoney</div>
						</div>

						<div class="form-group">
							<label for="">Trading Address</label>
							<div>17 Heathman's Road, SW6 4TJ</div>
						</div>

						<div class="form-group">
							<label for="">HMRC Reference</label>
							<div>FEDSFEWRFE34543554</div>
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane p-3" id="other-rounds" role="tabpanel">
				<!-- test -->
				<div class="row border proposal_horizontal-card">
					<div class="col-sm-8 proposal-details">
						<div class="media h-100">
							<div class="proposal-logo align-self-center mr-3 text-center text-sm-left mt-3 mt-sm-0">
								<img src="https://dummyimage.com/100x100" alt="" class="img-fluid">
							</div>
							<div class="media-body d-sm-flex align-items-sm-center py-3 h-100">
						    	<div class="w-100">
						    		<p class="text-center text-sm-left">
						    			<a href="">lorem ipsum dollar crudeo</a>
						    		</p>
						    		<div class="row additional-info">
						    			<div class="col-sm-4 text-center">
						    				<strong class="text-primary">7</strong>
						    				<div>Added to watchlist</div>
						    			</div>
						    			<div class="col-sm-4 text-center">
						    				<strong class="text-primary">0</strong>
						    				<div>Pledgers</div>
						    			</div>
						    			<div class="col-sm-4 text-center">
						    				<strong class="text-primary">4</strong>
						    				<div>Investors</div>
						    			</div>
						    		</div>
						    	</div>
						  </div>
						</div>
					</div>
					<div class="col-sm-4 text-center d-sm-flex align-items-sm-center justify-content-sm-center py-3">
						<div class="view-proposal">
							<p class="mb-1">1st Round</p>
							<p class="mb-1">Total Investment: <span class="text-primary">&pound; 998</span></p>
							<p>Number of Questions: <span class="text-primary">0</span></p>
							<a href="" class="btn btn-primary">View Proposal</a>
						</div>
					</div>
				</div>

				<div class="row border proposal_horizontal-card">
					<div class="col-sm-8 proposal-details">
						<div class="media h-100">
							<div class="proposal-logo align-self-center mr-3 text-center text-sm-left mt-3 mt-sm-0">
								<img src="https://dummyimage.com/100x100" alt="" class="img-fluid">
							</div>
							<div class="media-body d-sm-flex align-items-sm-center py-3 h-100">
						    	<div class="w-100">
						    		<p class="text-center text-sm-left">
						    			<a href="">lorem ipsum dollar crudeo</a>
						    		</p>
						    		<div class="row additional-info">
						    			<div class="col-sm-4 text-center">
						    				<strong class="text-primary">7</strong>
						    				<div>Added to watchlist</div>
						    			</div>
						    			<div class="col-sm-4 text-center">
						    				<strong class="text-primary">0</strong>
						    				<div>Pledgers</div>
						    			</div>
						    			<div class="col-sm-4 text-center">
						    				<strong class="text-primary">4</strong>
						    				<div>Investors</div>
						    			</div>
						    		</div>
						    	</div>
						  </div>
						</div>
					</div>
					<div class="col-sm-4 text-center d-sm-flex align-items-sm-center justify-content-sm-center py-3">
						<div class="view-proposal">
							<p class="mb-1">1st Round</p>
							<p class="mb-1">Total Investment: <span class="text-primary">&pound; 998</span></p>
							<p>Number of Questions: <span class="text-primary">0</span></p>
							<a href="" class="btn btn-primary">View Proposal</a>
						</div>
					</div>
				</div>
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
						<a href="javascript:void(0);" data-toggle="modal" data-target="#exampleModal">link</a>
					</div>
					<video autobuffer controls class="w-100 d-block">
					  <source id="mp4" src="http://grochtdreis.de/fuer-jsfiddle/video/sintel_trailer-480.mp4" type="video/mp4">
					</video>
				</div>
			</div>
			<div class="col-sm-6 col-12 mt-4 mt-sm-0">
				<div>
					<div class="d-flex justify-content-between mb-2">
						<p class="mb-0">Pitch Event Video</p>
						<a href="">link</a>
					</div>
					<video autobuffer controls class="w-100 d-block">
					  <source id="mp4" src="http://grochtdreis.de/fuer-jsfiddle/video/sintel_trailer-480.mp4" type="video/mp4">
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
		<div id="management-team" class="carousel slide mt-3" data-ride="carousel">
		  	<div class="carousel-inner">
		    	<div class="carousel-item active">
		     		<!-- content -->
		     		<div class="media management-individual">
		     			<div class="avatar align-self-start mr-3 mb-3 mb-sm-0">
		     				<img class="img-fluid" src="https://dummyimage.com/150x150" alt="Generic placeholder image">
		     			</div>
		     			<div class="media-body">
		     		    	<h5 class="mt-0">John Doe <small class="designation">(CEO)</small></h5>
		     		    	<p class="bio">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, voluptates corrupti velit. Ducimus voluptates cupiditate beatae, voluptate aliquid facilis repellat nobis, assumenda aut ex quas quod ab architecto incidunt eveniet.</p>
		     		    	<hr>
		     		    	<div class="row">
		     		    		<div class="col-sm-6">
		     		    			<div class="form-group">
		     		    				<label for="">Employment Status:</label>
		     		    				<div>Pre-Investment: <span>Full Time</span></div>
		     		    				<div>Post-Investment: <span>Full Time</span></div>
		     		    			</div>
		     		    		</div>
		     		    		<div class="col-sm-6">
		     		    			<div class="form-group">
		     		    				<label for="">Equity holding(Pre-Investment):</label>
		     		    				<div>12%</div>
		     		    			</div>
		     		    		</div>
		     		    	</div>
		     			</div>
		     		</div>
		     		<!-- /content -->
		    	</div>
		    	<div class="carousel-item">
		      		<!-- content -->
		     		<div class="media management-individual">
		     			<div class="avatar align-self-start mr-3 mb-3 mb-sm-0">
		     				<img class="img-fluid" src="https://dummyimage.com/150x150" alt="Generic placeholder image">
		     			</div>
		     			<div class="media-body">
		     		    	<h5 class="mt-0">Jane Doe <small class="designation">(CTO)</small></h5>
		     		    	<p class="bio">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, voluptates corrupti velit. Ducimus voluptates cupiditate beatae, voluptate aliquid facilis repellat nobis, assumenda aut ex quas quod ab architecto incidunt eveniet.</p>
		     		    	<hr>
		     		    	<div class="row">
		     		    		<div class="col-sm-6">
		     		    			<div class="form-group">
		     		    				<label for="">Employment Status:</label>
		     		    				<div>Pre-Investment: <span>Full Time</span></div>
		     		    				<div>Post-Investment: <span>Full Time</span></div>
		     		    			</div>
		     		    		</div>
		     		    		<div class="col-sm-6">
		     		    			<div class="form-group">
		     		    				<label for="">Equity holding(Pre-Investment):</label>
		     		    				<div>12%</div>
		     		    			</div>
		     		    		</div>
		     		    	</div>
		     			</div>
		     		</div>
		     		<!-- /content -->
		    	</div>
		  	</div>
		  	<a class="carousel-control-prev" href="#management-team" role="button" data-slide="prev">
		    	<span class="fa fa-chevron-left" aria-hidden="true"></span>
		    	<span class="sr-only">Previous</span>
		  	</a>
		  	<a class="carousel-control-next" href="#management-team" role="button" data-slide="next">
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
<div class="col-sm-4 mt-3 mt-sm-0 bg-dark text-white">
	
	
			<!-- canvas -->
			<!-- http://www.tothenew.com/blog/tutorial-to-create-a-circular-progress-bar-with-canvas/ -->
			@if(!in_array('vct',$tax_status))
			<!-- <canvas id="myCanvas" width="150" height="150" class="m-auto d-block"></canvas> -->
			<div class="text-center mt-3">
				<input type="text" class="knob animated" data-width="120" data-height="120" data-cursor="false" data-thickness=".2" rel="{{$bi_fund_raised_percentage}}" value="0">
			</div>
			<script>
			// var canvas = document.getElementById('myCanvas');
			// var context = canvas.getContext('2d');
			// var al=0;
			// var start=4.72;
			// var cw=context.canvas.width/2;
			// var ch=context.canvas.height/2;
			// var diff;
			 
			// function progressBar(){
			// diff=(al/100)*Math.PI*2;
			// context.clearRect(0,0,400,200);
			// context.beginPath();
			// context.arc(cw,ch,50,0,2*Math.PI,false);
			// context.fillStyle='transparent';
			// context.fill();
			// context.strokeStyle='#FFF';
			// context.stroke();
			// context.fillStyle='#FFF';
			// context.strokeStyle='#00A9EE';
			// context.textAlign='center';
			// context.lineWidth=15;
			// context.font = '10pt Open Sans';
			// context.beginPath();
			// context.arc(cw,ch,50,start,diff+start,false);
			// context.stroke();
			// context.fillText(al+'%',cw+2,ch+6);
			// if(al>=56){
			// clearTimeout(bar);
			// }
			 
			// al++;
			// }
			 
			// var bar=setInterval(progressBar,{{$bi_fund_raised_percentage}});
			</script>
			@endif
			<!-- /canvas -->
			@if($type=="fund")
				<h5 class="text-white section-title font-weight-medium mt-3 mb-3">Fund Summary</h5>
				<div class="text-center m-t-25 m-b-15">              
					<img src="{{url('img/seedtransperant.png')}}">              
				</div>
			@endif

			<ul class="list-unstyled">
				@if($type=="proposal")
				<!-- Proposal Card -->
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Investment Sought</strong></div>
						<div>{{format_amount($bi_investment_sought, 0, true, true)}}</div>
					</li>
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Minimum Investment</strong></div>
						<div>{{format_amount($bi_minimum_investment, 0, true, true)}}</div>
					</li>
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Funded</strong></div>
						<div>{{format_amount($bi_fund_raised, 0, true, true)}}</div>
					</li>
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Funds Pledged</strong></div>
						<div>{{format_amount($bi_pledged, 0, true, true)}}</div>
					</li>
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Remaining</strong></div>
						<div>{{format_amount($bi_funds_yet_to_raise, 0, true, true)}}</div>
					</li>
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Equity Offer</strong></div>
						<div>{{$proposal_details['percentage-giveaway']==""?"0":format_amount($proposal_details['percentage-giveaway'], 0, false, false) }}%</div>
					</li>
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Pre Money Valuation</strong> <a href=""><i class="fa fa-info-circle"></i></a></div>
						<div>{{$proposal_details['pre-money-valuation']==""?"-":format_amount($proposal_details['pre-money-valuation'], 0, true, true) }}</div>
					</li>
					<li class="d-flex justify-content-between pt-2 pb-2 ">
						<div><strong>Post Money Valuation</strong></div>
						<div>{{$proposal_details['post-money-valuation']==""?"-":format_amount($proposal_details['post-money-valuation'], 0, true, true) }}</div>
					</li>
					<!-- /Proposal Card -->
				@elseif($type=="fund")
					<!-- Fund Card -->
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Fund Name</strong></div>
						<div>{{$title}}</div>
					</li>
					@if(!in_array('vct',$tax_status))
						<!-- Non VCT TYpe -->
						<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
							<div><strong>Investment Focus</strong></div>
							<div>{{$investment_objective}}</div>
						</li>
						<!-- /Non VCT TYpe -->
					@endif
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Fund Tax Status</strong></div>
						<div>
							@foreach($tax_status as $t_status)
								{{strtoupper($t_status)}},
							@endforeach
						</div>
					</li>
					@if(in_array('vct',$tax_status))
						<!--VCT TYpe -->
						<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
							<div><strong>Investment Strategy</strong></div>
							<div>
								@if(is_null($fundvct_details['investmentstrategy'] || $fundvct_details['investmentstrategy']==''))
								 	- 
								@elseif($fundvct_details['investmentstrategy']=='aim') 
									AIM
								@elseif($fundvct_details['investmentstrategy']!='')
									{{str_replace('_',' ',ucfirst($fundvct_details['investmentstrategy']))}}
								@endif
							</div>
						</li>
						<!-- /VCT TYpe -->
					@endif
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Fund Status</strong></div>
						<div>
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
					</li>
					@if(!in_array('vct',$tax_status))
						<!-- Non VCT TYpe -->
						<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
							<div><strong>Minimum Investment</strong></div>
							<div>{{format_amount($minimum_investment, 0, true, true)}}</div>
						</li>
						<!-- Non VCT TYpe -->
					@endif
					<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
						<div><strong>Initial Charge</strong></div>
						<div>{{$fundcharges_details['initialcharge']!=''?$fundcharges_details['initialcharge']."%":"-"}}</div>
					</li>
					@if(in_array('vct',$tax_status))
						<!--VCT TYpe -->
						<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
							<div><strong>Growthinvest Discount</strong></div>
							<div>{{$fundvct_details['growthinvestdiscount']!=''?$fundvct_details['growthinvestdiscount']:"-"}}</div>
						</li>
						<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
							<div><strong>Deadline Date</strong></div>
							<div>{{$fundvct_details['deadlinedate']}}</div>
						</li>
						<!-- /VCT TYpe -->
					@elseif(!in_array('vct',$tax_status))
							<!-- Non VCT TYpe -->
							<li class="d-flex justify-content-between border-bottom border-white pt-2 pb-2">
								<div><strong>Annual Management Charge</strong> <a href=""><i class="fa fa-info-circle"></i></a></div>
								<div>{{$fundcharges_details['annualmanagementfee']!=''?$fundcharges_details['annualmanagementfee']."%":"-"}}</div>
							</li>
							<li class="d-flex justify-content-between  pt-2 pb-2">
								<div><strong>Maximum Fund Size</strong></div>
								<div>{{format_amount($target_amount, 0, true, true)}}</div>
							</li>
							<!-- Non VCT TYpe -->
					@endif
					<!-- /Fund Card -->
				@endif
				
			</ul>
		</div>
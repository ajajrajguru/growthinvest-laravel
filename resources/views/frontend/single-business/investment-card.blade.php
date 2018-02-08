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
					<div>{{format_amount($bi_investment_sought, 0, true, true)}}</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Minimum Investment</strong></div>
					<div>{{format_amount($bi_minimum_investment, 0, true, true)}}</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Funded</strong></div>
					<div>{{format_amount($bi_fund_raised, 0, true, true)}}</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Funds Pledged</strong></div>
					<div>{{format_amount($bi_pledged, 0, true, true)}}</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Remaining</strong></div>
					<div>{{format_amount($bi_funds_yet_to_raise, 0, true, true)}}</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Equity Offer</strong></div>
					<div>{{$proposal_details['percentage-giveaway']==""?"0":format_amount($proposal_details['percentage-giveaway'], 0, false, false) }}%</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Pre Money Valuation</strong> <a href=""><i class="fa fa-info-circle"></i></a></div>
					<div>{{$proposal_details['pre-money-valuation']==""?"-":format_amount($proposal_details['pre-money-valuation'], 0, true, true) }}</div>
				</li>
				<li class="d-flex justify-content-between">
					<div><strong>Post Money Valuation</strong></div>
					<div>{{$proposal_details['post-money-valuation']==""?"-":format_amount($proposal_details['post-money-valuation'], 0, true, true) }}</div>
				</li>
				
			</ul>
		</div>
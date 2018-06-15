@extends('layouts.frontend')

 
@section('frontend-content')


<div class="container pb-5">

<!-- mobile filter --> 
<div class="mobile-filter-btn rounded-circle pulse d-md-none"> 
	<i class="fa fa-filter"></i> 
</div> 
<!-- /mobile filter -->

 
<!-- tabs -->
<div class="squareline-tabs mt-5">

	@include('frontend.investor.topmenu')
</div>
<!-- /tabs -->

 

	<div class="row mt-5">
		 			
		<div class="col-sm-12">
			<div class="media user-info">
                <div class="user-avatar align-self-center mr-3 mw-80 mh-80">
                    <img class="rounded-circle img-fluid" src="{{ $profilePic }}" alt="Generic placeholder image">
                </div>
                <div class="media-body align-self-center">
                    <div class="">
                        <label for="">Name: </label>
                        <span>{{ $user->first_name.' '.$user->last_name }}</span>
                    </div>

                    <div class="">
                        <label for="">Classification: </label>
                        <span>{{ $investorCertification }}</span>
                    </div>
              </div>
            </div>
		</div>
		
		<div class="col-sm-12">

			<p>Welcome to your dashboard. From here you will be able to manage your investments, analyse your overall portfolio or watch lists, transfer assets onto the platform, or make investments in a wide range of single companies and funds.

</p>
 

			<p>	
			Please click on each dashboard, or the links below:<br>
			<ul class="w-disc">         
				<li><a href="{{ url('/user-dashboard/business-proposals') }}" class="bold brand-text">My Portfolio </a> : Review your existing investments, pledges and any other assets</li>      
				<li><a href="{{ url('/user-dashboard/my-activity') }}" class="bold brand-text">My Activity</a> :Review my our recent activity on the platform</li>  
				<li><a href="{{ url('/user-dashboard/my-profile') }}" class="bold brand-text">My Profile</a> : Review and edit your profile, contact, account and financial details review</li>     
				<li><a href="{{ url('/user-dashboard/my-profile') }}" class="bold brand-text">My Documents</a> : Find and Access all your relevant investment and other documents</li>     
				<li><a href="{{ url('/user-dashboard/news-updates') }}" class="bold brand-text">Latest News/Updates</a> : Catch up on industry news and updates and information on your investments..</li>
			</ul>
			</p>

		</div>

			 
	</div>
</div>
	 
 
 
</div> <!-- /container -->
 
 
 


@include('includes.footer')
@endsection
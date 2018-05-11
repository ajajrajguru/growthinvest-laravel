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

	<ul class="nav nav-tabs">
 
		
		<li class="nav-item ">
	   		<a class="nav-link px-sm-5 @if($active_menu == 'dashboard') active @endif"  href="{{ url('/user-dashboard/') }}">Dashboard</a>
		</li>
		
 
		<li class="nav-item ">
	    	<a class="nav-link px-sm-5 @if($active_menu == 'business-proposals') active @endif"  href="{{ url('/user-dashboard/business-proposals') }}">Business Proposals</a>
		</li>
 
		<li class="nav-item ">
	    	<a class="nav-link px-sm-5 @if($active_menu == 'activities') active @endif"  href="{{ url('/user-dashboard/activities') }}">My Activity</a>
 
		</li>
		<li class="nav-item ">
	    	<a class="nav-link px-sm-5 @if($active_menu == 'profile') active @endif"  href="{{ url('/user-dashboard/my-profile') }}">My Profile</a>
 
		</li>
		<li class="nav-item ">
	    	<a class="nav-link px-sm-5 @if($active_menu == 'news-updates') active @endif"  href="{{ url('/user-dashboard/news-updates') }}">Latest News/Updates</a>
 
		</li>
		 
						
		
	</ul>
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
                        <span>Entrepreneur</span>
                    </div>
              </div>
            </div>
		</div>
		
		<div class="col-sm-12">

			<p>Welcome to your dashboards. From here you will be able to submit business proposals, analyse and monitor investor activity on your investment offers, and keep up your profile and offer information up to date. Any new proposals can be added under the Business Proposals tab.</p>

			<p>Please do not hesitate to contact us for help or advice at any stage.  Please contact us via <a href="mailto:support@growthinvest.com">support@growthinvest.com</a>, or <a href="tel:02070713945">020 7071 3945</a> 

			<p>	
			Please click on each dashboard, or the links below:<br>
			<ul class="w-disc">         
				<li><a href="{{ url('/user-dashboard/business-proposals') }}" class="bold brand-text">Business Proposals</a> : Review or add proposals  onto the site</li>      
				<li><a href="{{ url('/user-dashboard/activities') }}" class="bold brand-text">Activity</a> : Monitor your own and investor activity on the offers</li>  
				<li><a href="{{ url('/user-dashboard/my-profile') }}" class="bold brand-text">Profile</a> : Review and edit your profile</li>     
				<li><a href="{{ url('/user-dashboard/news-updates') }}" class="bold brand-text">Latest News/Updates</a> : Keep up to date with the latest platform and industry news.</li>
			</ul>
			</p>

		</div>

			 
	</div>
</div>
	 
 
 
</div> <!-- /container -->
 
 
 


@include('includes.footer')
@endsection
<ul class="nav nav-tabs">

	<li class="nav-item ">
   		<a class="nav-link px-sm-5 @if($active_menu == 'dashboard') active @endif"  href="{{ url('/user-dashboard/') }}">Dashboard</a>
	</li>
	

	<li class="nav-item ">
    	<a class="nav-link px-sm-5 @if($active_menu == 'business-proposals') active @endif"  href="{{ url('/user-dashboard/business-proposals') }}">Business Proposals</a>
	</li>

	<li class="nav-item ">
    	<a class="nav-link px-sm-5 @if($active_menu == 'my_activity') active @endif"  href="{{ url('/user-dashboard/my-activity') }}">My Activity</a>

	</li>
	<li class="nav-item ">
    	<a class="nav-link px-sm-5 @if($active_menu == 'profile') active @endif"  href="{{ url('/user-dashboard/my-profile') }}">My Profile</a>

	</li>
	<li class="nav-item ">
    	<a class="nav-link px-sm-5 @if($active_menu == 'news-updates') active @endif"  href="{{ url('/user-dashboard/news-updates') }}">Latest News/Updates</a>

	</li>
	
</ul>
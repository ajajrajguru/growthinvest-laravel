		<div class="squareline-tabs">
    <ul class="nav nav-tabs">
	 		<li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'manage-backoffice') active @endif "   href="{{url('backoffice/manage/manage-backoffice')}}">Manage Backoffice <div><small>(Coming Soon..)</small></div></a>
           </li>
            <li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'manage-frontoffice') active @endif "  href="{{url('backoffice/manage/manage-frontoffice')}}">Manage Frontoffice <div><small>(Coming Soon..)</small></div></a>
           </li>
	 		<li class="nav-item">
               <a class="nav-link d-none d-sm-block h-100 @if($activeMenu == 'users') active @endif "   href="{{url('backoffice/user/all')}}"><div class="mt-0 mt-sm-2">View/Add User</div></a>
           </li>
          
           <li class="nav-item">
               <a class="nav-link d-none d-sm-block h-100 @if($activeMenu == 'firms') active @endif "   href="{{url('backoffice/firm')}}"><div class="mt-0 mt-sm-2">View/Add Firm</div></a>
           </li>
           <li class="nav-item">
               <a class="nav-link d-none d-sm-block h-100 @if($activeMenu == 'intermediate') active @endif "   href="{{url('backoffice/user/intermediate')}}"><div class="mt-0 mt-sm-2">Intermediary Registration</div></a>
           </li>
            <li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'manage-companylist') active @endif " href="{{url('backoffice/manage/companylist')}}">View/Add Company <div><small>(Coming Soon..)</small></div></a>
           </li>
           <li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'manage-activityfeedgroup') active @endif "   href="{{url('backoffice/manage/manage-act-feed-group')}}">Activity Feed Group <div><small>(Coming Soon..)</small></div></a>
           </li>
       </ul>
</div>
		<div class="squareline-tabs">
    <ul class="nav nav-tabs">
	 		<li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'manage-backoffice') active @endif "   href="{{url('backoffice/manage/manage-backoffice')}}">Manage Backoffice</a>
           </li>
            <li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'manage-frontoffice') active @endif "  href="{{url('backoffice/manage/manage-frontoffice')}}">Manage Frontoffice</a>
           </li>
	 		<li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'users') active @endif "   href="{{url('backoffice/user/all')}}">View/Add User</a>
           </li>
          
           <li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'firms') active @endif "   href="{{url('backoffice/firm')}}">View/Add Firm</a>
           </li>
           <li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'intermediate') active @endif "   href="{{url('backoffice/user/intermediate')}}">Intermediary Registration</a>
           </li>
            <li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'manage-companylist') active @endif " href="{{url('backoffice/manage/companylist')}}">View/Add Company</a>
           </li>
           <li class="nav-item">
               <a class="nav-link d-none d-sm-block @if($activeMenu == 'manage-activityfeedgroup') active @endif "   href="{{url('backoffice/manage/manage-act-feed-group')}}">Activity Feed Group</a>
           </li>
       </ul>
</div>
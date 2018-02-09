		<div class="squareline-tabs">
    <ul class="nav nav-tabs">
	 		<li class="nav-item">
               <a class="nav-link d-none d-sm-block coming-soon @if($activeMenu == 'manage-backoffice') active @endif "   href="{{url('backoffice/manage/manage-backoffice')}}">Manage Backoffice </a>
           </li>
            <li class="nav-item">
               <a class="nav-link d-none d-sm-block coming-soon @if($activeMenu == 'manage-frontoffice') active @endif "  href="{{url('backoffice/manage/manage-frontoffice')}}">Manage Frontoffice </a>
           </li>
	 		      <li class="nav-item">
               <a class="nav-link d-none d-sm-block h-100 @if($activeMenu == 'users') active @endif "   href="{{url('backoffice/user/all')}}"><div class="">View/Add User</div></a>
           </li>

           <li class="nav-item">
               <a class="nav-link d-none d-sm-block h-100 @if($activeMenu == 'firms') active @endif "   href="{{url('backoffice/firm')}}"><div class="">View/Add Firm</div></a>
           </li>
           <li class="nav-item">
               <a class="nav-link d-none d-sm-block h-100 @if($activeMenu == 'intermediate') active @endif "   href="{{url('backoffice/user/intermediate')}}"><div class="">Intermediary Registration</div></a>
           </li>
            <li class="nav-item">
               <a class="nav-link d-none d-sm-block coming-soon @if($activeMenu == 'manage-companylist') active @endif " href="{{url('backoffice/manage/companylist')}}">View/Add Company </a>
           </li>
           <li class="nav-item">
               <a class="nav-link d-none d-sm-block coming-soon @if($activeMenu == 'manage-activityfeedgroup') active @endif "   href="{{url('backoffice/manage/manage-act-feed-group')}}">Activity Feed Group </a>
           </li>
       </ul>
</div>
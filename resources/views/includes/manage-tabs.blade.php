		<ul class="nav nav-tabs chromelike-tabs mb-4">
	 		<li class="nav-item">
               <a class="nav-link @if($activeMenu == 'manage-backoffice') active @endif " target="_blank" href="{{url('backoffice/manage/manage-backoffice')}}">Manage Backoffice</a>
           </li>
            <li class="nav-item">
               <a class="nav-link @if($activeMenu == 'manage-frontoffice') active @endif " target="_blank" href="{{url('backoffice/manage/manage-frontoffice')}}">Manage Frontoffice</a>
           </li>
	 		<li class="nav-item">
               <a class="nav-link @if($activeMenu == 'users') active @endif " target="_blank" href="{{url('backoffice/user/all')}}">View/Add User</a>
           </li>
          
           <li class="nav-item">
               <a class="nav-link @if($activeMenu == 'firms') active @endif " target="_blank" href="{{url('backoffice/firm')}}">View/Add Firm</a>
           </li>
           <li class="nav-item">
               <a class="nav-link @if($activeMenu == 'intermediate') active @endif " target="_blank" href="{{url('backoffice/user/intermediate')}}">Intermediary Registration</a>
           </li>
            <li class="nav-item">
               <a class="nav-link @if($activeMenu == 'manage-companylist') active @endif " target="_blank" href="{{url('backoffice/manage/companylist')}}">View/Add Company</a>
           </li>
           <li class="nav-item">
               <a class="nav-link @if($activeMenu == 'manage-activityfeedgroup') active @endif " target="_blank" href="{{url('backoffice/manage/manage-act-feed-group')}}">Activity Feed Group</a>
           </li>
       </ul>

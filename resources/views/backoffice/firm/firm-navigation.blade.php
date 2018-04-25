<div class="squareline-tabs">
    <ul class="nav nav-tabs">
            <li class="nav-item">
               <a class="nav-link d-none d-sm-block coming-soon @if($firmActiveMenu == 'firm-details') active @endif "   href="{{url('backoffice/firms/'.$firm->gi_code)}}">Firm Details </a>
           </li>
            <li class="nav-item">
               <a class="nav-link d-none d-sm-block coming-soon @if($firmActiveMenu == 'firm-users') active @endif "  href="{{url('backoffice/firm/'.$firm->gi_code.'/users')}}">View/Add Users </a>
           </li>
                  <li class="nav-item">
               <a class="nav-link d-none d-sm-block h-100 @if($firmActiveMenu == 'firm-business-clients') active @endif "   href="{{url('backoffice/firm/'.$firm->gi_code.'/business-clients')}}"><div class="">Business Clients</div></a>
           </li>

           <li class="nav-item">
               <a class="nav-link d-none d-sm-block h-100 @if($firmActiveMenu == 'firm-investment-clients') active @endif "   href="{{url('backoffice/firm/'.$firm->gi_code.'/investment-clients')}}"><div class="">Investment Clients</div></a>
           </li>
           <li class="nav-item">
               <a class="nav-link d-none d-sm-block h-100 @if($firmActiveMenu == 'investors') active @endif "   href="{{url('backoffice/firm/'.$firm->gi_code.'/investors')}}"><div class="">Investors</div></a>
           </li>
       </ul>
</div>

<br>
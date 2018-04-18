<ul class="nav nav-tabs nav-tabs--vertical nav-tabs--left" role="navigation">
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard')}}" class="nav-link @if($activeMenu == 'home') active @endif"   role="tab">Home<div><small>(Coming Soon..)</small></div></a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard/portfolio')}}" class="nav-link @if($activeMenu == 'portfolio') active @endif"   role="tab">Portfolio Summary<div><small>(Coming Soon..)</small></div></a>
    </li>

    <li class="nav-item">
        <a href="{{url('backoffice/investor')}}" class="nav-link @if($activeMenu == 'manage_clients') active @endif"   role="tab">Manage Clients <div><small>(Coming Soon..)</small></div></a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/investor/registration')}}" class="nav-link @if($activeMenu == 'add_clients') active @endif"   role="tab">Add Clients<div><small>(Coming Soon..)</small></div></a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard/investment_offers')}}" class="nav-link @if($activeMenu == 'investment_offers') active @endif"   role="tab">Investment Offers<div><small>(Coming Soon..)</small></div></a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard/transferasset')}}" class="nav-link @if($activeMenu == 'transferassets') active @endif"   role="tab">Transfer Assets<div><small>(Coming Soon..)</small></div></a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/activity/summary')}}" class="nav-link @if($activeMenu == 'activity') active @endif"   role="tab">Activity Analysis<div><small>(Coming Soon..)</small></div></a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard/compliance')}}" class="nav-link @if($activeMenu == 'documents') active @endif"   role="tab">Document Library<div><small>(Coming Soon..)</small></div></a>
    </li>
     <li class="nav-item">
        <a href="{{url('backoffice/dashboard/financials')}}" class="nav-link @if($activeMenu == 'financials') active @endif"   role="tab">Financials<div><small>(Coming Soon..)</small></div></a>
    </li>
     <li class="nav-item">
        <a href="{{url('backoffice/dashboard/knowledge')}}" class="nav-link @if($activeMenu == 'knowledge') active @endif"   role="tab">Knowledge Portal<div><small>(Coming Soon..)</small></div></a>
    </li>
</ul>
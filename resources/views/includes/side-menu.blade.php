<ul class="nav nav-tabs nav-tabs--vertical nav-tabs--left" role="navigation">
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard')}}" class="nav-link @if($activeMenu == 'home') active @endif"   role="tab">Home</a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard/portfolio')}}" class="nav-link @if($activeMenu == 'portfolio') active @endif"   role="tab">Portfolio Summary</a>
    </li>

    <li class="nav-item">
        <a href="{{url('backoffice/investor')}}" class="nav-link @if($activeMenu == 'manage_clients') active @endif"   role="tab">Manage Clients</a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/investor/registration')}}" class="nav-link @if($activeMenu == 'add_clients') active @endif"   role="tab">Add Clients</a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard/investment_offers')}}" class="nav-link @if($activeMenu == 'investment_offers') active @endif"   role="tab">Investment Offers</a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard/transferasset')}}" class="nav-link @if($activeMenu == 'transferassets') active @endif"   role="tab">Transfer Assets</a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard/activity_feed/summary')}}" class="nav-link @if($activeMenu == 'activity') active @endif"   role="tab">Activity Analysis</a>
    </li>
    <li class="nav-item">
        <a href="{{url('backoffice/dashboard/compliance')}}" class="nav-link @if($activeMenu == 'documents') active @endif"   role="tab">Document Library</a>
    </li>
     <li class="nav-item">
        <a href="{{url('backoffice/dashboard/financials')}}" class="nav-link @if($activeMenu == 'financials') active @endif"   role="tab">Financials</a>
    </li>
     <li class="nav-item">
        <a href="{{url('backoffice/dashboard/knowledge')}}" class="nav-link @if($activeMenu == 'knowledge') active @endif"   role="tab">Knowledge Portal</a>
    </li>
</ul>
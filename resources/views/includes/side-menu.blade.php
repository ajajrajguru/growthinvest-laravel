<ul class="nav nav-tabs nav-tabs--vertical nav-tabs--left" role="navigation">
    <li class="nav-item">
        <a href="#home" class="nav-link @if($activeMenu == 'home') active @endif" data-toggle="tab" role="tab">Home</a>
    </li>
    <li class="nav-item">
        <a href="#manage_clients" class="nav-link @if($activeMenu == 'manage_clients') active @endif" data-toggle="tab" role="tab">Manage Clients</a>
    </li>
    <li class="nav-item">
        <a href="#add_clients" class="nav-link @if($activeMenu == 'add_clients') active @endif" data-toggle="tab" role="tab">Add Clients</a>
    </li>
    <li class="nav-item">
        <a href="#investment_offers" class="nav-link @if($activeMenu == 'investment_offers') active @endif" data-toggle="tab" role="tab">Investment Offers</a>
    </li>
</ul>
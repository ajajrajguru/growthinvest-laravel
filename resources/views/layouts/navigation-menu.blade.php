
<nav class="navbar navbar-inverse bg-primary">

   <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">GrowthInvest</a>
    </div>

    <ul   class="nav navbar-nav">
      <li class="active"><a href="/dashboard">Dashboard</a></li>
    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Investments<span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="http://eisplatform.com/investment-opportunities/#single-companies">EIS &amp; SEIS - Single Companies</a></li>
      <li><a href="/investment-opportunities/#funds">EIS &amp; SEIS - Funds &amp; Portfolios</a></li>
      <li><a href="/investment-opportunities/#vcts">VCTs</a></li>
    </ul>
    </li>
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Services<span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="/what-we-offer-investors/">What We Offer Investors</a></li>
        <li><a href="/advisers/">What We Offer Advisers</a></li>
        <li><a href="/entrepreneurs/">What We Offer Entrepreneurs</a></li>
      </ul>
    </li>
    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"  > More <span class="caret"></span> </a>

      <ul class="dropdown-menu">
        <li><a href="/about-us/">About Us</a></li>
        <li><a href="/tax-efficient-investments/">Tax Efficient Investments</a></li>
        <li><a href="/news-updates/">News</a></li>
        <li><a href="/upcoming-eventsbak/">Events</a></li>
        <li><a href="/press/">Press</a></li>
        <li><a href="/publications/">Publications</a></li>
        <li><a href="/faq/">FAQs</a></li>
        <li><a href="/partners/">Partners</a></li>
        <li><a href="/contact-us/">Contact Us</a></li>
      </ul>
    </li>

    @if(Auth::check())
    <li ><a href="/logout">Logout</li>
    @endif
  <?php $admin_menus = Session::get('user_menus')?>
  @if(count($admin_menus['admin'])>0 )
    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"  > Admin <span class="caret"></span> </a>

      <ul class="dropdown-menu">

        @foreach($admin_menus['admin'] as $menu_item)
        <li><a href="{{$menu_item->url}}">{{$menu_item->name}}</a></li> 
        @endforeach
        <!-- <li><a href="/about-us/">Manage</a></li>
        <li><a href="/tax-efficient-investments/">Statistics</a></li>
        <li><a href="/news-updates/">View Document Templates</a></li>
        <li><a href="/upcoming-eventsbak/">View Email Templates</a></li>
        <li><a href="/press/">View Groups</a></li>
        <li><a href="/publications/">View Leads</a></li> -->
      </ul>
    </li>
  @endif









    </ul>
</div>
</nav>








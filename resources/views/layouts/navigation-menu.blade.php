

<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">GrowthInvest</a>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Investments
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/investment-opportunities/#single-companies">EIS &amp; SEIS - Single Companies</a>
          <a class="dropdown-item" href="/investment-opportunities/#funds">EIS &amp; SEIS - Funds &amp; Portfolios</a>
          <a class="dropdown-item" href="/investment-opportunities/#vcts">VCTs</a>
        </div>
      </li>


       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Services
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/what-we-offer-investors/">What We Offer Investors</a>
          <a class="dropdown-item" href="/what-we-offer-intermediaries">What We Offer Advisers</a>
          <a class="dropdown-item" href="/what-we-offer-entrepreneurs">What We Offer Entrepreneurs</a>
        </div>
      </li>




      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          More
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> 
          <a href="/about-us/" class="dropdown-item" >About Us</a>
          <a href="/tax-efficient-investments/" class="dropdown-item" >Tax Efficient Investments</a>
          <a href="/news-updates/" class="dropdown-item" >News</a>
          <a href="/upcoming-eventsbak/" class="dropdown-item" >Events</a>
          <a href="/press/" class="dropdown-item" >Press</a>
          <a href="/publications/" class="dropdown-item" >Publications</a>
          <a href="/faq/" class="dropdown-item" >FAQs</a>
          <a href="/partners/" class="dropdown-item" >Partners</a>
          <a href="/contact-us/" class="dropdown-item" >Contact Us</a> 
        </div>
      </li>

       @if(Auth::check())

       <li class="nav-item">
        <a class="nav-link" href="/logout">Logout</a>
      </li>
      @endif

      <?php $admin_menus = Session::get('user_menus')?>
      @if(count($admin_menus['admin'])>0 )
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          @foreach($admin_menus['admin'] as $menu_item)
          <a href="{{$menu_item->url}}" class="dropdown-item" >{{$menu_item->name}}</a>
          @endforeach 
        </div>
      </li>

      @endif

    </ul>
  </div>
</nav>














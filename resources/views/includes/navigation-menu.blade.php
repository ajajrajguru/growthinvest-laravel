<header>
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">

      <div id="logo" class="gi-logo">
        <a class="" href="https://growthinvest.com/" title="GrowthInvest">
          <img src="{{ url('img/growthinvest-logo.png') }}" width="250" height="" class="logo_normal" alt="GrowthInvest">
        </a>
    </div>

    <nav id="giMenu">

        <ul class="navbar-menu">

          <li class="" id="">
            <a href="#">Dashboard</a>
          </li>
          <li class="has-submenu">
            <a href="#">Investments</a>
            <ul class="submenu">
              <li>
                <a href="/investment-opportunities/#single-companies">EIS &amp; SEIS - Single Companies</a>
              </li>
              <li>
                <a href="/investment-opportunities/#funds">EIS &amp; SEIS - Funds &amp; Portfolios</a>
              </li>
              <li>
                <a href="/investment-opportunities/#vcts">VCTs</a>
              </li>
            </ul>
          </li>
          <li class="has-submenu">
            <a href="#">Services</a>
            <ul class="submenu">
              <li>
                <a href="/what-we-offer-investors/">What We Offer Investors</a>
              </li>
              <li>
                <a href="/what-we-offer-intermediaries">What We Offer Advisers</a>
              </li>
              <li>
                <a href="/what-we-offer-entrepreneurs">What We Offer Entrepreneurs</a>
              </li>
            </ul>
          </li>
          <li class="has-submenu">
            <a href="#" style="">More</a>
            <ul class="submenu">
              <li>
                <a href="/about-us/">About Us</a>
              </li>
              <li>
                <a href="/tax-efficient-investments/">Tax Efficient Investments</a>
              </li>
              <li>
                <a href="/news-updates/">News</a>
              </li>
              <li>
                <a href="/upcoming-eventsbak/">Events</a>
              </li>
              <li>
                <a href="/press/">Press</a>
              </li>
              <li>
                <a href="/publications/">Publications</a>
              </li>
              <li>
                <a href="/faq/">FAQs</a>
              </li>
              <li>
                <a href="/partners/">Partners</a>
              </li>
              <li>
                <a href="/contact-us/">Contact Us</a>
              </li>
            </ul>
      </li>
      @if(Auth::check())
      <li class="has-submenu">
      <a class="d-flex align-items-center" href="#" id="">
        <img alt="GrowthInvest" class="" height="40" src="{{ url('img/dummy/avatar.png') }}" width="40">
        <div class="d-sm-none ml-2 small"><b>Ajency Admin</b></div>
      </a>

      <ul class="submenu user-submenu">
        <li class="avatar-name d-none d-md-block">
          <b>Ajency Admin</b>
        </li>
        <li class="">
          <a href="/profile/#view-profile" class="text-primary">View Profile</a>
        </li>
        <li class="">
          <b>Role :</b>
          <?php $role = Session::get('user_data'); ?>
          <p>{{$role['role']}}</p>
        </li>
        <li class="">
          <b>Firm Name :</b>
          <p>{{ Auth::user()->firm->name }}</p>
        </li>
        <li class="">
          <b>Firm Type :</b>
          <p>{{ Auth::user()->firm->firmType()->name }}</p>
        </li>
      </ul>
      </li>

      <li>
        <a class="" href="/logout">LOGOUT</a>
      </li>
      @endif



      <?php $admin_menus = Session::get('user_menus')?>
      @if(count($admin_menus['admin'])>0 )


      <li class="admin-dd-btn has-submenu">
      <a href="#" class="">Admin</a>
      <ul class="submenu">

         @foreach($admin_menus['admin'] as $menu_item)
         <li>
          <a href="{{$menu_item['url']}}">{{$menu_item['name']}}</a>
        </li>
        @endforeach


      </ul>
      </li>
      @endif


    </ul>


    </nav>

    </div>
  </div>
</header>

<a class="hamburger hamburger--spin mobile-menu-toggle" href="#giMenu">
  <span class="hamburger-box">
    <span class="hamburger-inner"></span>
  </span>
</a>
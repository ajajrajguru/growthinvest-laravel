@extends('layouts.backoffice')
@section('css')
@parent
<link rel="stylesheet" href="{{ asset('/bower_components/select2/dist/css/select2.min.css') }}" >

 
<style>
.chartDiv {
  width   : 100%;
  height    : 350px;
  font-size : 11px;
}



.amcharts-pie-slice {
  transform: scale(1);
  transform-origin: 50% 50%;
  transition-duration: 0.3s;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  -o-transition: all .3s ease-out;
  cursor: pointer;
  box-shadow: 0 0 30px 0 #000;
}

.amcharts-pie-slice:hover {
  transform: scale(1.1);
  filter: url(#shadow);
}             
</style>
 


@endsection

@section('js')
  @parent

<script type="text/javascript" src="{{ asset('/bower_components/amcharts3/amcharts/amcharts.js') }}" ></script>
<script type="text/javascript" src="{{ asset('/bower_components/amcharts3/amcharts/pie.js') }}" ></script>
<script type="text/javascript" src="{{ asset('/bower_components/amcharts3/amcharts/serial.js') }}" ></script>
<script type="text/javascript" src="{{ asset('/bower_components/amcharts3/amcharts/plugins/export/export.js') }}" ></script>

<script src="https://www.amcharts.com/lib/3/plugins/export/export.js"></script>
<script type="text/javascript" src="{{ asset('/bower_components/amcharts3/amcharts/themes/light.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/aj-charts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/portfolio.js') }}"></script>
 
<script type="text/javascript" src="{{ asset('/bower_components/select2/dist/js/select2.min.js') }}" ></script>




<script type="text/javascript">

    $(document).ready(function() {
        // select2

        $('.select2-single').select2({
            // placeholder: "Search here"
        });

        $('input[name="duration_from"]').datepicker({
          format: 'dd-mm-yyyy'
        }).on('changeDate', function (selected) {
          var minDate = new Date(selected.date.valueOf());
          $('input[name="duration_to"]').datepicker('setStartDate', minDate);
        });

        $('input[name="duration_to"]').datepicker({
          format: 'dd-mm-yyyy'
        }).on('changeDate', function (selected) {
          var maxDate = new Date(selected.date.valueOf());
          $('input[name="duration_from"]').datepicker('setEndDate', maxDate);
        });
 
       
    });

</script>


@endsection
@section('backoffice-content')

<div class="container">
    @php
        echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
    @endphp
   <div class="container mt-3">
    <!-- tabs -->
    <div class="squareline-tabs">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active d-none d-sm-block"   href="#portfolio">Portfolio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-none d-sm-block"  href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-invest')}}">Invest</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-none d-sm-block"  href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-activity')}}">Activity</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-none d-sm-block" href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-profile')}}">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-none d-sm-block"  href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-news-update')}}">News/Updates</a>
            </li>
        </ul>
    </div>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane p-3" id="invest" role="tabpanel">
            </div> <!-- /invest tab -->

            <div class="tab-pane p-3 active" id="profile" role="tabpanel">
                <div class="media investor-info">
                    <div class="investor-avatar align-self-center mr-3 mw-80 mh-80">
                        <img class="rounded-circle img-fluid" src="{{ $profilePic }}" alt="Generic placeholder image">
                    </div>
                    <div class="media-body align-self-center">
                        <div class="">
                            <label for="">Name: </label>
                            <span>{{ $investor->first_name.' '.$investor->last_name }}</span>
                        </div>

                        <div class="">
                            <label for="">Classification: </label>
                            <span>{{ $investorCertification }}</span>
                        </div>
                  </div>
                </div>

                <ul class="mt-3 pl-0 investor-keypoints">
                    <li class="list-unstyled mb-2"><a class="font-weight-medium text-decoration-none" href="{{ url('backoffice/investor/'.$investor->gi_code.'/registration')}}">Registration: </a> Key contact and registration details including passwords.</li>
                    <li class="list-unstyled mb-2"><a class="font-weight-medium text-decoration-none" href="{{ url('backoffice/investor/'.$investor->gi_code.'/client-categorisation')}}">Client Categorisation: </a> Amend current investor classification (eg High Net Worth, Sophisticated)</li>
                    <li class="list-unstyled mb-2"><a class="font-weight-medium text-decoration-none" href="{{ url('backoffice/investor/'.$investor->gi_code.'/additional-information') }}">Additoinal Information: </a> Picture, Social Media and Investment Profile</li>
                    <li class="list-unstyled"><a class="font-weight-medium text-decoration-none" href="{{  url('backoffice/investor/'.$investor->gi_code.'/investment-account') }}">Investment Account: </a> Full investment and transactional account details</li>
                </ul>
                
                <div class="row mt-5 ">
                    
                     
                </div>
            </div> <!-- /Profile -->
 
            <h4><i class="fa fa-list"></i> Portfolio Summary</h4>
             
                 
                  <div class="row">
                    <div class="col-sm-6"><label>Total Invested</label> <span id="total_investment">0</span></div>
                    <div class="col-sm-6"><label>Number of EIS Investments</label> <span id="eis_investment_count">0</span></div>
                  </div>
                  <div class="row">  
                    <div class="col-sm-6"><label>Number of Investments</label> <span id="number_investment">0</span></div>
                    <div class="col-sm-6"><label>EIS Total Investment</label> <span id="eis_investment_amount">0</span></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6"><label>Pledged</label> <span id="pledge">0</span></div>
                    <div class="col-sm-6"><label>Number of SEIS Investments</label> <span id="seis_investment_count">0</span></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6"><label>Following</label> <span id="followings">0</span></div>
                    <div class="col-sm-6"><label>SEIS Total Investment</label> <span id="seis_investment_amount">0</span></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6"><label>Cash Balance</label> <span id="cash_balance">0</span></div>
                    <div class="col-sm-6"><label> Number of VCT Investments</label> <span id="vct_investment_count">0</span></div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"><label> VCT Total Investment</label> <span id="vct_investment_amount">0</span></div>
                  </div>
                

               
                <div class="squareline-tabs w-100">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active d-none d-sm-block" type="portfolio" reset-data="false"  data-toggle="tab"  href="#portfolio">Portfolio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-none d-sm-block" type="pledged" data-toggle="tab" reset-data="false"  href="#pledge_tab">Pledge</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-none d-sm-block" type="watchlist" data-toggle="tab" reset-data="false"  href="#watchlist">Watchlist</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-none d-sm-block" type="transferasset" data-toggle="tab" reset-data="false" href="#transferasset">Transfer Asset</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-none d-sm-block" type="cashaccount" data-toggle="tab" reset-data="false"  href="#cashaccount">Cash Account</a>
                        </li>
                    </ul>
                     <div class="tab-content">
                        <div class="tab-pane p-3 active" id="portfolio" role="tabpanel">
                            @include('backoffice.clients.investor.portfolio')
                        </div>   
                        <div class="tab-pane p-3 " id="pledge_tab" role="tabpanel">
                            @include('backoffice.clients.investor.pledge')
                        </div>
                        <div class="tab-pane p-3" id="watchlist" role="tabpanel">
                            @include('backoffice.clients.investor.watchlist')
                        </div>
                        <div class="tab-pane p-3" id="transferasset" role="tabpanel">
                            @include('backoffice.clients.investor.transferasset')
                        </div>
                        <div class="tab-pane p-3" id="cashaccount" role="tabpanel">
                            @include('backoffice.clients.investor.cashaccount')
                        </div> 
                    </div>
                </div>


               
 
        </div>
       
    </div>

    <!-- Modal -->

</div>
 
    <style type="text/css">
        #datatable-investors_filter{
            visibility: hidden;
        }
    </style>

@endsection


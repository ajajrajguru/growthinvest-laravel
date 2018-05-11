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
<!-- amcharts -->
<script type="text/javascript" src="{{ asset('/bower_components/amcharts3/amcharts/amcharts.js') }}" ></script>
<script type="text/javascript" src="{{ asset('/bower_components/amcharts3/amcharts/pie.js') }}" ></script>
<script type="text/javascript" src="{{ asset('/bower_components/amcharts3/amcharts/serial.js') }}" ></script>
<script type="text/javascript" src="{{ asset('/bower_components/amcharts3/amcharts/plugins/export/export.js') }}" ></script>

<script src="https://www.amcharts.com/lib/3/plugins/export/export.js"></script>
<script type="text/javascript" src="{{ asset('/bower_components/amcharts3/amcharts/themes/light.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/aj-charts.js') }}"></script>
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
    <div class="row mt-5 mx-0">
        <div class="col-md-2 bg-white px-0">
            @include('includes.side-menu')
        </div>

        <div class="col-md-10 bg-white border border-gray border-left-0 border-right-0">
            <div class="mt-4 p-2">
              <div class="row align-items-center mb-4">
                <div class="col-sm-1">
                  <img src="{{ url('img/diversity.png') }}" width="" height="" class="img-fluid" alt="Activity Analysis">
                </div>
                <div class="col-sm-11">
                  <h1 class="section-title font-weight-medium text-primary mb-0">Portfolio Summary</h1>
                </div>
              </div>



                <h5 class="mt-2 mb-0">Selection Filters</h5>

                <div class="gray-section border bg-gray p-3">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="bg-lightgray p-3">
                        <div class="form-group">
                            <select name="duration" class="form-control">
                              <option value="">Select Period</option>
                              @foreach($durationType as $durationKey=>$duration)
                                @php
                                    if(isset($requestFilters['duration']) && $requestFilters['duration'] == $durationKey){
                                        $selected = "selected";
                                    }
                                    elseif(!isset($requestFilters['duration_from']) && !isset($requestFilters['tax_year']) && !isset($requestFilters['duration']) && 'thisquater' == $durationKey){
                                        $selected = "selected";
                                    }
                                    else{
                                        $selected = "";
                                    }
                                @endphp

                                <option value="{{ $durationKey }}" {{ $selected }} >{{ $duration }}</option>
                              @endforeach

                            </select>
                        </div>

                        <p class="text-center mb-2 font-weight-bold">OR</p>

                        <div class="row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class="inner-addon right-addon">
                                  <i class="fa fa-calendar"></i>
                                  <input type="text"  placeholder="Select From Date" class="form-control datepicker date_range rounded-0" name="duration_from" value="{{ (isset($requestFilters['duration_from'])) ? $requestFilters['duration_from'] : '' }}" @if(isset($requestFilters['duration']) && $requestFilters['duration'] != '') disabled @endif @if(isset($requestFilters['tax_year']) && $requestFilters['tax_year'] != '') disabled @endif >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="inner-addon right-addon">
                                  <i class="fa fa-calendar"></i>
                                  <input type="text"  placeholder="Select To Date" class="form-control datepicker date_range rounded-0" name="duration_to" value="{{ (isset($requestFilters['duration_to'])) ? $requestFilters['duration_to'] : '' }}" @if(isset($requestFilters['duration']) && $requestFilters['duration'] != '') disabled @endif>
                                </div>
                            </div>
                        </div>
                          <p class="text-center mb-2 font-weight-bold">OR</p>

                          <div class="row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <div class="form-group">
                                    <select name="tax_year" class="form-control" @if(isset($requestFilters['duration']) && $requestFilters['duration'] != '') disabled @endif @if(isset($requestFilters['duration_from']) && $requestFilters['duration_from'] != '') disabled @endif>
                                      <option value="">Select Tax Year</option>
                                      @foreach($financialYears as $year)
                                         @php
                                          if(isset($requestFilters['tax_year']) && $requestFilters['tax_year'] == $year){
                                              $selected = "selected";
                                          }
                                          else{
                                              $selected = "";
                                          }
                                      @endphp
                                        <option value="{{ $year }}" {{ $selected }} >{{ $year }}</option>
                                      @endforeach

                                    </select>
                                </div>
                            </div>
                          
                        </div>
                      </div><!-- /bg-lightgray -->

                    
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                          <label for="">Firms</label>
                          <select name="firm" id="firm" class="form-control select2-single">
                            <option value="">View All Firms</option>
                            @foreach($firms as $firm)
                              <option value="{{ $firm->id }}" @if(isset($requestFilters['firm']) && $requestFilters['firm'] == $firm->id) selected @endif>{{ $firm->name }}</option>
                            @endforeach
                          </select>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                              <label for="">Business Proposals/Funds</label>
                              <select name="companies" id="" class="form-control select2-single">
                                <option value="">View All Companies</option>
                                @foreach($businessListings as $businessListing)
                                  <option value="{{ $businessListing->id }}" @if(isset($requestFilters['companies']) && $requestFilters['companies'] == $businessListing->id) selected @endif>{{ $businessListing->title }}</option>
                                @endforeach
                              </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                              <label for="">Users</label>
                              <select name="user" id="user" class="form-control select2-single" is-visible="true">
                                <option value="">View All Investors</option>
                                @foreach($investors as $investor)
                                  <option value="{{ $investor->id }}" @if(isset($requestFilters['user']) && $requestFilters['user'] == $investor->id) selected @endif>{{ $investor->displayName() }}</option>
                                @endforeach
                              </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                          <div class="">
                              <label for="">Asset Status</label>
                              <select name="asset_status" id="" class="form-control">
                                <option value="">View AI-C/AINC</option>
                                <option value="aic">Custody</option>
                                <option value="ainc">Non-Custody</option>

                              </select>
                          </div>
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0">
                          <div class="">
                              <label for="">Investment Origin</label>
                              <select name="investment_origin" id="" class="form-control">
                               <option value="">View Platform/Off Platform</option>
                               <option value="platform">Platform</option>
                               <option value="offplatform">Off Platform</option>

                              </select>
                          </div>
                        </div>
                      </div>


                      <div class="row mt-sm-4 mt-0 d-sm-flex align-items-sm-center">
 
                        <div class="col-sm-5">
                          <div class="">
                              <button class="btn btn-primary mr-1 apply-portfolio-filters">Apply</button>
                              <button class="btn btn-default reset-portfolio-filters">Reset</button>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>


                </div>
                <div class="text-right mt-3 mb-2">
                    <div class="">
                        <a href="javascript:void(0)" class="btn btn-outline-primary download-portfolio-report-xlsx" report-type="csv">Download XLSX </a>
                        <a href="javascript:void(0)" class="btn btn-outline-primary download-portfolio-report-pdf" report-type="pdf"> Download PDF</a>
                    </div>
                </div>





                <div>
                  <div class="row">
                    <div class="col-sm-6">
                      <h3> Investment Type</h3>
                      <div id="investment_type" class="chartDiv"></div>
                    </div>
                    <div class="col-sm-6">
                      <h3> Sector Analysis</h3>
                      <div id="sector_analysis" class="chartDiv"></div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <h3> Business Stage Analysis</h3>
                      <div id="business_stage_analysis" class="chartDiv"></div>
                    </div>
                    <div class="col-sm-6">
                      <h3> Investment Route : Direct Vs Fund/Portfolio</h3>
                      <div id="investment_route" class="chartDiv"></div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <h3>Investment by Tax Year(Bar Graph)</h3>
                      <div id="investment_by_tax_bar" class="chartDiv"></div>
                    </div>
                    <div class="col-sm-6">
                      <h3> Investment by Tax Year(Pie Chart)</h3>
                      <div id="investment_by_tax_pie" class="chartDiv"></div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <h3>Portfolio Summary</h3>
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
                    </div>
               
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <h3>Top 5 Holdings</h3>
                      <div id="top_holdings"></div>
                                            
               
                  </div>
                </div> 

                <div class="row">
                    <div class="col-sm-12">
                      <h3>Investment Details</h3>
                       <table class="table table-bordered cust-table" id="investment_details_table">
                          <thead>
                             <tr class="">
                                            
                                <th width="10%">
                                   Gi Code
                                </th>
                                <th  width="10%">
                                   Client Name
                                </th>
                                <th class="subheader_cell-cust" width="10%">
                                   Investment/Product Name
                                </th>
                                <th class="subheader_cell-cust" width="9%">
                                   Amount
                                </th>
                                <th class="subheader_cell-cust" width="9%">
                                   No. of Shares
                                </th>
                                <th class="subheader_cell-cust" width="9%">
                                   Share Issue Price
                                </th>
                                <th class="subheader_cell-cust" width="9%">
                                   Share Issue Date
                                </th>
                                <th class="subheader_cell-cust" width="9%">
                                   Revaluation Date
                                </th>
                                <th class="subheader_cell-cust" width="9%">
                                   Current Share Price
                                </th>
                                <th class="subheader_cell-cust" width="9%">
                                   Total Company Valuation
                                </th>
                                <th class="subheader_cell-cust" width="10%">
                                   Total
                                </th>
                                 
                             </tr>
                          </thead>
                          <tbody id="investment_details_list">
                          </tbody>
                       </table>
                      
                                            
               
                  </div>
                </div>  

                  
                            
                        </div>
                         

        </div>
    </div>


</div>

  

@endsection

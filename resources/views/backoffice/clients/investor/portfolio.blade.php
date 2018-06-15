 <p>The Portfolio Summary dashboard allows you to select from a range of selection filters in order to refine and analyse the portfolios available.</p>
 <h5 class="mt-2 mb-0">Selection Filters</h5>


  <div class="gray-section border bg-gray p-3 @if(!$investor->hasAnyPermission(['backoffice_access'])) d-none @endif">
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
                <select name="user" id="user" class="d-none">
                  <option value="{{ $investor->id }}" selected >{{ $investor->first_name.' '.$investor->last_name }}</option>
                </select>
                <select name="firm" id="firm" class="d-none" >
                  <option value="" selected ></option>
                </select>
                <button class="btn btn-primary mr-1 apply-portfolio-filters">Apply</button>
                <button class="btn btn-default reset-portfolio-filters">Reset</button>
            </div>
          </div>
        </div>

      </div>
    </div>


  </div>
  @if($investor->hasAnyPermission(['backoffice_access']))
  <div class="text-right mt-3 mb-2">
      <div class="">
          <a href="javascript:void(0)" class="btn btn-outline-primary download-portfolio-report-xlsx" report-type="csv">Download XLSX </a>
          <a href="javascript:void(0)" class="btn btn-outline-primary download-portfolio-report-pdf" report-type="pdf"> Download PDF</a>
      </div>
  </div>
  @endif
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
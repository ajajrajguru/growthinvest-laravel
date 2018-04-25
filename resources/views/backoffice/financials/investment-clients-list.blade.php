


<div class="">
            <h1 class="section-title font-weight-medium text-primary mb-0">Client Investment</h1>
            <p class="text-muted">View the profile and the portfolio of the investors registered with us.</p>

            <h5 class="mt-2 mb-0">Selection Filters</h5>
            
            <div class="p-3 bg-gray">
                <div class="row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      <div class="inner-addon right-addon">
                        <i class="fa fa-calendar"></i>
                        <input type="text"  placeholder="Select From Date" class="form-control datepicker date_range rounded-0" name="duration_from" value="{{ (isset($requestFilters['duration_from'])) ? $requestFilters['duration_from'] : '' }}" @if(isset($requestFilters['duration']) && $requestFilters['duration'] != '') disabled @endif>
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="inner-addon right-addon">
                        <i class="fa fa-calendar"></i>
                        <input type="text"  placeholder="Select To Date" class="form-control datepicker date_range rounded-0" name="duration_to" value="{{ (isset($requestFilters['duration_to'])) ? $requestFilters['duration_to'] : '' }}" @if(isset($requestFilters['duration']) && $requestFilters['duration'] != '') disabled @endif>
                      </div>
                  </div>

                    <div class="col-md-4 mb-3 mb-sm-0">
                        <label for="">Firm Name</label>
                        <input type="hidden" name="firm_ids" value="{{ implode(',' ,$firm_ids) }}"> 
                        <select name="firm_name" class="form-control investorSearchinput select2-single"  >
                            <option value="">All Firms</option>
                            @foreach($firms as $firm)
                            <option @if(isset($requestFilters['firm']) && $requestFilters['firm'] == $firm->id) selected @endif value="{{ $firm->id }}">{{ $firm->name }}</option>
                            @endforeach

                        </select>
                        <em class="small">Select the firm whose investors you need to view</em>
                        
                    </div>
                    <div class="col-md-4 mb-3 mb-sm-0">
                        <label for="">Investor</label>
                        <select name="investor_name" class="form-control investorSearchinput select2-single"  >
                            <option value="">--</option>
                            @foreach($investors as $investor)
                            <option @if(isset($requestFilters['investor']) && $requestFilters['investor'] == $investor->id) selected @endif value="{{ $investor->id }}">{{ $investor->first_name.' '.$investor->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="">Investment</label>
                        <select name="investment" class="form-control investorSearchinput"  >
                            <option value="">All Investment</option>
                            @foreach($investmentList as $investment)
                            <option @if(isset($requestFilters['client-category']) && $requestFilters['client-category'] == $investment->id) selected @endif value="{{ $investment->id }}">{{ $investment->title }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="col-md-4">
                        <label for="">Client Categories</label>
                        <select name="client_category" class="form-control investorSearchinput"  >
                            <option value="">All client categories</option>
                            @foreach($clientCategories as $clientCategory)
                            <option @if(isset($requestFilters['client-category']) && $requestFilters['client-category'] == $clientCategory->id) selected @endif value="{{ $clientCategory->id }}">{{ $clientCategory->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="col-md-3 align-self-end text-right">
                      <button class="btn btn-primary mr-1 apply-investmentclient-filters">Apply</button>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm reset-investmentclient-filters">Reset filter</a>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="mt-3">
                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#columnVisibility">Column Visibility</a>  
                    <a href="javascript:void(0)" class="btn btn-outline-primary download-investmentclient-report" report-type="csv">Download CSV </a>
                    <a href="javascript:void(0)" class="btn btn-outline-primary download-investmentclient-report" report-type="pdf"> Download PDF</a>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table id="datatable-investment-client" class="table dataFilterTable table-hover table-solid-bg dt-responsive">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="w-search"> Invested Date</th>
                            <th class="w-search">Investment</th>
                            <th class="w-search">Investor</th>
                            <th class="w-search"> Firm </th>
                            <th class="w-search">   Invested Amount </th>
                            <th class="w-search">  Accrued </th>
                            <th class="w-search">  Paid </th>
                            <th class="w-search">  Due </th>
                            <th class="col-visble">  Parent Firm </th>
                            <th class="col-visble">  GI ID for the Investments </th>
                            <th class="col-visble">  GI ID for the Investor </th>
                            <th class="col-visble">  GI ID for the firm </th>
                            <th class="col-visble">  Transaction type </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                <div class="alert alert-info">
                  Total Invested Amount : <span id="total_invested">0</span> | Total Accrued Amount : <span id="total_accrude"></span> | Total Paid Amount : <span id="total_paid"></span> | Total Due Amount :<span id="total_due"></span>
                </div>
            </div>
        </div>

 <!-- Modal -->
    <div class="modal fade" id="columnVisibility" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Column Visibility</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body m-auto d-block">
            <div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="0" id="ch_0" checked>
                  <label class="custom-control-label" for="ch_0">Logo</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="1" id="ch_1" checked>
                  <label class="custom-control-label" for="ch_1">Invested Date</label>
                </div>
                 <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="2" id="ch_2" checked>
                  <label class="custom-control-label" for="ch_2">Investment</label>
                </div>
                 <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="3" id="ch_3" checked>
                  <label class="custom-control-label" for="ch_3">Investor</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="4" id="ch_4" checked>
                  <label class="custom-control-label" for="ch_4">Firm</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="5" id="ch_5" checked>
                  <label class="custom-control-label" for="ch_5">Invested Amount</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="6" id="ch_6" checked>
                  <label class="custom-control-label" for="ch_6">Accrued</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="7" id="ch_7" checked>
                  <label class="custom-control-label" for="ch_7">Paid</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="8" id="ch_8" checked>
                  <label class="custom-control-label" for="ch_8">Due</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="9" id="ch_9" >
                  <label class="custom-control-label" for="ch_9">Parent Firm</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="10" id="ch_10" >
                  <label class="custom-control-label" for="ch_10">GI ID for the Investments</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="11" id="ch_11" >
                  <label class="custom-control-label" for="ch_11">GI ID for the Investor</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="12" id="ch_12" >
                  <label class="custom-control-label" for="ch_12">GI ID for the firm</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="13" id="ch_13" >
                  <label class="custom-control-label" for="ch_13">Transaction type</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input inv-cli-cols" value="14" id="ch_14" checked>
                  <label class="custom-control-label" for="ch_14">Action</label>
                </div>

            </div>
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-primary alter-investmentclient-table">Save changes</button>
          </div>
        </div>
      </div>
    </div>

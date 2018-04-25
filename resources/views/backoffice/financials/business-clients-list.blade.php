

<div class="">
            <h1 class="section-title font-weight-medium text-primary mb-0">Business Investment</h1>
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
                   
                    <div class="col-md-3 align-self-end text-right">
                      <button class="btn btn-primary mr-1 apply-businessclient-filters">Apply</button>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm reset-businessclient-filters">Reset filter</a>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="mt-3">
                    
                    <a href="javascript:void(0)" class="btn btn-outline-primary download-businessclient-report" report-type="csv">Download CSV </a>
                    <a href="javascript:void(0)" class="btn btn-outline-primary download-businessclient-report" report-type="pdf"> Download PDF</a>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table id="datatable-business-client" class="table dataFilterTable table-hover table-solid-bg dt-responsive">
                    <thead>
                        <tr>
                            <th></th>
        
                            <th class="w-search">Investment</th>
                             <th class="w-search">   Investment Raised </th>
                            <th class="w-search">  Commision Accrued </th>
                            <th class="w-search">  Commision Paid </th>
                            <th class="w-search">  Commision Due </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                <div class="alert alert-info">
                  Total Invested Amount : <span id="total_invested">0</span> | Total Accrued Amount : <span id="total_accrude">0</span> | Total Paid Amount : <span id="total_paid">0</span> | Total Due Amount :<span id="total_due">0</span>
                </div>
            </div>
        </div>

  
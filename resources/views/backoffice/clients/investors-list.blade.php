<div class="tab-content">
    <div class="tab-pane active p-3" id="manage-investors" role="tabpanel">
        <div class="">
            <h1 class="section-title font-weight-medium text-primary mb-0">Investors</h1>
            <p class="text-muted">View the profile and the portfolio of the investors registered with us.</p>

            <h5 class="mt-2 mb-0">Selection Filters</h5>
            
            <div class="p-3 bg-gray">
                <div class="row">
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
                        <label for="">Investor Name</label>
                        <select name="investor_name" class="form-control investorSearchinput select2-single"  >
                            <option value="">--</option>
                            @foreach($investors as $investor)
                            <option @if(isset($requestFilters['investor']) && $requestFilters['investor'] == $investor->id) selected @endif value="{{ $investor->id }}">{{ $investor->first_name.' '.$investor->last_name }}</option>
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
                </div>
                <div class="row mt-3">
                    <div class="col-md-3 mb-3 mb-sm-0">
                        <label for="">Client Certifications</label>
                        <select name="client_certification" class="form-control investorSearchinput" >
                            <option value="">All Certifications</option>
                            @foreach($certificationTypes as $key=>$certificationType)
                            <option @if(isset($requestFilters['client-certification']) && $requestFilters['client-certification'] == $key) selected @endif value="{{ $key }}">{{ $certificationType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-sm-0">
                        <label for="">Nominee Account</label>
                        <select name="investor_nominee" class="form-control investorSearchinput" id="investor_nominee">
                            <option value="">--</option>
                            <option @if(isset($requestFilters['investor-nominee']) && $requestFilters['investor-nominee'] == "nominee") selected @endif value="nominee">Yes</option>
                            <option @if(isset($requestFilters['investor-nominee']) && $requestFilters['investor-nominee'] == "non_nominee") selected @endif value="non_nominee">No</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-sm-0">
                        <label for="">ID Verification</label>
                        <select name="idverified" class="form-control investorSearchinput" id="idverified">
                            <option value="">--</option>
                            <option @if(isset($requestFilters['idverified']) && $requestFilters['idverified'] == "yes") selected @endif value="yes">Yes</option>
                            <option @if(isset($requestFilters['idverified']) && $requestFilters['idverified'] == "no") selected @endif value="no">No</option>
                        </select>
                    </div>
                    <div class="col-md-3 align-self-end text-right">
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm reset-filters">Reset filter</a>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="mt-3">
                @if(isset($firm) && !empty($firm))
                    <a href="{{ url('backoffice/firm/'.$firm->gi_code.'/investor/registration')}}" class="btn btn-primary btn-sm">Add Investors</a>
                @else
                    <a href="{{ url('backoffice/investor/registration')}}" class="btn btn-primary btn-sm">Add Investors</a>
                @endif
                    <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary download-investor-csv" >Download CSV</a>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table id="datatable-investors" class="table dataFilterTable table-hover table-solid-bg dt-responsive">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="w-search" style="width: 250px;">Investor Name</th>
                            <th class="w-search">Certification Date</th>
                            <th class="w-search">Client Categorisation</th>
                            <th class="w-search" style="width: 100px;" width="100"> Parent Firm </th>
                            <th class="w-search"> Registered Date </th>
                            <th style="min-width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- /manage-investors -->

    <div class="tab-pane p-3" id="manage-businesses" role="tabpanel">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet ullam voluptatem ipsum voluptate, placeat. Suscipit, consequuntur rem quae, optio autem mollitia eius enim debitis soluta eos quod ipsa voluptatem fuga?
    </div> <!-- /manage-business -->
</div> 
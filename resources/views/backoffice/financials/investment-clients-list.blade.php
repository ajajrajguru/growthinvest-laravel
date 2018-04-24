
<div class="squareline-tabs">
    <ul class="nav nav-tabs">
            <li class="nav-item">
               <a class="nav-link d-none d-sm-block active "   href="{{url('backoffice/financials/investment-clients')}}">Client Investment </a>
           </li>
            <li class="nav-item">
               <a class="nav-link d-none d-sm-block"  href="{{url('backoffice/financials/business-clients')}}">Business Investment</a>
           </li>
 
       </ul>
</div>

<div class="">
            <h1 class="section-title font-weight-medium text-primary mb-0">Client Investment</h1>
            <p class="text-muted">View the profile and the portfolio of the investors registered with us.</p>

            <h5 class="mt-2 mb-0">Selection Filters</h5>
            
            <div class="p-3 bg-gray">
                <div class="row">
                     
                </div>
                <div class="row mt-3">
                    
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="mt-3">
                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#columnVisibility">Column Visibility</a>  
                    <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary download-investor-csv" >Download CSV</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary download-investor-csv" >Download PDF</a>
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

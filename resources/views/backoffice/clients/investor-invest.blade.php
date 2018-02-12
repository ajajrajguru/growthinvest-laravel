@extends('layouts.backoffice')

@section('js')
  @parent

<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/backoffice-investors.js') }}"></script>

<script type="text/javascript" src="{{ asset('/bower_components/select2/dist/js/select2.min.js') }}" ></script>
<link rel="stylesheet" href="{{ asset('/bower_components/select2/dist/css/select2.min.css') }}" >

<script type="text/javascript">
    
    $(document).ready(function() {
        // select2
        $('.select2-single').select2({
            // placeholder: "Search here"
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
                <a class="nav-link active d-none d-sm-block" data-toggle="tab" href="#invest">Invest</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-none d-sm-block" href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-profile')}}">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-none d-block" href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-news-update')}}">News/Updates</a>
            </li>
        </ul>
      </div>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane p-3 active" id="invest" role="tabpanel">
                <h4 class="mb-1">Investment Offers</h4>
                <p>In the table below we list all current offers available for Investment. There is some basic product information available on the table below, and more on the individual offer page, and in the available downloads. Please use the filters below to refine your search. If you have any questions on any of the available offers, or the investment process, please do not hesitate to contact our client services team on <a href="mailto:support@GrowthInvest.com">support@GrowthInvest.com</a> or call us on 020 7071 3945</p>
                
                <div class="gray-section border bg-gray p-3">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div>
                                <label for="">Company</label>
                                <select name="company" class="form-control">
                                  <option value="">All</option>
                                  @foreach($companyNames as $companyName)
                                    <option value="{{ $companyName->id }}">{{ ucfirst($companyName->title) }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="">Sector</label>
                                <select name="sector" id="" class="form-control">
                                    <option value="">All</option>
                                    @foreach($sectors as $sector)
                                    <option value="{{ $sector->id }}">{{ ucfirst($sector->name) }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="">Type</label>
                                <select name="type" id="" class="form-control">
                                    <option value="">All</option>
                                    @foreach($investmentOfferType as $typeKey => $type)
                                    <option value="{{ $typeKey }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="">Manager</label>
                                <select name="manager" id="" class="form-control">
                                    <option value="">All</option>
                                    @foreach($managers as $manager)
                                    <option value="{{ $manager }}">{{ ucfirst($manager) }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                        <div>
                          @foreach(investmentTaxStatus() as $taxStatus => $taxStatusVal)
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" name="tax_status[]" class="custom-control-input" value="{{ $taxStatus }}" id="che{{ $taxStatus }}">
                              <label class="custom-control-label" for="che{{ $taxStatus }}">{{ $taxStatusVal }}</label>
                            </div>
                          @endforeach
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" name="tax_status[]" class="custom-control-input checked-all" value="all" id="chall">
                              <label class="custom-control-label" for="chall">ALL</label>
                            </div>
                        </div>

                        <div class="mt-3 mt-sm-0">
                            <button class="btn btn-primary mr-1 apply-invest-filters">Apply</button>
                            <button class="btn btn-default reset-invest-filters">Reset</button>
                        </div>
                    </div>
                </div>
                
                <div class="text-right mt-3 mb-2">
                    <div class="">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#columnVisibility">Column Visibility</a>    
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable-investor-invest" class="table dataFilterTable table-hover table-striped-bg">
                        <thead>
                            <tr>
                                <th>Investment Offer</th>
                                <th>Manager</th>
                                <th>Tax Status</th>
                                <th>Investment Type</th>
                                <th>Investment Focus</th>
                                <th>Target Raise</th>
                                <th>Min Investment</th>
                                <th>Aount Raised (&pound; M)</th>
                                <th>Invest</th>
                                <th>Downloads</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                     
                </div>
            </div> <!-- /invest tab -->

            <div class="tab-pane p-3" id="profile" role="tabpanel">
            </div> <!-- /Profile -->

            <div class="tab-pane p-3" id="news-updates" role="tabpanel">
            </div> <!-- /News/Updates -->
        </div>
        <!-- /tabs -->
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
                  <input type="checkbox" class="custom-control-input invest-cols" value="0" id="ch_io" checked>
                  <label class="custom-control-label" for="ch_io">Investment Offer</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input invest-cols" value="1" id="ch_mgr" checked>
                  <label class="custom-control-label" for="ch_mgr">Manager</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input invest-cols" value="2" id="ch_ts" checked>
                  <label class="custom-control-label" for="ch_ts">Tax Status</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input invest-cols" value="3" id="ch_it" checked>
                  <label class="custom-control-label" for="ch_it">Investment Type</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input invest-cols" value="4" id="ch_if" checked>
                  <label class="custom-control-label" for="ch_if">Investment Focus</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input invest-cols" value="5" id="ch_tr" checked>
                  <label class="custom-control-label" for="ch_tr">Target Raise</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input invest-cols" value="6" id="ch_mi" checked>
                  <label class="custom-control-label" for="ch_mi">Min Investment</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input invest-cols" value="7" id="ch_amtr" checked>
                  <label class="custom-control-label" for="ch_amtr">Amount Raised (&poundl M)</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input invest-cols" value="8" id="ch_inv" checked>
                  <label class="custom-control-label" for="ch_inv">Invest</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input invest-cols" value="9" id="ch_dwn" checked>
                  <label class="custom-control-label" for="ch_dwn">Downloads</label>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-primary alter-table">Save changes</button>
          </div>
        </div>
      </div>
    </div>

</div>
 
    <style type="text/css">
        #datatable-investor-invest_filter{
            visibility: hidden;
        }
    </style>

@endsection


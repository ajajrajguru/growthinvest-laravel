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
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#invest">Invest</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-profile')}}">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-news-update')}}">News/Updates</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane p-3 active" id="invest" role="tabpanel">
                <h4 class="mb-1">Investment Offers</h4>
                <p>In the table below we list all current offers available for Investment. There is some basic product information available on the table below, and more on the individual offer page, and in the available downloads. Please use the filters below to refine your search. If you have any questions on any of the available offers, or the investment process, please do not hesitate to contact our client services team on <a href="mailto:support@GrowthInvest.com">support@GrowthInvest.com</a> or call us on 020 7071 3945</p>
                
                <div class="gray-section border bg-light p-3">
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
                                    <option value="{{ $sector->name }}">{{ ucfirst($sector->name) }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="">Type</label>
                                <select name="type" id="" class="form-control">
                                    <option value="">All</option>
                                    <option value="proposal">Single Company</option>
                                    <option value="fund">Fund</option>
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
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" name="tax_status[]" class="custom-control-input" value="eis" id="ch3">
                              <label class="custom-control-label" for="ch3">EIS</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" name="tax_status[]" class="custom-control-input" value="seis" id="ch4">
                              <label class="custom-control-label" for="ch4">SEIS</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" name="tax_status[]" class="custom-control-input" value="vct" id="ch5">
                              <label class="custom-control-label" for="ch5">VCT</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" name="tax_status[]" class="custom-control-input" value="iht" id="ch6">
                              <label class="custom-control-label" for="ch6">BR</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" name="tax_status[]" class="custom-control-input" value="sitr" id="ch7">
                              <label class="custom-control-label" for="ch7">SITR</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" name="tax_status[]" class="custom-control-input" value="all" id="ch8">
                              <label class="custom-control-label" for="ch8">ALL</label>
                            </div>
                        </div>

                        <div class="mt-3 mt-sm-0">
                            <button class="btn btn-primary mr-3 apply-invest-filters">Apply</button>
                            <button class="btnb btn-default reset-invest-filters">Reset</button>
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
                  <input type="checkbox" class="custom-control-input" id="ch1">
                  <label class="custom-control-label" for="ch1">Investment Offer</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="ch2">
                  <label class="custom-control-label" for="ch2">Manager</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="ch3">
                  <label class="custom-control-label" for="ch3">Tax Status</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="ch4">
                  <label class="custom-control-label" for="ch4">Investment Type</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="ch51">
                  <label class="custom-control-label" for="ch51">Investment Focus</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="ch61">
                  <label class="custom-control-label" for="ch61">Target Raise</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="ch71">
                  <label class="custom-control-label" for="ch71">Min Investment</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="ch81">
                  <label class="custom-control-label" for="ch81">Amount Raised (&poundl M)</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="ch91">
                  <label class="custom-control-label" for="ch91">Invest</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="ch10">
                  <label class="custom-control-label" for="ch10">Downloads</label>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-primary">Save changes</button>
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


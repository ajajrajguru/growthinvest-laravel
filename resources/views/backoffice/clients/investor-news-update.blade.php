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
                <a class="nav-link" data-toggle="tab" href="#invest">Invest</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#profile">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#news-updates">News/Updates</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane p-3" id="invest" role="tabpanel">
                <h4 class="mb-1">Investment Offers</h4>
                <p>In the table below we list all current offers available for Investment. There is some basic product information available on the table below, and more on the individual offer page, and in the available downloads. Please use the filters below to refine your search. If you have any questions on any of the available offers, or the investment process, please do not hesitate to contact our client services team on <a href="mailto:support@GrowthInvest.com">support@GrowthInvest.com</a> or call us on 020 7071 3945</p>
                
                <div class="gray-section border bg-light p-3">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div>
                                <label for="">Company</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="">Sector</label>
                                <select name="" id="" class="form-control">
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="">Type</label>
                                <select name="" id="" class="form-control">
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="">Manager</label>
                                <select name="" id="" class="form-control">
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                        <div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" class="custom-control-input" id="ch3">
                              <label class="custom-control-label" for="ch3">EIS</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" class="custom-control-input" id="ch4">
                              <label class="custom-control-label" for="ch4">SEIS</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" class="custom-control-input" id="ch5">
                              <label class="custom-control-label" for="ch5">VCT</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" class="custom-control-input" id="ch6">
                              <label class="custom-control-label" for="ch6">BR</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" class="custom-control-input" id="ch7">
                              <label class="custom-control-label" for="ch7">SITR</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                              <input type="checkbox" class="custom-control-input" id="ch8">
                              <label class="custom-control-label" for="ch8">ALL</label>
                            </div>
                        </div>

                        <div class="mt-3 mt-sm-0">
                            <a href="" class="btn btn-primary mr-3">Save</a>
                            <a href="" class="btnb btn-default">Reset</a>
                        </div>
                    </div>
                </div>
                
                <div class="text-right mt-3 mb-2">
                    <div class="">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#columnVisibility">Column Visibility</a>    
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped-bg">
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
                            <tr>
                                <td><a href="" target="_blank">lorem ipsum dollar</a></td>
                                <td></td>
                                <td>EIS</td>
                                <td>Single Company</td>
                                <td></td>
                                <td><div class="text-nowrap">&pound; 50,000</div></td>
                                <td>
                                    <div class="text-nowrap">&pound; 7,000</div>
                                </td>
                                <td>
                                    <div class="text-nowrap">&pound; 170,000</div>
                                </td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm">Invest</a>
                                </td>
                                <td>
                                    <a href="" class="btn btn-sm btn-link">Download</a>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="" target="_blank">lorem ipsum dollar</a></td>
                                <td></td>
                                <td>EIS</td>
                                <td>Single Company</td>
                                <td></td>
                                <td><div class="text-nowrap">&pound; 50,000</div></td>
                                <td>
                                    <div class="text-nowrap">&pound; 7,000</div>
                                </td>
                                <td>
                                    <div class="text-nowrap">&pound; 170,000</div>
                                </td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm">Invest</a>
                                </td>
                                <td>
                                    <a href="" class="btn btn-sm btn-link">Download</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> <!-- /invest tab -->

            <div class="tab-pane p-3 active" id="profile" role="tabpanel">
                <div class="media investor-info">
                    <div class="investor-avatar align-self-center mr-3">
                        <img class="rounded-circle" src="https://dummyimage.com/80x80" alt="Generic placeholder image">
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
                    <li class="list-unstyled"><a href="{{ url('backoffice/investor/'.$investor->gi_code.'/registration')}}">Registration: </a> Key contact and registration details including passwords.</li>
                    <li class="list-unstyled"><a href="{{ url('backoffice/investor/'.$investor->gi_code.'/client-categorisation')}}">Client Categorisation: </a> Amend current investor classification (eg High Net Worth, Sophisticated)</li>
                    <li class="list-unstyled"><a href="{{ url('backoffice/investor/'.$investor->gi_code.'/additional-information') }}">Additoinal Information: </a> Picture, Social Media and Investment Profile</li>
                    <li class="list-unstyled"><a href="{{  url('backoffice/investor/'.$investor->gi_code.'/investment-account') }}">Investment Account: </a> Full investment and transactional account details</li>
                </ul>

                <div class="row mt-5">
                    <div class="col-md-3">
                        <div class="">
                            <label for="">Identitiy Report</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="">
                            <label for="">Identitiy Report</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3 d-sm-flex">
                        <a href="" class="btn btn-primary align-self-sm-end">Save</a>
                    </div>
                </div>
            </div> <!-- /Profile -->

            <div class="tab-pane p-3" id="news-updates" role="tabpanel">
                <h4 class="mb-1">Message Board</h4>
                <p>Effectively communicate with your investors by posting and replying to their questions</p>

                <div class="form-group">
                    <a href="" class="btn btn-primary text-uppercase">post your question</a>
                </div>

                <!-- post question -->
                <div class="mt-4 mb-4 message-board">
                    <div class="media">
                        <div class="media-avatar mr-3">
                            <img class="" src="https://dummyimage.com/40x40" alt="Generic placeholder image">
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0 d-inline-block">Media heading</h5> <small class="border-right pr-1 ml-3">5th Feb 2017</small><small class="pl-1">08: 23 am</small>
                            <div>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</div>
                            <div class="mt-2"><a href="" class="mr-3 small">Reply</a><a href="" class="small">Delete</a></div>
                        </div>
                    </div>

                    <div class="media">
                        <div class="media-avatar mr-3">
                            <img class="" src="https://dummyimage.com/40x40" alt="Generic placeholder image">
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0 d-inline-block">Media heading</h5> <small class="border-right pr-1 ml-3">5th Feb 2017</small><small class="pl-1">08: 23 am</small>
                            <div>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</div>
                            <div class="mt-2"><a href="" class="mr-3 small">Cancel</a><a href="" class="small">Delete</a></div>
                            <div>
                                <textarea name="" id="" cols="" rows="3" class="form-control mb-2"></textarea>
                                <a href="" class="btn btn-sm btn-primary text-uppercase mb-3">submit</a>
                            </div>
                        </div>
                    </div>

                    <div class="media">
                        <div class="media-avatar mr-3">
                            <img class="" src="https://dummyimage.com/40x40" alt="Generic placeholder image">
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0 d-inline-block">Media heading</h5> <small class="border-right pr-1 ml-3">5th Feb 2017</small><small class="pl-1">08: 23 am</small>
                            <div>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</div>
                            <div class="mt-2"><a href="" class="mr-3 small">Reply</a><a href="" class="small">Delete</a></div>
                            
                            <div class="media mt-3">
                                <div class="media-avatar mr-3">
                                    <img src="https://dummyimage.com/40x40" alt="Generic placeholder image">
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 d-inline-block">Media heading</h5> <small class="border-right pr-1 ml-3">5th Feb 2017</small><small class="pl-1">08: 23 am</small>
                                    <div>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</div>
                                    <div class="mt-2"><a href="" class="mr-3 small">Reply</a><a href="" class="small">Delete</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /post question -->
                
                <div>
                    <div class="form-group">
                        <label>Post your question</label>
                        <textarea name="" id="" cols="" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <a href="" class="btn btn-primary text-uppercase">Submit Question</a>
                    </div>
                </div>
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
        #datatable-investors_filter{
            visibility: hidden;
        }
    </style>

@endsection


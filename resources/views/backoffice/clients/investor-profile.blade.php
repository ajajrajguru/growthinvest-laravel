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
                <a class="nav-link d-none d-sm-block"  href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-invest')}}">Invest</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-none d-sm-block"  href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-activity')}}">Activity</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active d-none d-sm-block"   href="#profile">Profile</a>
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
                @php

                    $identityReport = '';
                    $amlReport = '';
                    $watchlistReport = '';
                    foreach($onfidoReports as $onfidoReport){
                        if($onfidoReport->name == 'anti_money_laundering')
                            $amlReport = $onfidoReport->status_growthinvest;
                        elseif($onfidoReport->name == 'identity')
                            $identityReport = $onfidoReport->status_growthinvest;
                        elseif($onfidoReport->name == 'watchlist')
                            $watchlistReport = $onfidoReport->status_growthinvest;

                    }
                @endphp
                <div class="row mt-5 onfido-report-status-container">
                    <div class="col-md-3">
                        <input type="hidden" name="investor_gi" value="{{ $investor->gi_code }}">
                        <div class="">
                            <label for="">Identitiy Report</label>
                            <select class="form-control" name="identity_report" id="identity_report" >  
                             <option value="">Select</option>
                             <option value="completed" @if($identityReport == "completed") selected @endif >Complete</option>
                             <option value="complete_pending_evidence" @if($identityReport == "complete_pending_evidence") selected @endif >Complete Pending evidence</option>  
                             <option value="requested" @if($identityReport == "requested") selected @endif>Requested</option>  
                             <option value="inprogress" @if($identityReport == "inprogress") selected @endif>in progress</option>  
                             <option value="manual_kyc" @if($identityReport == "manual_kyc") selected @endif>Manual</option>  
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="">
                            <label for="">AML Report</label>
                            <select class="form-control" name="aml_report" id="aml_report" disabled >                 
                             <option value="">Select</option>
                             <option value="completed" @if($amlReport == "completed") selected @endif >Complete</option>
                             <option value="complete_pending_evidence" @if($amlReport == "complete_pending_evidence") selected @endif >Complete Pending evidence</option>  
                             <option value="requested" @if($amlReport == "requested") selected @endif>Requested</option>  
                             <option value="inprogress" @if($amlReport == "inprogress") selected @endif>in progress</option>  
                             <option value="manual_kyc" @if($amlReport == "manual_kyc") selected @endif>Manual</option>  
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="">
                            <label for="">Watchlist Report</label>
                            <select class="form-control" name="watchlist_report" id="watchlist_report" >                 
                             <option value="">Select</option>
                             <option value="completed" @if($watchlistReport == "completed") selected @endif >Complete</option>
                             <option value="complete_pending_evidence" @if($watchlistReport == "complete_pending_evidence") selected @endif >Complete Pending evidence</option>  
                             <option value="requested" @if($watchlistReport == "requested") selected @endif>Requested</option>  
                             <option value="inprogress" @if($watchlistReport == "inprogress") selected @endif>in progress</option>  
                             <option value="manual_kyc" @if($watchlistReport == "manual_kyc") selected @endif>Manual</option>  
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-sm-flex">
                        <a href="javascript:void(0)" class="btn btn-primary align-self-sm-end save-onfido-report-status">Save</a>
                    </div>
                    <br><br>
                     <div class="alert alert-success onfido-report-status-success d-none" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                       <span id="message"></span>
                    </div>
                     
                    <div class="alert alert-danger onfido-report-status-danger d-none" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                       <span id="message"></span>
                    </div>
                </div>
            </div> <!-- /Profile -->

            <div class="tab-pane p-3" id="news-updates" role="tabpanel">
            </div> <!-- /News/Updates -->
        </div>
        <!-- /tabs -->
    </div>

    <!-- Modal -->

</div>
 
    <style type="text/css">
        #datatable-investors_filter{
            visibility: hidden;
        }
    </style>

@endsection


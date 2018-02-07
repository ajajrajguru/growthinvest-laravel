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
                <a class="nav-link"  href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-invest')}}">Invest</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active"   href="#profile">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-news-update')}}">News/Updates</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane p-3" id="invest" role="tabpanel">
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


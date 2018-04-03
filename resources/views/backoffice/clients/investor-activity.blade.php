@extends('layouts.backoffice')

@section('js')
  @parent

<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/backoffice-investors.js') }}"></script>

<script type="text/javascript" src="{{ asset('/bower_components/select2/dist/js/select2.min.js') }}" ></script>
<link rel="stylesheet" href="{{ asset('/bower_components/select2/dist/css/select2.min.css') }}" >

<script type="text/javascript">

    $(document).ready(function() {
 
      $('input[name="duration_from"]').datepicker({
        format: 'dd-mm-yyyy'
      }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('input[name="duration_to"]').datepicker('setStartDate', minDate);
      });

      $('input[name="duration_to"]').datepicker({
        format: 'dd-mm-yyyy'
      }).on('changeDate', function (selected) {
        var maxDate = new Date(selected.date.valueOf());
        $('input[name="duration_from"]').datepicker('setEndDate', maxDate);
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
                <a class="nav-link active d-none d-sm-block" data-toggle="tab" href="#invest" >Activity</a>
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
            <div class="tab-pane p-3 active" id="activity" role="tabpanel">


                <div class="gray-section border bg-gray p-3">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div>
                                <select name="duration" class="form-control">
                                  <option value="">Select Period</option>
                                  @foreach($durationType as $durationKey=>$duration)
                                    <option value="{{ $durationKey }}" @if(isset($requestFilters['duration']) && $requestFilters['duration'] == $durationKey) selected @endif>{{ $duration }}</option>
                                  @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                              OR
                                <input type="text"  class="form-control datepicker date_range" name="duration_from" value="{{ (isset($requestFilters['duration_from'])) ? $requestFilters['duration_from'] : '' }}" @if(isset($requestFilters['duration']) && $requestFilters['duration'] != '') disabled @endif> -
                                <input type="text"  class="form-control datepicker date_range" name="duration_to" value="{{ (isset($requestFilters['duration_to'])) ? $requestFilters['duration_to'] : '' }}" @if(isset($requestFilters['duration']) && $requestFilters['duration'] != '') disabled @endif>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>

                                <select name="type" id="" class="form-control">
                                  <option value="">View All Activity Type</option>
                                  @foreach($activityTypes as $activityTypeKey=>$activityType)
                                    <option value="{{ $activityTypeKey }}" @if(isset($requestFilters['type']) && $requestFilters['type'] == $activityTypeKey) selected @endif>{{ $activityType }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>

                                <select name="companies" id="" class="form-control">
                                  <option value="">View All Companies</option>
                                  @foreach($businessListings as $businessListing)
                                    <option value="{{ $businessListing->id }}" @if(isset($requestFilters['companies']) && $requestFilters['companies'] == $businessListing->id) selected @endif>{{ $businessListing->title }}</option>
                                  @endforeach

                                </select>

                                <input type="hidden" name="user_id" value="{{ $investor->id }}">
                            </div>
                        </div>
                    </div>
                    <div class="d-sm-flex justify-content-sm-between align-items-sm-center">

                        <div class="mt-3 mt-sm-0">
                            <button class="btn btn-primary mr-1 apply-activity-filters">Apply</button>
                            <button class="btn btn-default reset-activity-filters">Reset</button>
                        </div>
                    </div>

                </div>

                <div class="text-right mt-3 mb-2">
                    <div class="">
                        <a href="javascript:void(0)" class="btn btn-outline-primary download-investor-activity-report" report-type="csv">Download CSV </a>
                        <a href="javascript:void(0)" class="btn btn-outline-primary download-investor-activity-report" report-type="pdf"> Download PDF</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable-investor-activity" class="table dataFilterTable table-hover table-solid-bg">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="w-search">Business Proposals/Funds</th>
                                <th class="w-search">User</th>
                                <th>Description</th>
                                <th class="w-search">Date</th>
                                <th class="w-search">Activity</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>


                </div>
            </div> <!-- /invest tab -->

            <div class="tab-pane p-3" id="profile" role="tabpanel">
            </div> <!-- /Profile -->

            <div class="tab-pane p-3" id="investor-activity" role="tabpanel">
            </div> <!-- /News/Updates -->
        </div>
        <!-- /tabs -->
    </div>

    <!-- Modal -->


</div>

    <style type="text/css">
        #datatable-investor-invest_filter{
            visibility: hidden;
        }
    </style>

@endsection

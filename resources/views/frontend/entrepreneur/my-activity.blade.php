@extends('layouts.frontend')

@section('js')
  @parent

<script type="text/javascript" src="{{ asset('js/frontend.js') }}"></script>
 

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


 
@section('frontend-content')


<div class="container pb-5">

<!-- mobile filter --> 
<div class="mobile-filter-btn rounded-circle pulse d-md-none"> 
    <i class="fa fa-filter"></i> 
</div> 
<!-- /mobile filter -->

 
<!-- tabs -->
<div class="squareline-tabs mt-5">

    @include('frontend.entrepreneur.topmenu')
</div>
<!-- /tabs -->

 
                <div class="gray-section border bg-gray p-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="bg-lightgray p-3">
                                <div>
                                    <select name="duration" class="form-control">
                                      <option value="">Select Period</option>
                                      @foreach($durationType as $durationKey=>$duration)
                                        <option value="{{ $durationKey }}" @if(isset($requestFilters['duration']) && $requestFilters['duration'] == $durationKey) selected @endif>{{ $duration }}</option>
                                      @endforeach

                                    </select>
                                </div>
                                <p class="text-center mt-3 mb-2 font-weight-bold">OR</p>
                                <div class="row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <div class="inner-addon right-addon">
                                          <i class="fa fa-calendar"></i>
                                          <input type="text"  placeholder="Select From Date" class="form-control datepicker date_range" name="duration_from" value="{{ (isset($requestFilters['duration_from'])) ? $requestFilters['duration_from'] : '' }}" @if(isset($requestFilters['duration']) && $requestFilters['duration'] != '') disabled @endif>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="inner-addon right-addon">
                                          <i class="fa fa-calendar"></i>
                                          <input type="text"  placeholder="Select To Date" class="form-control datepicker date_range" name="duration_to" value="{{ (isset($requestFilters['duration_to'])) ? $requestFilters['duration_to'] : '' }}" @if(isset($requestFilters['duration']) && $requestFilters['duration'] != '') disabled @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-sm-6">
                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select name="type" id="" class="form-control">
                                          <option value="">View All Activity Type</option>
                                          @foreach($activityTypes as $activityTypeKey=>$activityType)
                                            <option value="{{ $activityTypeKey }}" @if(isset($requestFilters['type']) && $requestFilters['type'] == $activityTypeKey) selected @endif>{{ $activityType }}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                                 
                            </div>

                            <div class="mt-sm-4 text-right">
                                <input type="hidden" name="user" value="{{ $user->id }}">
                                <button class="btn btn-primary mr-1 apply-activity-filters">Apply</button>
                                <button class="btn btn-default reset-activity-filters">Reset</button>
                            </div>
                        </div>
                    </div>

                   

                </div>

                <div class="text-right mt-3 mb-2">
                    <div class="">
                        <a href="javascript:void(0)" class="btn btn-outline-primary download-user-activity-report" report-type="csv">Download CSV </a>
                        <a href="javascript:void(0)" class="btn btn-outline-primary download-user-activity-report" report-type="pdf"> Download PDF</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable-user-activity" class="table dataFilterTable table-hover table-solid-bg">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="w-search">Business Proposals/Funds</th>
                                <th class="w-search">User</th>
                                <th class="col-visble">User Type</th>
                                <th class="col-visble">Firm Name</th>
                                <th class="col-visble">GI Code</th>
                                <th class="col-visble">Email</th>
                                <th class="col-visble">Telephone</th>
                                <th>Description</th>
                                <th class="w-search">Date</th>
                                <th class="w-search">Activity</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>


                </div>
             

 
</div> <!-- /container -->
 
 
 


@include('includes.footer')
@endsection
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
                                <select name="company" class="form-control">
                                  <option value="">All</option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
             
                                <select name="sector" id="" class="form-control">
                                    <option value="">All</option>
                                     
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                
                                <select name="type" id="" class="form-control">
                                    <option value="">All</option>
                              
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                  
                                <select name="manager" id="" class="form-control">
                                    <option value="">All</option>
                                     
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                         
                        <div class="mt-3 mt-sm-0">
                            <button class="btn btn-primary mr-1 apply-invest-filters">Apply</button>
                            <button class="btn btn-default reset-invest-filters">Reset</button>
                        </div>
                    </div>
                     
                </div>
                
                <div class="text-right mt-3 mb-2">
                    <div class="">
                        <a href="" class="btn btn-outline-primary" >Download CSV </a>     
                        <a href="" class="btn btn-outline-primary" > Download PDF</a>    
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable-investor-activity" class="table dataFilterTable table-hover table-solid-bg">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Business Proposals/Funds</th>
                                <th>User</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Activity</th>
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


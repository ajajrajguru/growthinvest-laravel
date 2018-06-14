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
                <a class="nav-link d-none d-sm-block"  href="{{ url('backoffice/investor/'.$investor->gi_code.'/portfolio')}}">Portfolio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active d-none d-sm-block" data-toggle="tab" href="#invest">Invest</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-none d-sm-block"  href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-activity')}}">Activity</a>
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
              @include('backoffice.investments.investment-list')  
            </div> <!-- /invest tab -->

            <div class="tab-pane p-3" id="profile" role="tabpanel">
            </div> <!-- /Profile -->

            <div class="tab-pane p-3" id="news-updates" role="tabpanel">
            </div> <!-- /News/Updates -->
        </div>
        <!-- /tabs -->
    </div>

    

</div>
 
    

@endsection


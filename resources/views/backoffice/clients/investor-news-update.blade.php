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
                <a class="nav-link d-none d-sm-block" href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-invest')}}">Invest</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-none d-sm-block"  href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-activity')}}">Activity</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-none d-sm-block" href="{{ url('backoffice/investor/'.$investor->gi_code.'/investor-profile')}}">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active d-none d-sm-block" data-toggle="tab" href="#news-updates">News/Updates</a>
            </li>
        </ul>
    </div>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane p-3" id="invest" role="tabpanel">
            </div> <!-- /invest tab -->

            <div class="tab-pane p-3 " id="profile" role="tabpanel">
            </div> <!-- /Profile -->

            <div class="tab-pane p-3 active" id="news-updates" role="tabpanel">
                <h4 class="mb-1">Message Board</h4>
                <p>Effectively communicate with your investors by posting and replying to their questions</p>

                <div class="form-group">
                    <button class="btn btn-primary text-uppercase post-your-question">post your question</button>
                </div>

                <!-- post question -->
                <div class="mt-4 mb-4 message-board main-media-container">
                    @foreach($comments as $comment)
                    {!!  View::make('backoffice.clients.news-update-content', compact('comment'))->render() !!}
                    @endforeach
                </div>
                <!-- /post question -->
                
                <div class="submit-query-cont post-your-question-cont d-none">
                    <div class="form-group">
                        <label>Post your question</label>
                        <textarea name="" id="" cols="" rows="3" class="form-control" placeholder="what is your question?"></textarea>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary text-uppercase submit-query" parent-id="0">Submit Question</button>
                        <input type="hidden" id="question_type" value="wm-investors-qa">
                        <input type="hidden" id="object_type" value="App\User">
                        <input type="hidden" id="object_id" value="{{ $investor->id }}">
                    </div>
                </div>
            </div> <!-- /News/Updates -->
        </div>
        <!-- /tabs -->
    </div>

 
</div>
 
    <style type="text/css">
        #datatable-investors_filter{
            visibility: hidden;
        }
    </style>

@endsection


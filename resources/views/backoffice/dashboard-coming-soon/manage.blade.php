@extends('layouts.backoffice')

@section('js')
  @parent
 
  <script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
  <script type="text/javascript">
    
    $(document).ready(function() {
        $( ".firm_actions" ).change(function() {

            var gi_code = $(this).attr('gi_code')
            var sel_val = $(this).val();
            switch(sel_val){
                case 'edit' : 
                            var action_url = '/backoffice/firms/'+gi_code;
                            window.open(action_url);
                break;
            }
           
        });
    });
</script>

 
@endsection
@section('backoffice-content')
<div class="container">

        @php
            echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
        @endphp

         @include('includes.manage-tabs')

        <div class="mt-4 bg-white border border-gray p-4">

            <div class="row">
                <div class="col-md-6">
                    <h1 class="section-title font-weight-medium text-primary mb-0">{{$page_title}}</h1>
                    <p class="text-muted"></p>
                </div>
                 
            </div>

            <div class="table-responsive mt-3">
                @include('backoffice.coming-soon')
            </div>
        </div>
    </div>

    <style type="text/css">
        #datatable-firms_filter{
            display: none;
        }
    </style>
 
@endsection

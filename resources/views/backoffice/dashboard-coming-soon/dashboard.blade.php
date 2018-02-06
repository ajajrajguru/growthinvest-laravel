@extends('layouts.backoffice')

@section('js')
  @parent

<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>



@endsection
@section('backoffice-content')

<div class="container">
    @php
        echo View::make('includes.breadcrumb')->with([ "breadcrumbs"=>$breadcrumbs])
    @endphp
    <div class="row mt-5 mx-0">
        <div class="col-md-2 bg-white px-0">
            @include('includes.side-menu')
        </div>

        <div class="col-md-10 bg-white border border-gray border-left-0 border-right-0">
            <div class="tab-content">


                <div class="tab-pane fade show active" id="add_clients" role="tabpanel">
                     <div class="mt-4 p-2">

                        <h1 class="section-title font-weight-medium text-primary mb-0">{{$page_title}}</h1>
                        <p class="text-muted">{{$page_short_desc}}</p>
                        @include('backoffice.coming-soon')
                    </div>
                </div>

            </div>
        </div>
    </div>

</div> 

@endsection

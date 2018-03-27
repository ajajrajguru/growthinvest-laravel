@extends('layouts.backoffice')

@section('js')
  @parent

  <script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>
  <script type="text/javascript">

    $(document).ready(function() {
        // $( ".firm_actions" ).change(function() {

        //     var gi_code = $(this).attr('gi_code')
        //     var sel_val = $(this).val();
        //     switch(sel_val){
        //         case 'edit' :
        //                     var action_url = '/backoffice/firms/'+gi_code;
        //                     window.open(action_url);
        //         break;
        //     }

        // });

        $(document).on('change', '.firm_actions', function() {
           var editUrl = $('option:selected', this).attr('edit-url');
           if(editUrl!=''){
            window.open(editUrl);
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
                    <h1 class="section-title font-weight-medium text-primary mb-0">Firms</h1>
                    <p class="text-muted">View all Firms</p>
                </div>
                <div class="col-md-6">
                    <div class="float-right">

                        <a href="{{ url('/backoffice/firms/add')}}" class="btn btn-primary">Add Firm</a>
                        <a href="{{ url('backoffice/firm/export-firm')}}" class="btn btn-outline-primary">Download CSV</a>


                    </div>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table id="datatable-firms" class="table dataFilterTable table-hover table-solid-bg">
                    <thead>
                        <tr>
                            <th >Logo</th>
                            <th class="w-search">Firm Name</th>
                            <th class="w-search">Firm Type</th>
                            <th class="w-search">Parent Firm</th>
                            <th class="w-search">Platform GI Code</th>
                            <th style="min-width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="filters">
                            <td></td>
                            <td class="data-search-input" data-search="name"></td>
                            <td class="data-search-input" data-search="type"></td>
                            <td class="data-search-input" data-search="parent-firm"></td>
                            <td class="data-search-input" data-search="gi-code"></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($firms as $firm)
                                <tr >
                                    <td></td>
                                    <td><a class="font-weight-medium" href="{{ url('backoffice/firms/'.$firm->gi_code.'/')}}">{{ title_case($firm->name) }} </a></td>
                                    <td>{{ title_case($firm->firmType()->name) }} </td>
                                    <td>{{ (!empty($firm->getParentFirm())) ? title_case($firm->getParentFirm()->name) :'' }}</td>
                                    <td>{{ $firm->gi_code }}</td>
                                    <td>
                                        <select class="form-control firm_actions" data-id="78523"   gi_code="{{ $firm->gi_code }}">
                                        <option>--select--</option>
                                        <option value="edit" edit-url="{{ url('backoffice/firms/'.$firm->gi_code.'/')}}">View Firm Details</option>
                                        <option value="view_wm_commissions">View Investment Clients</option>
                                        <option value="view_introducer_commissions">View Business Clients</option>
                                        </select>
                                    </td>
 
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style type="text/css">
        #datatable-firms_filter{
            display: none;
        }
    </style>

@endsection

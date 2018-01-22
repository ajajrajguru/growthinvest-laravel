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

        <div class="mt-4 bg-white border border-gray p-4">

            <div class="row">
                <div class="col-md-6">
                    <h1 class="section-title font-weight-medium text-primary mb-0">Firms</h1>
                    <p class="text-muted">View all Firms</p>
                </div>
                <div class="col-md-6">
                    <div class="float-right">
                        <a href="/growthinvest-ui/admin/add-user/" class="btn btn-primary">Add Firm</a>
                        <a href="{{ url('backoffice/firm/export-firm')}}" class="btn btn-link">Download CSV</a>
                
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table id="datatable-firms" class="table dataFilterTable table-hover table-striped-bg">
                    <thead>
                        <tr>
                            <th class="w-search">Logo</th>
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
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($firms as $firm)
                                <tr >
                                    <td></td>
                                    <td><a>{{ title_case($firm->name) }} </a></td>
                                    <td>{{ title_case($firm->firmType()->name) }} </td>
                                    <td>{{ (!empty($firm->getParentFirm())) ? title_case($firm->getParentFirm()->name) :'' }}</td>
                                    <td>{{ $firm->gi_code }}</td>
                                    <td>
                                        <select data-id="78523" class="firm_actions">
                                        <option>--select--</option>
                                        <option value="view_firm">View Firm Details</option>
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

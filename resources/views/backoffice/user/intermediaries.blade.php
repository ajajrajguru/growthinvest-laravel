@extends('layouts.backoffice')

@section('js')
  @parent

<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {
        $( ".firm_actions" ).change(function() {
           var editUrl = $(this).attr('edit-url')
           window.open(editUrl);
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
        @include('includes.notification')

        <div class="mt-4 bg-white border border-gray p-4">

            <div class="row">
                <div class="col-md-6">
                    <h1 class="section-title font-weight-medium text-primary mb-0">Intermediary Registrations</h1>
                    <p class="text-muted">Please see below all current unapproved registration for intermediaries.</p>

                </div>
                <div class="col-md-6">
                    <div class="float-right ">
                       <!--  <a href="{{ url('backoffice/user/add/step-one')}}" class="btn btn-primary">Add User</a>
                        <button type="button" class="btn btn-link">Download CSV</button> -->
                        <button type="button" class="btn btn-outline-primary btn-sm mt-3 select-all-user">Select All</button>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-3 select-none-user d-none">Select None</button>
                        <button type="button" class="btn btn-outline-danger btn-sm mt-3 delete-all-user d-none">Delete Selected Entries</button>


                    </div>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table id="datatable-Intermediary" class="table dataFilterTable table-hover table-solid-bg">
                    <thead>
                        <tr>
                            <th style="min-width: 20px;"></th>
                            <th class="w-search">Intermediary Details</th>
                            <th class="w-search">Company Name</th>
                            <th class="w-search">Company Decription</th>
                            <th class="w-search">Submitted On</th>
                            <th class="w-search">LGBR Intermediary</th>
                            <th style="min-width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="filters">
                            <td></td>
                            <td class="data-search-input" data-search="detail"></td>
                            <td class="data-search-input" data-search="company-name"></td>
                            <td class="data-search-input" data-search="description"></td>
                            <td class="data-search-input" data-search="submitted-on"></td>
                            <td class="data-search-input" data-search="lgbr"></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @php
                            $compInfo = (!empty($user->userAdditionalInfo())) ? $user->userAdditionalInfo()->data_value : [];
                            @endphp
                            <tr >
                                <td>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input delete_intm_users" name="intermediary_user_delete[]" id="{{ $user->id }}_check" value="{{ $user->id }}">
                                      <label class="custom-control-label" for="{{ $user->id }}_check"></label>
                                    </div>
                                </td>
                                <td><a href="{{ url('backoffice/user/'.$user->gi_code.'/intermediary-registration')}}"><b>{{  title_case($user->first_name.' '.$user->last_name) }}</b> <br>{{  $user->email }}</a></td>

                                <td>{{ (isset($compInfo['company'])) ? title_case($compInfo['company']) : ''}} </td>
                                <td>{{ (isset($compInfo['typeaccount']) && $compInfo['typeaccount']) ? title_case($compInfo['typeaccount']) : ''}}</td>
                                <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                                <td>{{  $user->lgbr }}</td>
                                    <td>
                                    <!-- <select data-id="78523" class="firm_actions" edit-url="{{ url('backoffice/user/'.$user->gi_code.'/step-one')}}">
                                    <option>--select--</option>
                                    <option value="edit-intermediary">Edit Profile</option>
                                    </select> -->
                                    <a href="{{ url('backoffice/user/'.$user->gi_code.'/intermediary-registration')}}">View Profile</a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style type="text/css">
        #datatable-Intermediary_filter{
            display: none;
        }
    </style>

@endsection


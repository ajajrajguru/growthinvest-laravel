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

        <div class="mt-4 bg-white border border-gray p-4">

            <div class="row">
                <div class="col-md-6">
                    <h1 class="section-title font-weight-medium text-primary mb-0">{{ $userType}}</h1>
                    @if($userType == 'User')
                    <p class="text-muted">View all Intermediaries registered with us.</p>
                    @else
                    <p class="text-muted">Please see below all current unapproved registration for intermediaries.</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="float-right">
                        <a href="{{ url('backoffice/user/add/step-one')}}" class="btn btn-primary">Add User</a>
                        <button type="button" class="btn btn-link">Download CSV</button>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table id="datatable-users" class="table dataFilterTable table-hover table-striped-bg">
                    <thead>
                        <tr>
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
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user) 
                            @php

                            $compInfo = (!empty($user->userAdditionalInfo())) ? $user->userAdditionalInfo()->data_value : [];   
                            @endphp
                            <tr >
                                <td>{{  title_case($user->first_name.' '.$user->last_name) }} <br>{{  $user->email }}</td>
                                
                                <td>{{ (isset($compInfo['company'])) ? title_case($compInfo['company']) : ''}} </td>
                                <td>{{ (isset($compInfo['typeaccount']) && $compInfo['typeaccount']) ? title_case($compInfo['typeaccount']) : ''}}</td>
                                <td>{{   date('d/m/Y', strtotime($user->created_at)) }}</td>
                                <td>-</td>
                                    <td>
                                    <select data-id="78523" class="firm_actions" edit-url="{{ url('backoffice/user/'.$user->gi_code.'/step-one')}}">
                                    <option>--select--</option>
                                    <option value="edit-intermediary">Edit</option>
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
        #datatable-users_filter{
            display: none;
        }
    </style>
 
@endsection


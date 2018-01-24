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
                    <h1 class="section-title font-weight-medium text-primary mb-0">View Users</h1>

                    <p class="text-muted">View all Intermediaries registered with us.</p>

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
                            <th class="w-search">Name</th>
                            <th class="w-search">Email</th>
                            <th class="w-search">Role</th>
                            <th class="w-search">Firm</th>
                            <th style="min-width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="filters">
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr >
                                <td><b>{{  title_case($user->first_name.' '.$user->last_name) }}</b></td>
                                <td><a class="investor_email" href="mailto: {{  $user->email }}">{{  $user->email }}</a></td>
                                <td>{{ title_case($user->roles()->pluck('display_name')->implode(' ')) }} </td>
                                <td>{{   (!empty($user->firm))?$user->firm->name:'' }}</td>
                                    <td>
                                    <select data-id="78523" class="firm_actions form-control form-control-sm" edit-url="{{ url('backoffice/user/'.$user->gi_code.'/step-one')}}">
                                    <option>--select--</option>
                                    <option value="edit-intermediary">Edit User</option>
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


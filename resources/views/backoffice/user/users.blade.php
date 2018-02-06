@extends('layouts.backoffice')

@section('js')
  @parent
<script type="text/javascript">

    var userRoles = <?php echo json_encode($roles);?>;
    console.log(userRoles)
</script>
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
                        <a href="{{ url('backoffice/user/export-users')}}" class="btn btn-link">Download CSV</a>

                    </div>
                </div>
            </div>

            <div class="card bg-light mt-3 d-sm-none" id="toggle-mob">
              <div class="card-body text-center">
                <label class="card-text font-weight-medium">The below table has been optimized for mobile view. Click the below button to view all columns.</label>
                   <div class="btn-group-toggle" data-toggle="buttons">
                       <label class="btn btn-sm btn-outline-primary toggle-btn">
                           <input type="checkbox" checked autocomplete="off" name="toggle-mob"> Toggle Columns
                       </label>
                   </div>
              </div>
            </div>

            <div class="table-responsive mt-3">
                <table id="datatable-users" class="table dataFilterTable table-hover table-solid-bg">
                    <thead>
                        <tr>
                            <th class="w-search">Name</th>
                            <th class="w-search toggle-mob">Email</th>
                            <th class="w-search toggle-mob">Role</th>
                            <th class="w-search">Firm</th>
                            <th class="toggle-mob" style="min-width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="filters">
                            <td class="user-search-input" data-search="name"></td>
                            <td class="user-search-input toggle-mob" data-search="email"></td>
                            <td class="user-search-input toggle-mob" data-search="role"></td>
                            <td class="user-search-input" data-search="firm"></td>
                            <td class="toggle-mob"></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr >
 
                                <td><b><a href="{{ url('backoffice/user/'.$user->gi_code.'/step-one')}}">{{  title_case($user->first_name.' '.$user->last_name) }}</a></b></td>
                                <td class="toggle-mob">{{  $user->email }}</td>
                                <td class="toggle-mob">{{ title_case($user->roles()->pluck('display_name')->implode(' ')) }} </td>
                                <td>@if(!empty($user->firm)) <a href="{{ url('backoffice/firms/'.$user->firm->gi_code.'/')}}" target="_blank">{{  $user->firm->name  }}</a> @endif</td>
                                <td class="toggle-mob">
                                    <!-- <select data-id="78523" class="firm_actions form-control form-control-sm" edit-url="{{ url('backoffice/user/'.$user->gi_code.'/step-one')}}">
                                    <option>--select--</option>
                                    <option value="edit-intermediary">Edit Profile</option>
                                    </select> -->
                                    <a href="{{ url('backoffice/user/'.$user->gi_code.'/step-one')}}">View Profile</a>
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


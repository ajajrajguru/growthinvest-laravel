@extends('layouts.backoffice')

@section('title', '| Users')

@section('js')
 @parent

<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>

<script type="text/javascript">
</script>
@endsection

@section('backoffice-content')

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-sm-6">
            <h1 class="section-title font-weight-medium text-primary mb-0">
                <i class="fa fa-users"></i> User Administration
            </h1>
        </div>
        <div class="col-sm-6">
            <div class="float-right">
                <a href="{{ route('roles.index') }}" class="btn btn-link">Roles</a>
                <a href="{{ route('permissions.index') }}" class="btn btn-link">Permissions</a>
            </div>
        </div>
    </div><hr>
    <!-- <h3><i class="fa fa-users"></i> User Administration <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a>
    <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h3>
    <hr> -->

    
    <div class="por">
    <a href="{{ route('users.create') }}" class="btn btn-primary poa" style="top: 0; right: 0;">Add User</a>
    <div class="table-responsive">
        <table id="userAdmin" class="table table-hover table-solid-bg">

            <thead>
                <tr>
                    <th width="20%">Name</th>
                    <th width="20%">Email</th>
                    <th width="20%">Date/Time Added</th>
                    <th width="20%">User Roles</th>
                    <th width="20%">Operations</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr>

                    <td>{{ $user->first_name .' '. $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                    <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
                    <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary pull-left" style="margin-right: 3px;">Edit</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-outline-danger']) !!}
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    </div>

    

</div>

@endsection
{{-- \resources\views\permissions\index.blade.php --}}
@extends('layouts.backoffice')

@section('title', '| Permissions')

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
                <i class="fa fa-key"></i> Available Permissions
            </h1>
        </div>
        <div class="col-sm-6">
            <div class="float-right">
                <a href="{{ route('users.index') }}" class="btn btn-link">Users</a>
                <a href="{{ route('roles.index') }}" class="btn btn-link pull-right">Roles</a></h3>
            </div>
        </div>
    </div><hr>

    <!-- <h3><i class="fa fa-key"></i>Available Permissions

    <a href="{{ route('users.index') }}" class="btn btn-default pull-right">Users</a>
    <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a></h3>
    <hr> -->
    
    <div class="por">
    <a href="{{ URL::to('permissions/create') }}" class="btn btn-primary poa" style="top: 0; right: 0;">Add Permission</a>
    <div class="table-responsive">
        <table id="availablePermissions" class="table table-hover table-solid-bg">

            <thead>
                <tr>
                    <th width="80%">Permissions</th>
                    <th width="20%">Operation</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td> 
                    <td>
                    <a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="btn btn-sm btn-outline-primary pull-left" style="margin-right: 3px;">Edit</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id] ]) !!}
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
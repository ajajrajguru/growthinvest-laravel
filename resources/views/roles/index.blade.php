{{-- \resources\views\roles\index.blade.php --}}
@extends('layouts.backoffice')

@section('title', '| Roles')

@section('js')
 @parent

<script type="text/javascript" src="{{ asset('js/backoffice.js') }}"></script>

<script type="text/javascript">
</script>
@endsection

@section('content')

<div class="container mt-5">
    <h3><i class="fa fa-key"></i> Roles

    <a href="{{ route('users.index') }}" class="btn btn-default pull-right">Users</a>
    <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h3>
    <hr>

    <div class="por">
    <a href="{{ URL::to('roles/create') }}" class="btn btn-primary poa" style="top: 0; right: 0;">Add Role</a>
    <div class="table-responsive">
        <table id="rolesTable" class="table table-hover table-solid-bg" style="word-break: break-all;">
            <thead>
                <tr>
                    <th width="15%">Role</th>
                    <th width="70%">Permissions</th>
                    <th width="15%">Operation</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>

                    <td>{{ $role->name }}</td>

                    <td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>{{-- Retrieve array of permissions associated to a role and convert to string --}}
                    <td>
                    <a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-sm btn-outline-primary pull-left" style="margin-right: 3px;">Edit</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id] ]) !!}
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